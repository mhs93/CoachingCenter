<?php

namespace App\Imports;

use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBatch implements ToModel, WithHeadingRow{
    public function model(array $row)
    {
        $subjectrow=$row['subjects'];
        $subjects=explode(",",$subjectrow);
        $subjectids=[];
        foreach ($subjects as $value){
            $subject=Subject::where('name',$value)->first();
            $subjectids[]=$subject->id;
        }

        return new Batch([
            'name' => $row['name'],
            'status' => $row['status'],
//            'subject_id' =>  Subject::where('name', $row['subjects'])->firstOrFail()->id,
            'subject_id' =>  json_encode($subjectids),
            'note' => $row['note'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'adjustment_type' => $row['adjustment_type'],
            'initial_amount' => $row['initial_amount'],
            'adjustment_balance' => $row['adjustment_balance'],
            'total_amount' => $row['total_amount'],
            'adjustment_cause' => $row['adjustment_cause'],
            'created_by' => Auth::id(),
        ]);
    }
}
