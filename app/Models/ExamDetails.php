<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examdetails extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'exam_details';

    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function batch(){
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // public function exams(){
    //     return $this->hasMany(Exam::class, 'exam_id');
    // }

}
