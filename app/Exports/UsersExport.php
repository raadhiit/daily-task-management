<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }
    
    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'NO',
            'DATE',
            'ID PIC',
            'PIC',
            'ID MACHINING',
            'ID SUB',
            'ID JOB',
            'WORK CENTER',
            'TASK NAME',
            'PRODUCTION HOUR',
            'START',
            'ITU',
            'DIE PART',
            'PRODUCTION MINUTE',
            'STOP',
        ];
    }
}
