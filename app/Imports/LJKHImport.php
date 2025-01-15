<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\ljkh;
use Carbon\Carbon;

/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    class LJKHImport implements ToModel,WithHeadingRow
    {
        public function model(array $row)
        {
            return new ljkh([
                'Date'          => $row['date'],
                'name'          => $row['name'],
                'id_mch'        => $row['id_machining'],
                'sub'           => $row['id_sub'],
                'id_job'        => $row['id_job'], 
                'work_ctr'      => $row['work_center'], 
                'activity_name' => $row['task_name'], 
                'prod_hour'     => $row['production_hour'], 
                'start'         => $row['start'],    
                'itu'           => $row['itu'],    
                'die_part'      => $row['die_part'], 
                'project'       => $row['project'], 
                'status'        => 'Complete'
            ]);
        }
    }
