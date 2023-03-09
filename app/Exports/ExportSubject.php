<?php

namespace App\Exports;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportSubject implements FromCollection,WithMapping,WithHeadings
{
    use Exportable;
    public function collection()
    {
        return Subject::all();
    }
    public function map($subject): array
    {
        return [
            $subject->name,
            $subject->code,
            $subject->note,
            $subject->fee,
            $subject->status,
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'code',
            'note',
            'fee',
            'status',
        ];
    }
}
