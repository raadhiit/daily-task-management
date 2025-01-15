<?php

namespace App\Exports;

use App\Models\ljkh;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LJKHExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = ljkh::select(
            DB::raw('ROW_NUMBER() OVER() as no'),
            'Date',
            'name',
            'id_mch',
            'sub',
            'id_job',
            'work_ctr',
            'activity_name',
            'prod_hour',
            'start',
            'itu',
            'die_part',
            'project'
        )->where('status', 'Complete')->get();

        $data->each(function ($item, $key) {
            $item->no = $key + 1;
        });

        return $data;
    }

    public function headings(): array
    {
        return  [
            'NO',
            'DATE',
            'NAME',
            'ID MACHINING',
            'ID SUB',
            'ID JOB',
            'WORK CENTER',
            'TASK NAME',
            'PRODUCTION HOUR',
            'START',
            'ITU',
            'DIE PART',
            'PROJECT'
        ];
    }

    public function styles(Worksheet $sheet)
    {

        // Set alignment to center for all columns
        for ($i = 'A'; $i <= 'K'; $i++) {
            $sheet->getStyle($i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
        
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'C5D9F1'],
                ],
            ],
        ];
    }
}
