<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportTeacher implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $subjectrow=$row['subject'];
        $subjects=explode(",",$subjectrow);
        $subjectids=[];
        foreach ($subjects as $value){
            $subject=Subject::where('name',$value)->first();
            $subjectids[]=$subject->id;
        }
        dd($row);
        return new Teacher([
            'name'=>$row['name'],
            'reg_no'=>$row['reg_no'],
            'email'=>$row['email'],
            'id_number'=>$row['id_number'],
            'subject_id'=>json_encode($subjectids),
            'gender'=>$row['gender'],
            'reference'=>$row['reference'],
            'qualification'=>$row['qualification'],
            'current_address'=>$row['current_address'],
            'permanent_address'=>$row['permanent_address'],
            'contact_number'=>$row['contact_number'],
            'status'=>$row['status'],
            'monthly_salary'=>$row['monthly_salary'],
            'note'=>$row['note'],
        ]);
    }
}
