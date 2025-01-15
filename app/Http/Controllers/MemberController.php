<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ljkh;
use App\Models\JobList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $id_mch = $request->input('id_mch') ?? $request->session()->get('id_mch') ?? $user->id_mch;
        $request->session()->put('id_mch', $id_mch);

        $machineName = $this->machineName($id_mch);

        $ljkh = ljkh::select('*')
            ->where('id_mch', $id_mch)
            ->whereIn('status', ['ready', 'In progress', 'queued', 'Hold'])
            ->orderByRaw("(CASE 
                WHEN status = 'ready' THEN 1 
                WHEN status = 'In progress' THEN 2
                ELSE 3 END), job_id")
            ->first();

        $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $id_mch)->first();

        return view('member.index', compact('ljkh', 'id_mch', 'jobList', 'machineName'));
    }

    private function machineName($id_mch)
    {
        switch ($id_mch) {
            case 302:
                return 'Okuma 1';
            case 303:
                return 'Okuma 3';
            case 304:
                return 'MPF';
            case 305:
                return 'Kuraki';
            case 317:
                return 'Okuma 3';
            case 320:
                return 'Kaoming 1';
            case 321:
                return 'Kaoming 2';
            case 322:
                return 'VOM';
            case 323:
                return 'Setting';
            case 325:
                return 'HOWA';
            case 326:
                return 'MCR BIII';
            default:
                return 'Mesin Tidak Diketahui';
        }
    }

    public function indexJob(Request $request)
    {
        $user = $request->session()->get('id_mch');
        $jobList = JobList::whereIn('status_job', ['queued', 'Hold'])
            ->where('id_mch', $user)
            ->orderByRAW("FIELD(priority, 'prioritas', 'High', 'Medium', 'Low') ASC")
            ->with('project')
            ->get();

        if ($request->ajax()) {
            return Datatables::of($jobList)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-outline-primary text-center btn-sm takeJob" 
                data-id="' . $row->id_jobList . '">Ambil</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('member.index', compact('jobList'));
    }

    public function takeJob($id_jobList, Request $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->session()->get('id_mch');
            
            // Temukan JobList yang cocok
            $jobList = JobList::where('id_mch', $user)
                ->where('id_jobList', $id_jobList)
                ->where(function ($query) {
                    $query->where('status_job', 'queued')
                        ->orWhere('status_job', 'Hold');
                })
                ->first();
            
            if (!$jobList) {
                DB::rollBack();
                return response()->json(['error' => 'Job list not found or not in queued/hold status'], 404);
            }
            
            // Perbarui status jobList
            $jobList->update(['status_job' => 'ready']);
            
            // Temukan ljkh yang cocok
            $ljkh = ljkh::where('id_mch', $user)
                ->where('job_id', $jobList->id_jobList)
                ->where(function ($query) {
                    $query->where('status', 'queued')
                        ->orWhere('status', 'Hold');
                })
                ->first();
            
            if (!$ljkh) {
                DB::rollBack();
                return response()->json(['error' => 'ljkh not found or not in queued/hold status'], 404);
            }
            
            // Perbarui status ljkh
            $ljkh->update(['status' => 'ready']);
            
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function submit(Request $request)
    {
        try {
            $date = Carbon::now()->toDateString();
            $start = Carbon::now()->toTimeString();
            $time = substr($start, 0, 5);
            $user = Auth::user();
            $idActivity = $request->input('id_activity');
            $idMch = $request->session()->get('id_mch');
            
            $ljkh = ljkh::where('id_mch', $idMch)->where('status', 'In progress')->latest()->first();
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)->where('status_job', 'In progress')->latest()->first();

            DB::beginTransaction();
            $ljkh->update(['stop' => $start]);
            $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
            $ljkh->update([
                'prod_hour' => $prodHour,
                'status'    => 'Idle/Downtime'
            ]);
            $jobList->update(['status_job' => 'Idle/Downtime']);
            ljkh::create([
                'job_id'        => $ljkh->job_id,
                'die_part'      => $ljkh->die_part,
                'project'       => 'Idle Time',
                'activity_name' => $request->activity_name,
                'Date'          => $date,
                'start'         => $time,
                'name'          => $user->name,
                'id_mch'        => $idMch,
                'work_ctr'      => 'MCH-PREF',
                'id_job'        => $idActivity,
                'sub'           => $user->sub,
                'status'        => 'running',
            ]);
            Session::forget('status');
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data keterangan downtime/idle berhasil disimpan!']);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data DT/IDLE: ' . $e->getMessage());
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data DT/IDLE: ' . $e->getMessage()], 404);
        }
    }

    public function submitStop(Request $request)
    {
        try {
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);
            $user = Auth::user();
            $idMch = $request->session()->get('id_mch');
            DB::beginTransaction();

            $ljkhRunning = ljkh::where('id_mch', $idMch)
                ->where(function ($query) {
                    $query->where('id_job', 'like', 'N000%')
                        ->orWhere('id_job', 'like', 'G000%');
                })->where('status', 'running')->orderBy('id_ljkh')->first();

            if ($ljkhRunning) {
                $ljkhRunning->update([
                    'stop'      => $time,
                    'status'    => 'Complete'
                ]);
                $prodHour = $this->prodHour($ljkhRunning->stop, $ljkhRunning->start);
                $ljkhRunning->update(['prod_hour' => $prodHour]);
            }

            $ljkhCont = ljkh::where('id_mch', $idMch)->where('status', 'Idle/Downtime')->latest()->first();
            if ($ljkhCont) {
                ljkh::create([
                    'job_id'    => $ljkhCont->job_id,
                    'die_part'  => $ljkhCont->die_part,
                    'project'   => $ljkhCont->project,
                    'name'      => $user->name,
                    'id_mch'    => $idMch,
                    'work_ctr'  => 'MCH-PREF',
                    'id_job'    => $ljkhCont->id_job,
                    'sub'       => $user->sub,
                    'status'    => 'ready',
                ]);
            }

            $jobList = JobList::where('id_mch', $idMch)
                ->where('status_job', 'Idle/Downtime')
                ->latest()
                ->first();

            if ($jobList) {
                $jobList->update(['status_job' => 'ready']);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'downtime/idle selesai']);
        } catch (\Exception $e) {
            Log::error('Gagal!, fungsi submitStop DT/IDLE: ' . $e->getMessage());
            DB::rollback();
            return response()->json(['error' => true, 'message' => 'Gagal!, fungsi submitStop DT/IDLE: ' . $e->getMessage()], 404);
        }
    }

    public function showJobMember($id_ljkh)
    {
        $ljkh = ljkh::find($id_ljkh);
        // dd($ljkh);
        return response()->json($ljkh);
    }

    public function jobStart(Request $request)
    {
        try {
            DB::beginTransaction();
            $date = Carbon::now()->toDateString();
            $start = Carbon::now()->toTimeString();
            $time = substr($start, 0, 5);
            $idMch = $request->session()->get('id_mch');
            $user = Auth::user();

            $ljkh = ljkh::where('id_mch', $idMch)
                ->where('status', 'ready')
                ->orWhere('status', 'Hold')
                ->orderBy('job_id')
                ->first();

            // LJKH
            if ($ljkh) {
                $ljkh->update([
                    'Date'           => $date,
                    'name'           => $user->name,
                    'start'          => $time,
                    'sub'            => $user->sub,
                    'activity_name'  => $request->input('activity_name'),
                    'status'         => 'In progress'
                ]);
            } else {
                throw new \Exception('Data ljkh Not Found');
            }

            // JOB LIST
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)
                ->where('status_job', 'ready')
                ->orWhere('status_job', 'Hold')
                ->orderBy('project_id')
                ->first();

            if ($jobList) {
                $jobList->update([
                    'status_job' => 'In progress'
                ]);
            } else {
                throw new \Exception('Data joblist not found');
            }
            if ($request->session()->get('id_mch') == $idMch) {
                Session::put('status_' . $idMch, 'In progress');
            }
            DB::commit();
            return response()->json(['succes' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function jobEnd($id_ljkh, Request $request)
    {
        try {
            DB::beginTransaction();
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);

            $idMch = $request->session()->get('id_mch');

            // LJKH
            $ljkh = ljkh::where('id', $id_ljkh)
                ->where('id_mch', $idMch)
                ->where('status', 'In progress')
                ->first();

            if ($ljkh) {
                $ljkh->update([
                    'stop'      => $time,
                    'status'    => 'Complete',
                ]);
                $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
                $ljkh->update([
                    'prod_hour' => $prodHour
                ]);
            } else {
                throw new \Exception('data ljkh gagal di update');
            }

            // JOB LIST
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)
                ->where('status_job', 'In progress')
                ->first();

            if ($jobList) {
                $jobList->update([
                    'status_job' => 'Complete'
                ]);
            } else {
                throw new \Exception('Data joblist gagal di update');
            }
            if ($request->session()->get('id_mch') == $idMch) {
                Session::forget('status_' . $idMch);
                Session::forget('task_' . $idMch);
            }
            DB::commit();
            return response()->json(['succes' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function holdJob($id_ljkh, Request $request)
    {
        try {
            DB::beginTransaction();
            $idMch = $request->session()->get('id_mch');
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);

            $ljkh = ljkh::where('id_ljkh', $id_ljkh)->where('id_mch', $idMch)->where('status', 'In progress')->first();
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)->where('status_job', 'In progress')->first();

            $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
            if ($jobList) {
                $jobList->status_job = 'Hold';
                $jobList->save();
            }
            if ($ljkh) {
                $ljkh->update([
                    'status'    => 'Hold',
                    'stop'      => $time,
                    'prod_hour' => $prodHour
                ]);
            }
            if ($request->session()->get('id_mch') == $idMch) {
                Session::forget('status_' . $idMch);
                Session::forget('task_' . $idMch);
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function autoRunNPK($id_ljkh, Request $request)
    {
        try {
            $date = Carbon::now()->toDateString();
            $user = Auth::user();
            $stop = Carbon::now()->toTimeString();
            $timeStop = substr($stop, 0, 5);
            $start = Carbon::now()->toTimeString();
            $time = substr($start, 0, 5);
            $idMch = $request->session()->get('id_mch');

            $ljkh = ljkh::where('id_ljkh', $id_ljkh)->where('id_mch', $idMch)->first();
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)->first();

            DB::beginTransaction();
            if ($request->session()->get('id_mch') == $idMch) {
                Session::put('task_' . $idMch, 'NPK');
            }
            if ($ljkh->activity_name === null) {
                $jobList->update(['status_job' => 'In progress']);
                $ljkh->update([
                    'Date'          => $date,
                    'name'          => $user->name,
                    'activity_name' => $ljkh->activity_name !== null ? 'NPK ' . $ljkh->activity_name : 'NPK ' . $request->input('activity_name'),
                    'start'         => $time,
                    'status'        => 'In progress',
                    'sub'           => $user->sub
                ]);
            } else {
                $ljkh->update(['stop' => $timeStop]);
                $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
                $ljkh->update([
                    'prod_hour' => $prodHour,
                    'status'    => 'Complete'
                ]);
                $jobList->update(['status_job' => 'In progress']);

                ljkh::create([
                    'Date'          => $date,
                    'job_id'        => $ljkh->job_id,
                    'name'          => $user->name,
                    'project'       => $ljkh->project,
                    'id_job'        => $ljkh->id_job,
                    'activity_name' => 'NPK ' . $ljkh->activity_name,
                    'status'        => 'In progress',
                    'id_mch'        => $idMch,
                    'sub'           => $user->sub,
                    'work_ctr'      => $ljkh->work_ctr,
                    'die_part'      => $ljkh->die_part,
                    'start'         => $time,
                ]);
            }
            if ($request->session()->get('id_mch') == $idMch) {
                Session::forget('status_' . $idMch);
            }
            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function autoRunEnd($id_ljkh, Request $request)
    {
        try {
            $idMch = request()->session()->get('id_mch');
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);

            $inputStop = $request->input('stop');

            $ljkh = ljkh::where('id_ljkh', $id_ljkh)
                ->where('id_mch', $idMch)
                ->where(function ($query) {
                    $query->where('activity_name', 'like', 'NPK%');
                })
                ->where('status', 'In progress')
                ->first();

            $jobList = JobList::where('id_jobList', $ljkh->job_id)
                ->where('id_mch', $idMch)
                ->first();

            DB::beginTransaction();
            if ($inputStop !== null) {
                if (strpos(strtolower($inputStop), 'jam') !== false && strpos(strtolower($inputStop), 'menit') !== false) {
                    // Jika input mengandung kata 'jam' dan 'menit'
                    preg_match('/^(\d+)\s*jam\s*(\d+)\s*menit$/i', $inputStop, $matches);
                    $hours = (int) $matches[1];
                    $minutes = (int) $matches[2];

                    // Menambahkan jumlah jam dan menit ke waktu saat ini
                    $input = Carbon::now()->addHours($hours)->addMinutes($minutes)->format('H:i');
                } elseif (strpos(strtolower($inputStop), 'jam') !== false) {
                    // Jika input hanya mengandung kata 'jam'
                    $hours = (int) filter_var($inputStop, FILTER_SANITIZE_NUMBER_INT);
                    $input = Carbon::now()->addHours($hours)->format('H:i');
                } elseif (strpos(strtolower($inputStop), 'menit') !== false) {
                    // Jika input hanya mengandung kata 'menit'
                    $minutes = (int) filter_var($inputStop, FILTER_SANITIZE_NUMBER_INT);
                    $input = Carbon::now()->addMinutes($minutes)->format('H:i');
                } else {
                    throw new \Exception('Format input tidak valid');
                }
            }

            $ljkh->update(['stop' => $input ?? $time,]);
            $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
            $ljkh->update([
                'prod_hour' => $prodHour,
                'status'    => 'Complete'
            ]);
            $jobList->update(['status_job' => 'ready']);

            ljkh::create([
                'job_id'          => $ljkh->job_id,
                'project'         => $ljkh->project,
                'id_job'          => $ljkh->id_job,
                'activity_name'   => $request->input('activity_name'),
                'status'          => 'ready',
                'id_mch'          => $idMch,
                'work_ctr'        => $ljkh->work_ctr,
                'die_part'        => $ljkh->die_part
            ]);
            if ($request->session()->get('id_mch') == $idMch) {
                Session::forget('task_' . $idMch);
            }
            DB::commit();
            return response()->json(['success' =>  true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function prodHour($start, $stop)
    {
        $timeDiffInSeconds = Carbon::parse($stop)->diffInSeconds($start);
        $hours = floor($timeDiffInSeconds / 3600);
        $minutes = floor(($timeDiffInSeconds % 3600) / 60);

        $formattedTime = '';

        if ($hours > 0 && $minutes > 0) {
            $formattedTime .= $hours . ' Jam ' . $minutes . ' Menit';
        } elseif ($hours > 0) {
            $formattedTime = "$hours Jam";
        } elseif ($minutes > 0) {
            $formattedTime .= ($formattedTime !== '' ? ' ' : '') . "$minutes Menit";
        } else {
            $formattedTime = "1 Menit";
        }
        return $this->convertProdHour($formattedTime);
    }

    private function convertProdHour($formattedTime)
    {
        if (strpos($formattedTime, 'Jam') !== false && strpos($formattedTime, 'Menit') !== false) {
            $split = explode(' ', $formattedTime);
            $hours = (int) $split[0];
            $minutes = (int) $split[2];
            return $hours . '.' . $minutes;
        } elseif (strpos($formattedTime, 'Jam') !== false) {
            $hours = (int) filter_var($formattedTime, FILTER_SANITIZE_NUMBER_INT);
            return $hours . '.0';
        } elseif (strpos($formattedTime, 'Menit') !== false) {
            $minutes = (int) filter_var($formattedTime, FILTER_SANITIZE_NUMBER_INT);
            return '0.' . $minutes;
        }
    }

    public function autoIdle(Request $request)
    {
        try {
            $user = Auth::user();
            $idMch = $request->session()->get('id_mch');
            $date = Carbon::now()->toDateString();
            $stop = Carbon::now()->toTimeString();
            $ljkh = ljkh::where(function ($query) {
                $query->where('status', 'queued')
                    ->orWhere('status', 'ready');
            })->latest()->first();
            $target = Carbon::now();
            $target->setTime(7, 15, 0);

            DB::beginTransaction();
            $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
            ljkh::create([
                'job_id'        => $ljkh->job_id,
                'Date'          => $date,
                'name'          => $user->name,
                'id_mch'        => $idMch,
                'sub'           => $user->sub,
                'id_job'        => 'N000005',
                'work_ctr'      => 'MCH-PREF',
                'activity_name' => 'IDLE TIME',
                'start'         => $target,
                'stop'          => $stop,
                'prod_hour'     => $prodHour,
                'status'        => 'Complete'
            ]);

            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function setting(Request $request)
    {
        try {
            $user = Auth::user();
            $idMch = $request->session()->get('id_mch');
            $date = Carbon::now()->toDateString();
            $start = Carbon::now()->toTimeString();
            $time = substr($start, 0, 5);
            $ljkh = ljkh::where('id_mch', $idMch)->where('status', 'ready')->orWhere('status', 'In progress')->first();

            if ($ljkh) {
                DB::beginTransaction();
                ljkh::create([
                    'Date'          => $date,
                    'job_id'        => $ljkh->job_id,
                    'name'          => $user->name,
                    'id_mch'        => $idMch,
                    'sub'           => $user->sub,
                    'id_job'        => $ljkh->id_job,
                    'work_ctr'      => 'MCH-PREF',
                    'activity_name' => 'prep time',
                    'start'         => $time,
                    'status'        => 'setting',
                    'project'       => $ljkh->project,
                    'die_part'      => $ljkh->die_part
                ]);
                DB::commit();
                return response()->json(['success' => true], 200);
            } else {
                throw new \Exception('Gagal Store Data Setting');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function settingDone(Request $request)
    {
        try {
            $idMch = $request->session()->get('id_mch');
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);
            $ljkh = ljkh::where('id_mch', $idMch)->where('status', 'setting')->orderBy('id_ljkh')->first();

            if ($ljkh) {
                DB::beginTransaction();
                $ljkh->update(['stop' => $time]);
                $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
                $ljkh->update([
                    'prod_hour' => $prodHour,
                    'status'    => 'Complete'
                ]);
                DB::commit();
                return response()->json(['success' => true]);
            } else {
                throw new \Exception('Gagal update settingDone');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function changeTask(Request $request, $id_ljkh)
    {
        try {
            $user = Auth::user();
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);
            $date = Carbon::now()->toDateString();
            $idMch = $request->session()->get('id_mch');

            $ljkh = ljkh::where('id_ljkh', $id_ljkh)->where('id_mch', $idMch)->where('status', 'In progress')->first();
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)->where('status_job', 'In progress')->first();

            DB::beginTransaction();
            if ($ljkh) {
                $ljkh->update(['stop' => $time]);
                $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
                $ljkh->update([
                    'prod_hour' => $prodHour,
                    'status'    => 'Complete'
                ]);
                $jobList->update(['status_job' => 'ready']);

                ljkh::create([
                    'Date'          => $date,
                    'job_id'        => $ljkh->job_id,
                    'name'          => $user->name,
                    'project'       => $ljkh->project,
                    'id_job'        => $ljkh->id_job,
                    'activity_name' => $request->input('activity_name'),
                    'status'        => 'ready',
                    'id_mch'        => $idMch,
                    'sub'           => $user->sub,
                    'work_ctr'      => $ljkh->work_ctr,
                    'die_part'      => $ljkh->die_part,
                ]);
            } else {
                throw new \Exception('Data not found');
            }
            if ($request->session()->get('id_mch') == $idMch) {
                Session::forget('status_' . $idMch);
            }

            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function endTask(Request $request, $id_ljkh)
    {
        try {
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);
            $idMch = $request->session()->get('id_mch');

            $ljkh = ljkh::where('id_ljkh', $id_ljkh)->where('id_mch', $idMch)->where('status', 'In progress')->first();
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)->where('status_job', 'In progress')->first();

            DB::beginTransaction();
            if ($ljkh) {
                $ljkh->update(['stop' => $time]);
                $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
                $ljkh->update([
                    'prod_hour' => $prodHour,
                    'status'    => 'Complete'
                ]);
                $jobList->update(['status_job' => 'Complete']);
            } else {
                throw new \Exception('Data not found');
            }

            if ($request->session()->get('id_mch') == $idMch) {
                Session::forget('status_' . $idMch);
                // Session::regenerate();
            }

            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function shift($id_ljkh, Request $r) 
    {
        try {
            DB::beginTransaction();
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);
            $idMch = $r->session()->get('id_mch');

            $ljkh = ljkh::where('id_ljkh', $id_ljkh)->where('id_mch', $idMch)->where('status', 'In progress')->first();
            $jobList = JobList::where('id_jobList', $ljkh->job_id)->where('id_mch', $idMch)->first();

            if ($ljkh) {
                $ljkh->update(['stop' => $time]);
                $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
                $ljkh->update([
                    'prod_hour' => $prodHour,
                    'status'    => 'Complete',
                ]);
                $jobList->update([
                    'status_job' => 'ready',
                    'note'       => $r->input('note'),
                ]);

                ljkh::create([
                    'job_id'        => $ljkh->job_id,
                    'project'       => $ljkh->project,
                    'id_job'        => $ljkh->id_job,
                    'activity_name' => $r->input('activity_name'),
                    'status'        => 'ready',
                    'id_mch'        => $idMch,
                    'work_ctr'      => $ljkh->work_ctr,
                    'die_part'      => $ljkh->die_part,
                ]);
            } else {
                throw new \Exception('Data not found');
            }
            if ($r->session()->get('id_mch') == $idMch) {
                Session::forget('status_' . $idMch);
                Session::forget('task_' . $idMch);
            }
            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function break(Request $r)
    {
        try {
            $user = Auth::user();
            $start = Carbon::now()->toTimeString();
            $timeStart = substr($start, 0, 5);
            $stop = Carbon::now()->toTimeString();
            $timeStop = substr($stop, 0, 5);
            $date = Carbon::now()->toDateString();

            $idMch = $r->session()->get('id_mch');
            $ljkh = ljkh::where('id_mch', $idMch)
                ->where('status', 'In progress')
                ->latest()
                ->first();
            $jobList = JobList::where('id_jobList', $ljkh->job_id)
                ->where('id_mch', $idMch)
                ->latest()
                ->first();
            $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);

            DB::beginTransaction();
            $ljkh->update([
                'stop'      => $timeStop,
                'prod_hour' => $prodHour,
                'status'    => 'istirahat'
            ]);
            ljkh::create([
                'Date'          => $date,
                'job_id'        => $ljkh->job_id,
                'name'          => $user->name,
                'project'       => $ljkh->project,
                'id_job'        => 'N000004',
                'activity_name' => 'JB(5S)',
                'status'        => 'break',
                'id_mch'        => $idMch,
                'start'         => $timeStart,
                'sub'           => $user->sub,
                'work_ctr'      => $ljkh->work_ctr,
                'die_part'      => $ljkh->die_part,
            ]);
            $jobList->update(['status_job' => 'break']);
            ljkh::create([
                'Date'          => $date,
                'job_id'        => $ljkh->job_id,
                'name'          => $user->name,
                'project'       => $ljkh->project,
                'id_job'        => $ljkh->id_job,
                'activity_name' => $ljkh->activity_name,
                'status'        => 'ready',
                'id_mch'        => $idMch,
                'sub'           => $user->sub,
                'work_ctr'      => $ljkh->work_ctr,
                'die_part'      => $ljkh->die_part,
            ]);
            if ($r->session()->get('id_mch') == $idMch) {
                Session::forget('status_' . $idMch);
                Session::forget('task_' . $idMch);
            }
            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function breakDone(Request $r)
    {
        try {
            $stop = Carbon::now()->toTimeString();
            $time = substr($stop, 0, 5);
            $idMch = $r->session()->get('id_mch');

            DB::beginTransaction();
            $ljkh = ljkh::where('id_mch', $idMch)
                ->where('status', 'break')
                ->first();
            $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
            $ljkh->update([
                'stop'      => $time,
                'status'    => 'Complete',
                'prod_hour' => $prodHour
            ]);

            $jobList = JobList::where('id_mch', $idMch)
                ->where('status_job', 'break')
                ->first();
            $jobList->update(['status_job' => 'ready']);

            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
