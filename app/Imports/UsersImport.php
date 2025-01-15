<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'id_pic'    => $row[0],
            'PIC'       => $row[1], 
            'id_mch'    => $row[2], 
            'id_sub'    => $row[3], 
            'id_job'    => $row[4], 
            'work_ctr'  => $row[5], 
            'task_name' => $row[6]
        ]);
    }
}
