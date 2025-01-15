<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ljkh;
use App\Models\User;
use App\Models\JobList;
use App\Models\Project;
use App\Models\activity;
use App\Models\operator;
use App\Exports\LJKHExport;
use Illuminate\Http\Request;
use App\Imports\ProjectImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // Start Dashboard

    // public function dashboard(Request $request)
    // {
    //     $tahun = $request->get('param1');
    //     if ($tahun == null || $tahun == 'param1') {
    //         $tahun = Carbon::now()->format('Y');
    //     }

    //     $bulan = $request->get('param2');
    //     if ($bulan == null || $bulan == 'param2') {
    //         $bulan = Carbon::now()->format('m');
    //     }

    //     $status = $request->get('param3');
    //     if ($status == null || $status == 'param3') {
    //         $status = 'Complete';
    //     }

    //     $currentMonth = $tahun . '-' . $bulan;

    //     $working_hours = DB::select("
    //         SELECT 
    //             ljkhs.project, 
    //             (CASE  
    //                 WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 1 AND 8 THEN 'W1' 
    //                 WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 9 AND 16 THEN 'W2' 
    //                 WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 17 AND 24 THEN 'W3' 
    //                 ELSE 'W4' 
    //             END) as weekly,
    //             ROUND(SUM(COALESCE(ljkhs.prod_hour, 0)), 2) as working_hours,
    //             projects.targetHour
    //         FROM 
    //             ljkhs
    //         JOIN job_lists ON ljkhs.job_id = job_lists.id_jobList
    //         JOIN projects ON job_lists.project_id = projects.id_project
    //         WHERE 
    //             DATE_FORMAT(ljkhs.created_at, '%Y-%m') = ?
    //             AND ljkhs.status = ?
    //             AND ljkhs.project != 'Idle Time'
    //         GROUP BY 
    //             ljkhs.project, weekly, projects.targetHour
    //         ORDER BY 
    //             ljkhs.project, weekly
    //     ", [$currentMonth, $status]);

    //     $data = [];
    //     foreach ($working_hours as $row) {
    //         if (!isset($data[$row->project])) {
    //             $data[$row->project] = [
    //                 'targetHour' => $row->targetHour,
    //                 'W1' => 0,
    //                 'W2' => 0,
    //                 'W3' => 0,
    //                 'W4' => 0
    //             ];
    //         }
    //         $data[$row->project][$row->weekly] = $row->working_hours;
    //     }

    //     if ($request->ajax()) {
    //         return response()->json(['data' => $data]);
    //     } else {
    //         // return view('admin.DashboardAdmin', ['data' => $data, 'tahun' => $tahun, 'bulan' => $bulan, 'status' => $status]);
    //         return view('admin.DashboardAdmin', [
    //             'data' => $data,
    //             'selectedYear' => $tahun,
    //             'selectedMonth' => $bulan,
    //             'selectedStatus' => $status
    //         ]);
    //     }
    // }

    // public function dashboard(Request $request)
    // {
    //     $tahun = $request->get('param1');
    //     if ($tahun == null || $tahun == 'param1') {
    //         $tahun = Carbon::now()->format('Y');
    //     }

    //     $bulan = $request->get('param2');
    //     if ($bulan == null || $bulan == 'param2') {
    //         $bulan = Carbon::now()->format('m');
    //     }

    //     $status = $request->get('param3');
    //     if ($status == null || $status == 'param3') {
    //         $status = 'Complete';
    //     }

    //     $currentMonth = $tahun . '-' . $bulan;

    //     $working_hours = DB::select("
    //         SELECT 
    //             ljkhs.project, 
    //             (CASE  
    //                 WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 1 AND 8 THEN 'W1' 
    //                 WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 9 AND 16 THEN 'W2' 
    //                 WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 17 AND 24 THEN 'W3' 
    //                 ELSE 'W4' 
    //             END) as weekly,
    //             ROUND(SUM(COALESCE(ljkhs.prod_hour, 0)), 2) as working_hours,
    //             projects.targetHour
    //         FROM 
    //             ljkhs
    //         JOIN job_lists ON ljkhs.job_id = job_lists.id_jobList
    //         JOIN projects ON job_lists.project_id = projects.id_project
    //         WHERE 
    //             DATE_FORMAT(ljkhs.created_at, '%Y-%m') = ?
    //             AND ljkhs.status = ?
    //             AND ljkhs.project != 'Idle Time'
    //         GROUP BY 
    //             ljkhs.project, weekly, projects.targetHour
    //         ORDER BY 
    //             ljkhs.project, weekly
    //     ", [$currentMonth, $status]);

    //     $data = [];
    //     foreach ($working_hours as $row) {
    //         if (!isset($data[$row->project])) {
    //             $data[$row->project] = [
    //                 'targetHour' => $row->targetHour,
    //                 'W1' => 0,
    //                 'W2' => 0,
    //                 'W3' => 0,
    //                 'W4' => 0
    //             ];
    //         }
    //         $data[$row->project][$row->weekly] = $row->working_hours;
    //     }

    //     if ($request->ajax()) {
    //         return response()->json(['data' => $data]);
    //     } else {
    //         return view('admin.DashboardAdmin', [
    //             'data' => $data,
    //             'selectedYear' => $tahun,
    //             'selectedMonth' => $bulan,
    //             'selectedStatus' => $status
    //         ]);
    //     }
    // }

    public function dashboard(Request $request)
    {
        $tahun = $request->get('param1');
        if ($tahun == null || $tahun == 'param1') {
            $tahun = Carbon::now()->format('Y');
        }

        $bulan = $request->get('param2');
        if ($bulan == null || $bulan == 'param2') {
            $bulan = Carbon::now()->format('m');
        }

        $status = $request->get('param3');
        if ($status == null || $status == 'param3') {
            $status = 'Complete';
        }

        $currentMonth = $tahun . '-' . $bulan;

        $working_hours = DB::select("
            SELECT 
                ljkhs.project,
                (CASE  
                    WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 1 AND 8 THEN 'W1'
                    WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 9 AND 16 THEN 'W2'
                    WHEN DATE_FORMAT(ljkhs.created_at, '%d') BETWEEN 17 AND 24 THEN 'W3'
                    ELSE 'W4'
                END) as weekly,
                ROUND(SUM(COALESCE(ljkhs.prod_hour, 0)), 2) as working_hours,
                projects.targetHour,
                (SELECT ROUND(SUM(COALESCE(l.prod_hour, 0)), 2)
                 FROM ljkhs l
                 WHERE l.project = ljkhs.project
                   AND DATE_FORMAT(l.created_at, '%Y-%m') = ?
                   AND l.status = ?
                   AND l.project != 'Idle Time') as total_hours
            FROM 
                ljkhs
            JOIN job_lists ON ljkhs.job_id = job_lists.id_jobList
            JOIN projects ON job_lists.project_id = projects.id_project
            WHERE 
                DATE_FORMAT(ljkhs.created_at, '%Y-%m') = ?
                AND ljkhs.status = ?
                AND ljkhs.project != 'Idle Time'
            GROUP BY 
                ljkhs.project, weekly, projects.targetHour
            ORDER BY 
                ljkhs.project, weekly
        ", [$currentMonth, $status, $currentMonth, $status]);

        $data = [];
        foreach ($working_hours as $row) {
            if (!isset($data[$row->project])) {
                $data[$row->project] = [
                    'targetHour' => $row->targetHour,
                    'W1' => 0,
                    'W2' => 0,
                    'W3' => 0,
                    'W4' => 0,
                    'totalHours' => $row->total_hours  // Total hours from query
                ];
            }
            $data[$row->project][$row->weekly] = $row->working_hours;
        }

        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        } else {
            return view('admin.DashboardAdmin', [
                'data' => $data,
                'selectedYear' => $tahun,
                'selectedMonth' => $bulan,
                'selectedStatus' => $status
            ]);
        }
    }



    // End Dashboard


    // Start LJKH
    public function index(Request $request)
    {
        $search = $request->input('search');
        Paginator::useBootstrap();
        $ljkh = ljkh::whereIN('status', ['Complete'])
            ->where(function ($query) use ($search) {
                $query->where('Date', 'LIKE', "%$search%")
                    ->orWhere('id_mch', 'LIKE', "%$search%")
                    ->orWhere('id_job', 'LIKE', "%$search%")
                    ->orWhere('sub', 'LIKE', "%$search%")
                    ->orWhere('activity_name', 'LIKE', "%$search%");
            })
            ->orderBy('Date', 'desc')
            ->orderBy('start', 'desc')
            ->Paginate(10);

        return view('admin.ljkh', compact('ljkh', 'search'));
    }

    public function edit(string $id_ljkh)
    {
        $ljkh = ljkh::findOrFail($id_ljkh);
        $idMchs = Operator::pluck('id_mch', 'id_mch');
        $taskNames = activity::pluck('activity_name', 'activity_name');

        return view('admin.editLJKH', compact('ljkh', 'idMchs', 'taskNames'));
    }

    public function update(Request $request, string $id_ljkh)
    {
        try {
            $ljkh = ljkh::find($id_ljkh);
            $project = $request->project;

            DB::beginTransaction();
            $ljkh->update([
                'project'       => $project,
                'id_mch'        => $request->id_mch,
                'die_part'      => $request->die_part,
                'activity_name' => $request->activity_name,
                'id_job'        => $request->id_job,
                'itu'           => $request->itu
            ]);
            DB::commit();
            return redirect()->route('admin.ljkh')->with('success', 'LJKH berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.ljkh')->with('error', 'LJKH Gagal di update!');
        }
    }

    public function destroy(string $id_ljkh)
    {
        $product = ljkh::findOrFail($id_ljkh);
        $product->delete();

        return redirect()->route('admin.ljkh')->with('success', 'job deleted successfully');
    }

    public function exportLJKH()
    {
        $fileName = Carbon::now()->format('Y-m') . '-Data Entry' . '.xlsx';
        return Excel::download(new LJKHExport, $fileName);
    }
    // End LJKH

    // project
    public function indexProject()
    {
        // $project = project::paginate(10);
        $projects = Project::orderby('project')->orderBy('Start_date', 'desc')->paginate(10);
        Paginator::useBootstrap();
        return view('admin.index', compact('projects'));
    }

    // public function getData(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Project::all();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 $btn = '<a href="#" data-id="' . $row->id_project . '" class="btn btn-outline-danger deleteProject">
    //                 <i class="fas fa-trash-alt"></i></a>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['action',])
    //             ->make(true);
    //     }
    // }


    public function storeProject(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'anumber' => [
                    'required',
                    'min:7',
                ],
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }

            DB::beginTransaction();
            $anumberRange = explode('-', $request->anumber);
            if (count($anumberRange) === 2) {
                $start = (int) substr($anumberRange[0], 1);
                $end = (int) substr($anumberRange[1], 1);
                for ($i = $start; $i <= $end; $i++) {
                    $anumber = 'A' . sprintf('%06d', $i);

                    // Check if anumber already exists
                    if (Project::where('anumber', $anumber)->exists()) {
                        return response()->json(['error' => "Anumber {$anumber} already exists"], 400);
                    }

                    $project = Project::create([
                        'project'   => $request->project,
                        'part_name' => $request->part_name,
                        'part_no'   => $request->part_no,
                        'targetHour' => $request->targetHour,
                        'anumber'   => $anumber,
                        'Start_date'   => $request->startDate,
                        'Due_date'   => $request->dueDate,
                    ]);
                    JobList::create([
                        'id_job'     => $anumber,
                        'project_id' => $project->id_project,
                        'validasi'   => 'Belum Divalidasi',
                        'priority'   => 'Low',
                        'status_job' => 'queued',
                    ]);
                }
            } else {
                $anumber = $request->anumber;

                // Check if anumber already exists
                if (Project::where('anumber', $anumber)->exists()) {
                    return response()->json(['error' => "Anumber {$anumber} already exists"], 400);
                }

                $project = Project::create([
                    'project'   => $request->project,
                    'part_name' => $request->part_name,
                    'part_no'   => $request->part_no,
                    'targetHour' => $request->targetHour,
                    'anumber'   => $anumber,
                    'Start_date'   => $request->startDate,
                    'Due_date'   => $request->dueDate,
                ]);
                JobList::create([
                    'id_job'     => $anumber,
                    'project_id' => $project->id_project,
                    'validasi'   => 'Belum Divalidasi',
                    'priority'   => 'standar',
                    'status_job' => 'queued',
                ]);
            }
            DB::commit();
            return response()->json(['success' => true]);
            // return redirect()->route('project.index')->with('success', 'Project Berhasil Ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function editProject($id_project)
    {
        $project = Project::find($id_project);
        return response()->json($project);
    }

    public function updateProject(Request $request, $id_project)
    {
        try {
            $project = Project::find($id_project);
            $jobList = JobList::where('project_id', $project->id_project)->first();

            DB::beginTransaction();
            $project->update([
                'project'   => $request->project,
                'part_name' => $request->part_name,
                'part_no'   => $request->part_no,
                'anumber'   => $request->anumber,
            ]);
            $jobList->update([
                'id_job'    => $request->Anumber,
            ]);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroyProject($id_project)
    {
        try {
            DB::beginTransaction();
            $project = Project::find($id_project);
            // $jobList = JobList::find($id_project);
            // $jobList = JobList::where('project_id', $project->id)->pluck('id');

            if ($project) {
                $project->delete();
                JobList::where('project_id', $project->id_project)->delete();
            } else {
                throw new \Exception('Gagal Hapus');
            }
            DB::commit();
            return response()->json(['success' => true]);
            // return redirect()->route('project.index')->with('success', 'Project berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function importProject(Request $request)
    {
        $file = $request->file('fileProject');
        Excel::import(new ProjectImport, $file);

        $this->storeJobList();

        return redirect()->route('project.index')->with('success', 'Project berhasil Di Import!');
        // return response()->json(['message' => 'Data berhasil diimpor']);
    }

    private function storeJobList()
    {
        $projects = Project::latest()->where('created_at', '>', now()->subSeconds(5))->get();
        foreach ($projects as $newProject) {
            JobList::create([
                'id_job'     => $newProject->anumber,
                'project_id' => $newProject->id_project,
                'validasi'   => 'Belum Divalidasi',
                'priority'   => 'standar',
                'status_job' => 'queued'
            ]);
        }
    }
    // end of project

    // User Controller
    public function indexUser(Request $request)
    {
        $user = User::all();
        if ($request->ajax()) {
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.UserBtn')->with('user', $row);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.indexUser', compact('user'));
    }

    public function createUser()
    {
        return view('admin.createUser');
    }

    public function storeUser(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'name'      => 'required',
                'id_mch'    => 'required',
                'sub'       => 'required',
                'NPK'       => 'required',
                'password'  => 'required',
                'level'     => 'required'
            ])->validate();

            DB::beginTransaction();
            $user = User::create([
                'name'      => $request->name,
                'id_mch'    => $request->id_mch,
                'sub'       => $request->sub,
                'NPK'       => $request->NPK,
                'password'  => Hash::make($request->password),
                'level'     => $request->level
            ]);
            DB::commit();
            return redirect()->route('admin.indexUser')->with('success', 'Akun ' . $user->name . ' berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.indexUser')->with('error', 'Gagal membuat akun. Error: ' . $e->getMessage());
        }
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $data = [
                'name'   => $request->name,
                'id_mch' => $request->id_mch,
                'NPK'    => $request->NPK,
                'level'  => $request->level,
                'sub'    => $request->sub
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            DB::commit();

            return redirect()->route('admin.indexUser')->with('success', 'Profile Berhasil Di Update');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.indexUser')->with('error', 'error: ' . $e->getMessage());
        }
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }
    // End of User Controller
}
