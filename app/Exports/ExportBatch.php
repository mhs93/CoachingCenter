<?php

namespace App\Exports;
use App\Models\Subject;
use App\Models\Batch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportBatch implements FromCollection,WithMapping,WithHeadings
{

    use Exportable;

    public function map($batch): array
    {
        $subjectIds=json_decode($batch->subject_id);
        $subjects= "";
        foreach ($subjectIds as $subjectId){
            $subject= Subject::where('id', $subjectId)->first();
            $subjects.= $subject->name.',';
        }
        $adjust = $batch->adjustment_type;
        if ($adjust == 1){
           $adj_type = 'Addition';
        }else{
            $adj_type = 'Subtraction';
        }

        return [
            $batch->name,
            $batch->status,
            $subjects,
            $batch->note,
            $batch->start_date,
            $batch->end_date,
            $adj_type,
            $batch->initial_amount,
            $batch->adjustment_balance,
            $batch->total_amount,
            $batch->adjustment_cause,
        ];
    }
    public function collection()
    {
        return Batch::with('subjects')->get();
    }
    public function headings(): array
    {
        return [
            'Name',
            'status',
            'Subjects',
            'Note',
            'Start Date',
            'End Date',
            'Adjustment Type',
            'Initial Amount',
            'Adjustment Balance',
            'Total Amount',
            'Adjustment Cause',
        ];
    }
}