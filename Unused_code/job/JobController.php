<?php

namespace App\Http\Controllers;

use App\Models\ljkh;
use App\Models\Anumber;
use App\Models\JobList;
use App\Models\activity;
use App\Models\operator;
use App\Exports\ExportJob;
use App\Imports\JobImport;  
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');
        Paginator::useBootstrap();
        $ListJobQuery = ljkh::orderBy('created_at', 'asc');

        // Jika pengguna memiliki level 3 (member), saring berdasarkan id_mch
        if (auth()->user()->level == 3) {
            $user_id_mch = Auth::user()->id_mch;
            $ListJobQuery->where('id_mch', $user_id_mch);
        }

        $ljkh = $ListJobQuery->where(function($query) use ($search) {
            $query  ->where('id_mch', 'LIKE', "%$search%")
                    ->orWhere('id_job', 'LIKE', "%$search%");
        })->simplePaginate(10);

        return view('member.job', compact('ljkh', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $idMchs = Operator::pluck('id_mch', 'id_mch');
        $taskNames = activity::pluck('activity_name', 'activity_name');
        $anumbers = Anumber::pluck('A_number', 'A_number');
        return view('job.create', compact('idMchs','taskNames', 'anumbers'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_job' => [
                'required',
                'min:7',
                'max:7',
                function ($attribute, $value, $fail) {
                    // Pemeriksaan format id_job (A tahun 2 digit + 4 digit urutan + " - " + die_part)
                    if (!preg_match('/^A\d{2}\d{4}$/', $value)) {
                        $fail('Format ID JOB tidak valid.');
                    }

                    // Pemeriksaan keberadaan id_job di tabel anumber
                    $anumberExists = Anumber::where('A_number', substr($value, 0, 7))->exists();
                    if (!$anumberExists) {
                        $fail('ID JOB tidak terdaftar dalam tabel Anumber.');
                    }
                },
            ],
            'die_part' => 'required|in:70,71,72',
            'work_ctr' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('job.create')
                ->withErrors($validator)
                ->withInput();
        }

        $diePart = $request->die_part; // Angka die_part (70, 71, 72)
        $idJob = $request->id_job . ' - ' . $request->die_part;
        $diePartLabel = $this->getDiePartLabel($diePart);

        // Simpan data ke dalam tabel Job_List
    
        JobList::create([
            'project'       => $request->project,
            'id_job'        => $idJob,
            'id_mch'        => $request->id_mch,
            'work_ctr'      => $request->work_ctr,
            'OP'            => $request->OP,
            'die_part'      => $diePartLabel,
            'activity_name' => $request->activity_name,
            'status'        => 'queued',
        ]);

        ljkh::create([
            'project'       => $request->project,
            'id_job'        => $idJob,
            'id_mch'        => $request->id_mch,
            'work_ctr'      => $request->work_ctr,
            'OP'            => $request->OP,
            'die_part'      => $diePartLabel,
            'activity_name' => $request->activity_name,
            'date_stop'     => $request->date_stop,
            'status'        => 'queued',
        ]);

        return redirect()->route('member.indexJob')->with('success', 'Job berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ListJob = JobList::findOrFail($id);
        $idMchs = Operator::pluck('id_mch', 'id_mch');
        $idJob = anumber::pluck('A_number', 'A_number');
        $taskNames = activity::pluck('activity_name', 'activity_name');

        return view('job.edit', compact('ListJob','idMchs','idJob','taskNames'));
    }

    /** 
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_job'=>'required',
            // 'die_part' => 'required|in:70,71,72',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('job.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }
    
        $diePart = $request->die_part; // Angka die_part (70, 71, 72)
        $idJob = $request->id_job . ' - ' . $request->die_part;
        $diePartLabel = $this->getDiePartLabel($diePart);

        $ListJob = JobList::findOrFail($id);
        $project = $request->project;
        $status = $ListJob->status;
        $ListJob->update([
            'project'       => $project,
            'id_job'        => $idJob,
            'id_mch'        => $request->id_mch,
            'work_ctr'      => $request->work_ctr,
            'OP'            => $request->OP,
            'die_part'      => $diePartLabel,
            'activity_name' => $request->activity_name,
            'status'        => $status
        ]);

        ljkh::where('id_job', $idJob)->update([
            'project'       => $project,
            'id_job'        => $idJob,
            'id_mch'        => $request->id_mch,
            'work_ctr'      => $request->work_ctr,
            'OP'            => $request->OP,
            'die_part'      => $diePartLabel,
            'activity_name' => $request->activity_name,
            'date_stop'     => $request->date_stop,
            'status'        => $status
        ]);
        
        
        return redirect()->route('member.indexJob')->with('success', 'Job berhasil diupdate');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ListJob = JobList::findOrFail($id);
        ljkh::where('id_job', $ListJob->id_job)->delete();
        $ListJob->delete();
        
        return redirect()->route('member.indexJob')->with('success', 'Job telah di hapus');
    }

    public function showImportJobForm()
    {
        return view('job.import'); 
    }

    public function exportJob()
    {
        return Excel::download(new ExportJob, 'job_list.xlsx');
    }

    public function importJob(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new JobImport, $file);

        return redirect()->route('member.indexJob')->with('success', 'Data berhasil diimpor');
    }

    protected function getDiePartLabel($diePart)
    {
        
        switch ($diePart) {
            case '70':
                return 'Upper';
            case '71':
                return 'Lower';
            case '72':
                return 'Pad';
            default:
                return '';
        }
    }

}