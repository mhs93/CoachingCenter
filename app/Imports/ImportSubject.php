<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSubject implements ToModel, WithHeadingRow{
    public function model(array $row)
    {
        return new Subject([
            'name' => $row['name'],
            'code' => $row['code'],
            'note' => $row['note'],
            'fee' => $row['fee'],
            'status' => $row['status'],
        ]);
    }
}
