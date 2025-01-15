<!-- Start Controller without database Validation For JobList in ForemanController (Ln104) -->
    <!--  public function storeJobList(Request $request)
        {
            $request->validate([
                'id_mch' => 'required',
                'id_job' => 'required|unique:job_lists,id_job|min:7|max:7',
                'die_part' => 'required|in:70,71,72',
                'task_name' => 'required',
            ]);
        
            $diePart = $request->die_part;  Angka die_part (70, 71, 72)
            $idMch = $request->id_mch;
            $taskName = $request->task_name;
        
            Ambil nilai id_job yang dimasukkan oleh pengguna
            $idJobInput = $request->id_job;
        
            Ambil label dari die_part yang dipilih
            $diePartLabel = $this->getDiePartLabel($diePart);
        
            Buat id_job berdasarkan format yang Anda inginkan
            $idJob = Job::generateIdJob($idJobInput, $diePart);
        
            Simpan data ke dalam tabel Job_List
            JobList::create([
                'id_job' => $idJob,
                'die_part' => $diePartLabel,
                'id_mch' => $idMch,
                'task_name' => $taskName,
            ]);
        
            return redirect()->route('job.index')->with('success', 'Job berhasil dibuat');
        } -->
<!-- End Controller without database Validation For JobList in ForemanController (Ln104) -->

<!-- Start controller for workstation.index in ForemanController at ForemanController(Ln27)  -->
    <!-- public function index(Request $request)
        {
            $idMchs = Operator::pluck('id_mch', 'id_mch');
            
            Get the currently authenticated user's id_mch
            $user_id_mch = Auth::user()->id_mch;
            
            $search = $request->input('search');
            Paginator::useBootstrap();
            $workStation = jobList::where('id_mch', $user_id_mch)->get()(function($query) use ($search) 
            {
                $query  ->where('id_mch', 'LIKE', "%$search%")
                        ->orWhere('id_job', 'LIKE', "%$search%")
                        ->orWhere('die_part', 'LIKE', "%$search%");
            })->Paginate(10);
            
            return view('workstation.index', compact('workStation','search','idMchs'));
        } -->
<!-- End Start controller for workstation.index in ForemanController at ForemanController(Ln27)  -->


<!-- Start controller for jobStart in MemberController (ln 59) -->
    <!-- public function jobStart(Request $request)
    {
        $date = Carbon::now()->toDateString(); 
        $time = Carbon::now()->toTimeString(); 

        $data = $request->all();
        $data['Date'] = $date;
        $data['start'] = $time;

        $job = ljkh::create($data);
        $job->save();
        
        return redirect()->route('member.index')->with('success', 'Job Dimulai');
    } -->
<!-- End controller for jobStart in MemberController (ln 59) -->

<!-- Start controller for update Job in JobController (ln 142) -->
    <!-- public function jobStart(Request $request)
    {
        $date = Carbon::now()->toDateString(); 
        $time = Carbon::now()->toTimeString(); 

        $data = $request->all();
        $data['Date'] = $date;
        $data['start'] = $time;
        $job = ljkh::create($data);
        $job->save();
        return redirect()->route('member.index')->with('success', 'Job Dimulai');
    } -->
