<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Batch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportStudent implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $batch=Batch::where('name',$row['batch'])->first();
        return new Student([
            'name'=>$row['name'],
            'reg_no'=>$row['reg_no'],
            'email'=>$row['email'],
            'batch_id'=>$batch->id,
            'gender'=>$row['gender'],
            'current_address'=>$row['current_address'],
            'permanent_address'=>$row['permanent_address'],
            'contact_number'=>$row['contact_number'],
            'parent_information'=>$row['parent_information'],
            'parent_contact'=>$row['parent_contact'],
            'guardian_information'=>$row['guardian_information'],
            'guardian_contact'=>$row['guardian_contact'],
            'status'=>$row['status'],
            'adjustment_type'=>$row['adjustment_type'],
            'initial_amount'=>$row['initial_amount'],
            'adjustment_balance'=>$row['adjustment_balance'],
            'adjustment_cause'=>$row['adjustment_cause'],
            'total_amount'=>$row['total_amount'],
            'monthly_fee'=>$row['monthly_fee'],
            'note'=>$row['note'],
        ]);
    }
}
