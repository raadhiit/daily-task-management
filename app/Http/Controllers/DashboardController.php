<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\JobList;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // $proses = JobList::select('id_job','task_name')->first();
        // return view('dashboard', compact('proses'));

        $machines = [301, 302, 303, 304];
        $currentProcesses = [];

        foreach ($machines as $machineId) {
            $task = JobList::where('id_mch', $machineId)
                ->orderBy('created_at', 'asc')
                ->first();

            $currentProcesses[$machineId] = $task;
        }

        return view('dashboard', compact('currentProcesses', 'machines'));

    }
}
