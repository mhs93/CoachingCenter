<?php

namespace App\Exports;

use App\Models\Batch;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportStudent implements FromCollection,WithMapping,WithHeadings
{
    use Exportable;

    public function map($student): array
    {
        $batchId=Batch::where('id',$student->batch_id)->first();
        $gender=$student->gender;
        if ($gender==1){
            $gender='Male';
        }else{
            $gender="Female";
        }
        return [
            $student->name,
            $student->reg_no,
            $student->email,
            $batchId->name,
            $gender,
            $student->current_address,
            $student->permanent_address,
            $student->contact_number,
            $student->parent_information,
            $student->parent_contact,
            $student->guardian_information,
            $student->guardian_contact,
            $student->status,
            $student->adjustment_type,
            $student->initial_amount,
            $student->adjustment_balance,
            $student->adjustment_cause,
            $student->total_amount,
            $student->monthly_fee,
            $student->note,
        ];
    }

    public function collection()
    {
        return Student::with('batch')->get();
    }
    public function headings(): array
    {
        return[
            'name',
            'reg_no',
            'email',
            'batch',
            'gender',
            'current_address',
            'permanent_address',
            'contact_number',
            'parent_information',
            'parent_contact',
            'guardian_information',
            'guardian_contact',
            'status',
            'adjustment_type',
            'initial_amount',
            'adjustment_balance',
            'adjustment_cause',
            'total_amount',
            'monthly_fee',
            'note',
        ];
    }
}
