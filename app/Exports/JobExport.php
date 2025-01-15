<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\JobList;

class ExportJob implements FromCollection
{
    public function collection()
    {
        return JobList::all();
    }
}
