<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Carbon\Carbon;
// use App\Models\operator;
use App\Models\ljkh;
use App\Models\JobList;
use Barryvdh\DomPDF\PDF;
use App\Models\workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ForemanController extends Controller
{
    public function currentProcess(Request $request)
    {
        $user = Auth::user();
        $id_mch = $request->input('id_mch') ?? $request->session()->get('id_mch') ?? $user->id_mch;
        $request->session()->put('id_mch', $id_mch);

        $machines = ljkh::where('status', 'In progress')->get();
        $jobList = JobList::where('status_job', 'In progress')->first();

        return view('foreman.DashboardForeman', compact('machines', 'jobList'));
    }

    // perhitungan total hour masih kurang efisien
    public function downloadPDF(Request $request)
    {
        $tahun = $request->get('param1', Carbon::now()->format('Y'));
        $bulan = $request->get('param2', Carbon::now()->format('m'));
        $status = $request->get('param3', 'Complete');
    
        $currentMonth = $tahun . '-' . $bulan;
    
        $working_hours = DB::select("
            SELECT 
                ljkhs.project,
                SUM(CASE WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 1 AND 8 THEN COALESCE(ljkhs.prod_hour, 0) ELSE 0 END) AS W1,
                SUM(CASE WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 9 AND 16 THEN COALESCE(ljkhs.prod_hour, 0) ELSE 0 END) AS W2,
                SUM(CASE WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 17 AND 24 THEN COALESCE(ljkhs.prod_hour, 0) ELSE 0 END) AS W3,
                SUM(CASE WHEN DATE_FORMAT(ljkhs.created_at, '%d') > 24 THEN COALESCE(ljkhs.prod_hour, 0) ELSE 0 END) AS W4,
                projects.targetHour,
                SUM(COALESCE(ljkhs.prod_hour, 0)) as totalHours
            FROM 
                ljkhs
            JOIN job_lists ON ljkhs.job_id = job_lists.id_jobList
            JOIN projects ON job_lists.project_id = projects.id_project
            WHERE 
                DATE_FORMAT(ljkhs.created_at, '%Y-%m') = ?
                AND ljkhs.status = ?
                AND ljkhs.project != 'Idle Time'
            GROUP BY 
                ljkhs.project, projects.targetHour
            ORDER BY 
                ljkhs.project
        ", [$currentMonth, $status]);
    
        $data = [];
        foreach ($working_hours as $row) {
            $data[$row->project] = [
                'targetHour' => $row->targetHour,
                'W1' => $row->W1,
                'W2' => $row->W2,
                'W3' => $row->W3,
                'W4' => $row->W4,
                'totalHours' => $row->totalHours  // Total hours from query
            ];
        }
    
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('foreman.report', compact('data', 'tahun', 'bulan', 'status'));
    
        $monthName = Carbon::createFromFormat('m', $bulan)->format('F');
        $fileName = "ReportMachHour-$monthName.pdf";
    
        return $pdf->download($fileName);
    }
    

    public function indexValidasi(Request $request)
    {
        $user = Auth::user();
        $validasi = JobList::where('validasi', 'Belum Divalidasi')->get();
        $idMchs = workstation::pluck('id_mch', 'id_mch');

        if ($request->ajax()) {
            return Datatables::of($validasi)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $button = '<a href="#" data-id="' . $row->id_jobList . '" class="btn btn-primary btn-sm validasiProject" style="font-size: 12px;">VALIDASI</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('foreman.validasi', compact('validasi', 'idMchs'));
    }

    public function validated(Request $request)
    {
        $validated = JobList::where('validasi', 'Sudah Divalidasi')
            ->whereNot('status_job', 'Complete')
            ->orderByRAW("FIELD(priority, 'prioritas', 'High', 'Medium', 'Low') ASC")
            ->with('project')->get();

        if ($request->ajax()) {
            return Datatables::of($validated)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="btn-group">';

                    // Tombol High
                    $disabledHigh = $row->priority == 'high' ? 'disabled' : '';
                    $buttons .= '<button type="button" class="btn btn-sm btn-danger priority" 
                        data-id="' . $row->id_jobList . '" ' . $disabledHigh . ' data-priority = "High">1</button>';

                    // Tombol Medium
                    $disabledMedium = $row->priority == 'medium' ? 'disabled' : '';
                    $buttons .= '<button type="button" class="btn btn-sm btn-warning priority" 
                        data-id="' . $row->id_jobList . '" ' . $disabledMedium . ' data-priority = "Medium">2</button>';

                    // Tombol Low
                    $disabledLow = $row->priority == 'low' ? 'disabled' : '';
                    $buttons .= '<button type="button" class="btn btn-sm btn-secondary priority" 
                        data-id="' . $row->id_jobList . '" ' . $disabledLow . ' data-priority = "Low">3</button>';

                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('foreman.validasi', compact('validated'));
    }

    public function showJob($id_jobList)
    {
        $validasi = JobList::with('project')->findOrFail($id_jobList);
        return response()->json($validasi);
    }

    public function validasiJob(Request $request, $id_jobList)
    {
        try {
            $validasi = JobList::with('project')->findOrFail($id_jobList);
            $idMch = $request->id_mch;
            $workCntr = $this->getWorkCntr($idMch);
            $leadTime = $request->lead_time;

            if ($validasi) {
                DB::beginTransaction();
                $validasi->update([
                    'id_mch'     => $request->id_mch,
                    'lead_time'  => $leadTime,
                    'main_task'  => $request->main_task,
                    'die_part'   => $request->die_part,
                    'validasi'   => 'Sudah Divalidasi',
                    'status_job' => 'queued',
                ]);
                // JobList::create([
                //     'project_id'    => $validasi->project_id,
                //     'id_job'        => $validasi->id_job,
                //     'validasi'      => 'Belum Divalidasi',
                //     'status_job'    => 'queued',
                //     'priority'      => 'Low'
                // ]);
                ljkh::create([
                    'job_id'    => $validasi->id_jobList,
                    'id_job'    => $validasi->id_job,
                    'project'   => $validasi->project->project,
                    'id_mch'    => $request->id_mch,
                    'die_part'  => $validasi->die_part,
                    'status'    => 'queued',
                    'work_ctr'  => $workCntr
                ]);
                DB::commit();
                return response()->json(['success' => true]);
            } else {
                throw new \Exception('Gagal Validasi Job');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function priorityJob($id_jobList, Request $r)
    {
        try {
            $jobList = JobList::findOrFail($id_jobList);

            if ($jobList->validasi === 'Sudah Divalidasi') {
                DB::beginTransaction();

                try {
                    $jobList->priority = $r->priority;
                    $jobList->save();
                    DB::commit();
                    return response()->json(['success' => true]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['success' => false, 'message' => 'Error : gagal prioritas job']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'status tidak berubah']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    protected function getWorkCntr($idMch)
    {
        switch ($idMch) {
            case '320':
            case '321':
            case '322':
            case '323':
            case '324':
            case '325':
                $wrkCntr = 'MCH-MED';
                break;
            case 'EQUIPTOP':
            case 'OKAMOTO':
                $wrkCntr = 'MCH-SML';
                break;
            case '302':
            case '303':
            case '304':
            case 'KBT 11':
            case 'MCR BIII':
                $wrkCntr = 'MCH-BIG';
                break;
            default:
                $wrkCntr = '';
        }
        return $wrkCntr;
    }
    // end of validasi

}