<!-- End controller for update Job in JobController (ln 142) -->

 <!-- public function jobEnd($id_job, Request $request)
     {
         $currentJob = Carbon::now();
        
         $ljkh = Ljkh::where('id_job', $id_job)->first();  Pastikan model disebutkan dengan benar (Ljkh)
         if ($ljkh) {
             $ljkh->update([
                 'stop' => $currentJob,
             ]);
         }
    
         $jobList = JobList::where('id_job', $id_job)->first();  Pastikan model disebutkan dengan benar (JobList)
         if ($jobList) {
             $jobList->update([
                 'stop' => $currentJob,
             ]);
         }
        
         return redirect()->route('member.index')->with('success', 'Pekerjaan berakhir');
     }

     public function jobStart($id_job, Request $request) {
         $date = Carbon::now()->toDateString(); 
         $time = Carbon::now()->toTimeString(); 
         $user = Auth::user();
        
         $ljkhRow = ljkh::where('id_job', $id_job)
             ->whereNull('Date')
             ->whereNull('name')
             ->whereNull('start')
             ->first();
    
         $jobListRow = JobList::where('id_job', $id_job)
             ->whereNull('Date')
             ->whereNull('name')
             ->whereNull('start')
             ->first();
    
         if ($ljkhRow) {
             $ljkhRow->update([
                 'Date' => $date,
                 'name' => $user->name,
                 'start' => $time,
                 'status' => 'in progress'
             ]);
         }
    
         if ($jobListRow) {
             $jobListRow->update([
                 'Date' => $date,
                 'name' => $user->name,
                 'start' => $time
             ]);
         }
    
         return redirect()->route('member.index')->with('success', 'Job Dimulai');
     }

     public function jobStart($id_job, Request $request)
     {
         $date = Carbon::now()->toDateString(); 
         $time = Carbon::now()->toTimeString(); 
         $user = Auth::user();
        
         $ljkhRow = Ljkh::where('id_job', $id_job)
             ->where('status', 'queued')
             ->whereNull('Date')
             ->whereNull('name')
             ->whereNull('start')
             ->first();

         $jobListRow = JobList::where('id_job', $id_job)
             ->where('status', 'queued')
             ->whereNull('Date')
             ->whereNull('name')
             ->whereNull('start')
             ->first();

         if ($ljkhRow) {
             $ljkhRow->update([
                 'Date' => $date,
                 'name' => $user->name,
                 'start' => $time,
                 'status' => 'in progress'
             ]);
         }

         if ($jobListRow) {
             $jobListRow->update([
                 'Date' => $date,
                 'name' => $user->name,
                 'start' => $time,
                 'status' => 'in progress'
             ]);
         }

         return redirect()->route('member.index')->with('success', 'Job Dimulai');
     } -->

     <!-- // public function index()
    // {
    //     $user = Auth::user()->id_mch;

    //     $JobList = JobList::where(function($query) use ($user){ 
    //         $query->where('status', 'queued')->orWhere('status', 'In prgoress');
    //     })->where('id_mch', $user)->first();

    //     $secondJob = JobList::where('status', 'queued')
    //                         ->where('id_mch', $user)
    //                         ->skip(1)
    //                         ->first();

    //     $ljkh = ljkh::where('id_mch', $user)->oldest()->first();

    //     // dd($JobList);
    //     return view('member.index', compact('ljkh', 'JobList', 'secondJob', 'user'));

    // }
        // public function index()
    // {
    //     $user = Auth::user()->id_mch;

    //     $ljkh = ljkh::where('id_mch', $user)->oldest()->first();
        
    //     $JobList = JobList::where('status', 'queued')
    //                         ->orWhere('status', 'In progress')
    //                         ->where('id_mch', $user)
    //                         ->first();

    //     $secondJob = JobList::where('status', 'queued')
    //                         ->where('id_mch', $user)
    //                         ->skip(1)
    //                         ->first();

    //     return view('member.index', compact('ljkh', 'JobList', 'secondJob', 'user'));
    // } -->

    <!-- // public function update(Request $request, string $id)
    // {
    //     $validasi = Validator::make($request->all(), [
    //         'project' => 'required',
    //         'Anumber' => 'required|Anumber',
    //     ], [
    //         'project.required' => 'project wajib diisi',
    //         'Anumber.required' => 'Anumber wajib diisi',
    //         'Anumber.Anumber' => 'Format Anumber wajib benar',
    //     ]);

    //     if ($validasi->fails()) {
    //         return response()->json(['errors' => $validasi->errors()]);
    //     } else {
    //         $data = [
    //             'project' => $request->project,
    //             'Anumber' => $request->Anumber
    //         ];
    //         Project::where('id', $id)->update($data);
    //         return response()->json(['success' => "Berhasil melakukan update data"]);
    //     }
    
    // } -->

    <!-- // public function store(Request $request)
    // {
    //     $validasi = Validator::make($request->all(), [
    //         'project' => 'required',
    //         'Anumber' => 'required|Anumber',
    //     ], [
    //         'project.required' => 'project wajib diisi',
    //         'Anumber.required' => 'Anumber wajib diisi',
    //         'Anumber.Anumber' => 'Format Anumber wajib benar',
    //     ]);

    //     if ($validasi->fails()) {
    //         return response()->json(['errors' => $validasi->errors()]);
    //     } else {
    //         $data = [
    //             'project' => $request->project,
    //             'Anumber' => $request->Anumber
    //         ];
    //         Project::create($data);
    //         return response()->json(['success' => "Berhasil menyimpan data"]);
    //     }
    // } -->

    <!--     // public function index_project(Request $request)
    // {
    //     //medapatkan semua data category
    //     $data = Project::all();
    //     //jika ada request ajax maka yang direturn adalah datatables
    //     if ($request->ajax()) {
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 //kita tambahkan button edit dan hapus
    //                 $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" 
    //                 class="edit btn btn-primary btn-sm editProjek">Edit</a>';

    //                 $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id . '" 
    //                 class="btn btn-danger btn-sm deleteProjek">Delete</a>';

    //                 return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('admin.index',compact('data'));
    // }

    // public function index(Request $request)
    // {
    //     $data = Project::orderBy('Anumber', 'asc');
    //     if($request->ajax()){
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('aksi', function ($data) {
    //                 return view('admin.tombol')->with('data', $data);
    //             })
    //             ->make(true);
    //     }
    //     return view('admin.index', compact('data'));
    // } -->

    <!--     // public function jobStart($id, Request $request)
    // {
    //     $date = Carbon::now()->toDateString(); 
    //     $time = Carbon::now()->toTimeString(); 
    //     $user = Auth::user();
        
    //     // Mengambil pekerjaan berikutnya yang masih dalam status antrian
    //     $JL = JobList::where('status', 'ready')
    //                         ->where('id_mch', $user->id_mch)
    //                         ->orderBy('id_job')
    //                         ->first();

    //     $ljkh = ljkh::where('status', 'queued')
    //                         ->where('id_mch', $user->id_mch)
    //                         ->orderBy('id_job')
    //                         ->first();

    //     if ($JL) {
    //         $JL->update([
    //             'name'      => $user->name,
    //             'status'    => 'In progress'
    //         ]);
    //     }

    //     if($ljkh) {
    //         $ljkh->update([
    //             'Date'      => $date,
    //             'name'      => $user->name,
    //             'start'     => $time,
    //             'sub'       => $user->sub,
    //             'status'    => 'In progress'
    //         ]);
    //     }

    //     return redirect()->route('member.index')->with('success', 'Job Dimulai');
    // } -->

    <!--     // public function jobStart($id, Request $request)
    // {
    //     // Ambil data ljkh berdasarkan ID
    //     $ljkh = ljkh::find($id);
        
    //     // Pastikan data dengan ID yang diberikan ditemukan
    //     if (!$ljkh) {
    //         return response()->json(['error' => 'Data not found'], 404);
    //     }

    //     // Mengisi kolom activity_name dengan data yang dipilih dari modal
    //     $ljkh->activity_name = $request->input('activity_name');

    //     // Menghitung kolom Date, start, stop, dan prod_hour menggunakan Carbon
    //     $ljkh->Date = Carbon::now();
    //     $ljkh->start = Carbon::now();

    //     // Ambil data name, id_mch, dan sub dari pengguna yang sedang login
    //     $ljkh->name = Auth::user()->name;
    //     $ljkh->id_mch = Auth::user()->id;
    //     $ljkh->sub = Auth::user()->sub;

    //     // Simpan perubahan
    //     $ljkh->save();

    //     return response()->json(['success' => true]);
    // } -->

<!-- 
        // public function takeJob($id, Request $request)
    // {
    //     $user = Auth::user()->id_mch;
    //     $ljkh = ljkh::find($id);
    //     $jobList = JobList::find($id);

    //     if(!$ljkh){
    //         return redirect()->route('member.index')->with('error', 'Job Tidak Ditemukan');
    //     }

    //     if(!$jobList) {
    //         return redirect()->route('member.index')->with('error', 'Not Found');
    //     }

    //     $ljkh->status = 'ready';
    //     $ljkh->save();

    //     $jobList->status_job = 'ready';
    //     $jobList->save();
        
    //     return response()->json(['success' => true]);
    // }
-->

<!-- 
    // public function autoRun($id, Request $request)
    // {
    //     $date = Carbon::now()->toDateString(); 
    //     $time = Carbon::now(); 
    //     $user = Auth::user();

    //     $ljkh = ljkh::where('id_mch', $user->id_mch)
    //                 ->where('status', 'In progress')
    //                 ->get();

    //     if($ljkh->isEmpty()) {
    //         return response()->json(['message' => 'gagal pokonya']. 400);
    //     }else {
    //         foreach ($ljkh as $item){
    //             if($item){
    //                 $item->update([
    //                     'start'     => $time,
    //                     'status'    => 'Complete-NPK',
    //                     'date_stop' => $date,
    //                 ]);
    //                 // Menghitung selisih waktu dalam detik
    //                 $timeDiffInSeconds = $item->stop->diffInSeconds($item->start);
                
    //                 // Mengubah waktu ke menit jika kurang dari 1 jam, jika lebih, maka ke jam
    //                 $formattedTime = $timeDiffInSeconds < 3600 ? ceil($timeDiffInSeconds / 60) . ' Menit' : ceil($timeDiffInSeconds / 3600) . ' Jam';
            
    //                 // Menghentikan `jobStart` yang sedang berjalan
    //                 $item->update([
    //                     'prod_hour' => $formattedTime
    //                 ]);
    //             }else {
    //                 return response()->json(['message' => 'Data not found'], 400);
    //             }
        
    //             // duplikasi data
    //             $newLjkh = $item->replicate();
    //             unset($newLjkh->job_id);
    //             $newLjkh->activity_name = $request->input('activity_name');
    //             $newLjkh->Date = $date;
    //             $newLjkh->status = 'NPK';
    //             if ($newLjkh->save()) {
    //                 // Pekerjaan yang baru berhasil disimpan
    //             } else {
    //                 return response()->json(['message' => 'Failed to save duplicated job'], 500);
    //             }
    //         }
    //     }


    //     return response()->json(['message' => 'Job Sedang Auto Run']);

    // } -->

    <!--     // public function jobEnd($id, Request $request)
    // {
    //     $currentJob = Carbon::now();
    //     $date = Carbon::now()->toDateString();
    //     $user = Auth::user();

    //     // LJKH
    //     $ljkh = ljkh::where('id_mch', $user->id_mch)
    //                 ->where('status', 'In progress')
    //                 ->orWhere('status', 'NPK')
    //                 ->first();

    //     if ($ljkh) {
    //         $ljkh->update([
    //             'stop'      => $currentJob,
    //             'status'    => 'Complete',
    //             'date_stop' => $date,
    //             'note'      => $request->input('note'),
    //         ]);
    
    //         // Menghitung selisih waktu dalam detik
    //         $timeDiffInSeconds = $ljkh->stop->diffInSeconds($ljkh->start);
    
    //         // Mengubah waktu ke menit jika kurang dari 1 jam, jika lebih, maka ke jam
    //         $formattedTime = $timeDiffInSeconds < 3600 ? ceil($timeDiffInSeconds / 60) . ' Menit' : ceil($timeDiffInSeconds / 3600) . ' Jam';
    
    //         $ljkh->update([
    //             'prod_hour' => $formattedTime
    //         ]);
    //     }else {
    //         return response()->json(['error' => 'FAK LAH KATA GUA TEH, DATANYA KEMANA JING!'], 404);
    //     }

    //     // JOB LIST
    //     $jobList = JobList::where('id_mch', $user->id_mch)
    //                     ->where('status_job', 'In progress')
    //                     ->first();

    //     if($jobList) {
    //         $jobList->update([
    //             'status_job' => 'Complete'
    //         ]);
    //     }else {
    //         return response()->json(['error' => 'Data joblist not found'], 404);
    //     }
        
    //     return response()->json(['success' => true]);
    // } -->

    <!-- 
            // public function nextShift(Request $request) 
    // {
    //     $currentJob = Carbon::now();
    //     $date = Carbon::now()->toDateString();
    //     $user = Auth::user();

    //     // ljkh
    //     $ljkh = ljkh::where('id_mch', $user->id_mch)
    //                 ->where('status', 'In progress')
    //                 ->orderBy('id')
    //                 ->get();

    //     try{
    //         DB::beginTransaction();

    //         foreach($ljkh as $l) {
    //             $l->update([
    //                 'note'      => $request->input('note'),
    //                 'status'    => 'Complete',
    //                 'stop'      => $currentJob,
    //                 'date_stop' => $date
    //             ]);

    //             // Menghitung selisih waktu dalam detik
    //             $timeDiffInSeconds = $l->stop->diffInSeconds($l->start);
    //             // Mengubah waktu ke menit jika kurang dari 1 jam, jika lebih, maka ke jam
    //             $formattedTime = $timeDiffInSeconds < 3600 ? ceil($timeDiffInSeconds / 60) . ' Menit' : ceil($timeDiffInSeconds / 3600) . ' Jam';
    //             $l->update([
    //                 'prod_hour' => $formattedTime
    //             ]);

    //             $dupLjkh = $l->replicate();
    //             $dupLjkh->job_id        = null;
    //             $dupLjkh->Date          = null;
    //             $dupLjkh->name          = null;
    //             $dupLjkh->activity_name = null;
    //             $dupLjkh->start         = null;
    //             $dupLjkh->prod_hour     = null;
    //             $dupLjkh->stop          = null;
    //             $dupLjkh->date_stop     = null;
    //             $dupLjkh->status        = 'queued';

    //             if (!$dupLjkh->save()) {
    //                 DB::rollBack();
    //                 return response()->json(['message' => 'Gagal duplikat job'], 500);
    //             }

    //                         // Peroleh ID baru dan set ke kolom job_id
    //             $newJobId = $dupLjkh->id;
    //             $dupLjkh->update(['job_id' => $newJobId]);
    //         }

    //         DB::Commit();
    //     } catch(\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'Gagal Update Data'], 500);
    //     }

    //     try {
    //         $jobList = JobList::where('id_mch', $user->id_mch)
    //                         ->where('status_job', 'In progress')
    //                         ->firstOrFail();

    //         $jobList->update(['status_job' => 'Complete']);
    //     } catch(\Exception $e) {
    //         return response()->json(['error' => 'JobList Not Found'], 400);
    //     }

    //     return response()->json(['success' => true]);
    // }

-->

<!-- 
        // public function autoIdle(Request $request)
    // {
    //     $user = Auth::user();
    //     $date = Carbon::now()->toDateString();
    //     $end = Carbon::now();

    //     $target = Carbon::now();
    //     $target->setTime(10,35,0);

    //     // Hitung selisih waktu dalam detik
    //     $timeDiffInSeconds = Carbon::parse($end)->diffInSeconds($target);
    //     // Hitung prod_hour
    //     $formattedTime = $timeDiffInSeconds < 3600 ? ceil($timeDiffInSeconds / 60) . ' Menit' : ceil($timeDiffInSeconds / 3600) . ' Jam';

    //     ljkh::create([
    //         'Date'          => $date,
    //         'name'          => $user->name,
    //         'id_mch'        => $user->id_mch,
    //         'sub'           => $user->sub,
    //         'id_job'        => 'N000005',
    //         'work_ctr'      => 'MCH-PREF',
    //         'activity_name' => 'IDLE TIME',
    //         'start'         => $target,
    //         'stop'          => $target,
    //         'prod_hour'     => $formattedTime,
    //         'date_stop'     => $date
    //     ]);

    //     return response()->json(['success' => true]);
    // }
 -->

 <!-- 
        // public function autoRunNPK($id, Request $request)
    // {
    //     try {
    //         $date = Carbon::now()->toDateString();
    //         $user = Auth::user();
    //         $stop = Carbon::now();
    //         $start = Carbon::now();
    //         $idMch = $request->session()->get('id_mch');
    //         $ljkh = ljkh::where('id', $id)
    //                     ->where('id_mch', $idMch)
    //                     ->first();
    //         $jobList = JobList::where('id', $ljkh->job_id)
    //             ->where('id_mch', $idMch)->first();

    //         DB::beginTransaction();
    //         if ($ljkh) {
    //             $ljkh->update(['stop' => $stop]);

    //             $timeDiffInSeconds = Carbon::parse($ljkh->stop)->diffInSeconds($ljkh->start);
    //             $formattedTime = $timeDiffInSeconds < 3600 ? ceil($timeDiffInSeconds / 60) . ' Menit' : ceil($timeDiffInSeconds / 3600) . ' Jam';
    //             $ljkh->update([
    //                 'prod_hour' => $formattedTime,
    //                 'status'    => 'Complete'
    //             ]);
    //             $jobList->update(['status_job' => 'In progress']);

    //             ljkh::create([
    //                 'Date'          => $date,
    //                 'job_id'        => $ljkh->job_id,
    //                 'name'          => $user->name,
    //                 'project'       => $ljkh->project,
    //                 'id_job'        => $ljkh->id_job,
    //                 'activity_name' => 'NPK ' . $ljkh->activity_name,
    //                 'status'        => 'In progress',
    //                 'id_mch'        => $idMch,
    //                 'sub'           => $user->sub,
    //                 'work_ctr'      => $ljkh->work_ctr,
    //                 'die_part'      => $ljkh->die_part,
    //                 'start'         => $start,
    //             ]);
    //         } else {
    //             throw new \Exception('Data not found');
    //         }

    //         DB::commit();
    //         return response()->json(['success' => true], 200);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }
  -->

  <!--  LJKH
        public function importLJKH(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new LJKHImport, $file);

        // return redirect()->route('products.index')->with('success', 'Data berhasil diimpor');
        return response()->json(['message' => 'Data berhasil diimpor']);
    }

        // public function create()
    // {
    //     $idMchs = Operator::pluck('id_mch', 'id_mch');
    //     $taskNames = activity::pluck('activity_name', 'activity_name');

    //     return view('admin.addLJKH', compact('idMchs', 'taskNames'));
    // }

    // public function store(Request $request)
    // {
    //     $date = Carbon::now()->toDateString();
    //     $time = Carbon::now()->toTimeString();

    //     $data = $request->all();
    //     $data['Date'] = $date;
    //     $data['start'] = $time;

    //     $product = ljkh::create($data);

    //     return redirect()->route('admin.addLJKH')->with('success', 'Job added successfully');
    // }
   -->

   <!-- 
      // public function istirahatDone($id, Request $r)
    // {
    //     try{
    //         $user = Auth::user();
    //         $stop = Carbon::now();
    //         $date = Carbon::now();
    //         $idMch = $r->session()->get('id_mch');
            // $ljkh = ljkh::where('id', $id)->where('id_mch', $idMch)->where('status', 'break')->first();
    //         $jobList = JobList::where('id', $ljkh->job_id)->where('id_mch', $idMch)->where('status', 'break')->first();

    //         DB::beginTransaction();
    //         if ($ljkh) {
    //             $ljkh->update(['stop' => $stop]);
    //             $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
    //             $ljkh->update([
    //                 'prod_hour' => $prodHour,
    //                 'status'    => 'Complete'
    //             ]);
    //             $jobList->update(['status_job' => 'ready']);

    //             ljkh::create([
    //                 'Date'          => $date,
    //                 'job_id'        => $ljkh->job_id,
    //                 'name'          => $user->name,
    //                 'project'       => $ljkh->project,
    //                 'id_job'        => $ljkh->id_job,
    //                 'activity_name' => $r->input('activity_name'),
    //                 'status'        => 'ready',
    //                 'id_mch'        => $idMch,
    //                 'sub'           => $user->sub,
    //                 'work_ctr'      => $ljkh->work_ctr,
    //                 'die_part'      => $ljkh->die_part,
    //             ]);
    //         } else {
    //             throw new \Exception('Data not found');
    //         }
    //         DB::commit();
    //         return response()->json(['success' => true], 200);
    //     }catch(\Exception $e){
    //         DB::rollback();
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }

    // public function istirahatDone($id, Request $r)
    // {
    //     try{
    //         DB::beginTransaction();
    //         $user = Auth::user();
    //         $stop = Carbon::now();
    //         $date = Carbon::now();
    //         $idMch = $r->session()->get('id_mch');
    //         $ljkh = ljkh::where('id', $id)
    //                     ->where('id_mch', $idMch)
    //                     ->where('status', 'break')
    //                     ->first();
    //         $jobList = JobList::where('id_mch', $idMch)
    //                         ->where('status_job', 'break')
    //                         ->latest()
    //                         ->first();

    //         if($ljkh){
    //             $jobList->update(['status_job' => 'ready']);
    //             $ljkh->update([
    //                 'stop'      => $stop,
    //                 'prod_hour' => $this->prodHour($ljkh->start, $ljkh->stop),
    //                 'status'    => 'Complete'
    //             ]);

    //             ljkh::create([
    //                 'Date'          => $date,
    //                 'job_id'        => $ljkh->job_id,
    //                 'name'          => $user->name,
    //                 'project'       => $ljkh->project,
    //                 'id_job'        => $ljkh->id_job,
    //                 'activity_name' => $r->input('activity_name'),
    //                 'status'        => 'ready',
    //                 'id_mch'        => $idMch,
    //                 'sub'           => $user->sub,
    //                 'work_ctr'      => $ljkh->work_ctr,
    //                 'die_part'      => $ljkh->die_part,
    //             ]);
    //         }else{
    //             throw new \Exception('Data Not Found');
    //         }
    //         DB::commit();
    //         return response()->json(['success' => true], 200);
    //     }catch(\Exception $e){
    //         DB::rollback();
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }

        // public function istirahat($id, Request $r)
    // {
    //     try{
    //         $user = Auth::user();
    //         $stop = Carbon::now();
    //         $date = Carbon::now();
    //         $idMch = $r->session()->get('id_mch');
    //         $ljkh = ljkh::where('id', $id)->where('id_mch', $idMch)->where('status', 'In progress')->first();
    //         $jobList = JobList::where('id', $ljkh->job_id)->where('id_mch', $idMch)->first();

    //         DB::beginTransaction();
    //         if ($ljkh) {
    //             $ljkh->update(['stop' => $stop]);
    //             $prodHour = $this->prodHour($ljkh->start, $ljkh->stop);
    //             $ljkh->update([
    //                 'prod_hour' => $prodHour,
    //                 'status'    => 'Complete'
    //             ]);
    //             $jobList->update(['status_job' => 'break']);

    //             ljkh::create([
    //                 'Date'          => $date,
    //                 'job_id'        => $ljkh->job_id,
    //                 'name'          => $user->name,
    //                 'project'       => $ljkh->project,
    //                 'id_job'        => $ljkh->id_job,
    //                 'activity_name' => $r->input('activity_name'),
    //                 'status'        => 'break',
    //                 'id_mch'        => $idMch,
    //                 'start'         => $stop,
    //                 'sub'           => $user->sub,
    //                 'work_ctr'      => $ljkh->work_ctr,
    //                 'die_part'      => $ljkh->die_part,
    //             ]);
    //         } else {
    //             throw new \Exception('Data not found');
    //         }
    //         Session::forget('status');
    //         DB::commit();
    //         return response()->json(['success' => true], 200);
    //     }catch(\Exception $e){
    //         DB::rollback();
    //         return response()->json(['error' => $e->getMessage()],400);
    //     }
    // }
    -->

    <!-- 
    private function calculateProdHour($start, $stop)
    {
        $startTime = Carbon::parse($start);
        $stopTime = Carbon::parse($stop);

        $duration = $stopTime->diff($startTime);
        $hours = $duration->h;
        $minutes = $duration->i;

        if ($hours > 0) {
            return $hours . ' Jam';
        } else {
            return $minutes . ' Menit';
        }
    } -->

    <!--  calculate prod hour
        // if ($hours > 0) {
        //     $formattedTime = "$hours Jam";
        // } else {
        //     $formattedTime = '';
        // }

        // if ($minutes > 0) {
        //     $formattedTime .= ($formattedTime !== '' ? ' ' : '') . "$minutes Menit";
        // }

        // if (empty($formattedTime)) {
        //     $formattedTime = "1 Menit";
        // } -->

        <!-- input mannual autoRunEnd -->
        <!--             // if ($inputStop !== null) {
            //     if (strpos(strtolower($inputStop), 'jam') !== false) {
            //         $hours = (int) filter_var($inputStop, FILTER_SANITIZE_NUMBER_INT);
            //         $input = Carbon::now()->addHours($hours)->format('H:i');
            //     } elseif (strpos(strtolower($inputStop), 'menit') !== false) {
            //         $minutes = (int) filter_var($inputStop, FILTER_SANITIZE_NUMBER_INT);
            //         $input = Carbon::now()->addMinutes($minutes)->format('H:i');
            //     } else {
            //         throw new \Exception('Format input tidak valid');
            //     }
            // } -->

    // public function dashboard(Request $request, $param1 = null, $param2 = null, $param3 = null)
    // {
    //     $tahun = $param1;
    //     if ($tahun == null || $tahun == 'param1') {
    //         $tahun = Carbon::now()->format('Y');
    //     }
        
    //     $bulan = $param2;
    //     if ($bulan == null || $bulan == 'param2') {
    //         $bulan = Carbon::now()->format('m');
    //     }

    //     $status = $param3;
    //     if ($status == null || $status == 'param4') {
    //         $status = 'Complete';
    //     }

    //     $currentMonth = $tahun . '-' . $bulan;
    //     // dd($currentMonth, $status);
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
        
    //     // dd($working_hours);        
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

    //     return view('admin.DashboardAdmin', ['data' => $data]);
    // }

    // public function dashboard(Request $request, $param1 = null, $param2 = null, $param3 = null)
    // {
    //     $tahun = $param1;
    //     if ($tahun == null || $tahun == 'param1') {
    //         $tahun = Carbon::now()->format('Y');
    //     }
        
    //     $bulan = $param2;
    //     if ($bulan == null || $bulan == 'param2') {
    //         $bulan = Carbon::now()->format('m');
    //     }

    //     $status = $param3;
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

    //     return view('admin.DashboardAdmin', [
    //         'data' => $data,
    //         'selectedYear' => $tahun,
    //         'selectedMonth' => $bulan,
    //         'selectedStatus' => $status
    //     ]);
    // }