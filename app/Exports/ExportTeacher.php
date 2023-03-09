<?php

namespace App\Exports;
use App\Models\Subject;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportTeacher implements FromCollection,WithMapping,WithHeadings
{
    use Exportable;
    public function map($teacher): array
    {
        $subjectIds=json_decode($teacher->subject_id);
        $subjects= "";
        foreach ($subjectIds as $subjectId){
            $subject= Subject::where('id', $subjectId)->first();
            $subjects.= $subject->name.',';
        }

        $gender=$teacher->gender;
        if ($gender==1){
            $gender='Male';
        }else{
            $gender="Female";
        }
        return [
            $teacher->name,
            $teacher->reg_no,
            $teacher->email,
            $teacher->id_number,
            $subjects,
            $gender,
            $teacher->reference,
            $teacher->qualification,
            $teacher->current_address,
            $teacher->permanent_address,
            $teacher->contact_number,
            $teacher->status,
            $teacher->monthly_salary,
            $teacher->note,
        ];
    }
    public function collection()
    {
        return Teacher::with('subjects')->get();
    }
    public function headings(): array
    {
        return [
            'name',
            'reg_no',
            'email',
            'id_number',
            'subject',
            'gender',
            'reference',
            'qualification',
            'current_address',
            'permanent_address',
            'contact_number',
            'status',
            'monthly_salary',
            'note',
        ];
    }
}
