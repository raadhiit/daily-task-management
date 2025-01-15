<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Project;

/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    class ProjectImport implements ToModel,WithHeadingRow
    {
        public function model(array $row)
        {
            return new Project([
                'project'       => $row['project'], 
                'part_name'     => $row['part_name'],
                'part_no'       => $row['part_no'],
                'targetHour'    => $row['targetHour'],
                'anumber'       => $row['anumber'],
            ]);
        }
    }

