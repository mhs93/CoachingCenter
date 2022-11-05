<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Batch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory, SoftDeletes;

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function batch(){
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
