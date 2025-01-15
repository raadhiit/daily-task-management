<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\JobList;

/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
class JobImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
        return new JobList([
            'id_mch'    => $row['id_machining'],
            'id_job'    => $row['id_job'], 
            'task_name' => $row['task_name'], 
            'die_part'  => $row['die_part'], 
            'time_start'=> $row['time_start'],  
        ]);
    }
}