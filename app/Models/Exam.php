<?php

namespace App\Models;

use App\Models\Examdetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory ,SoftDeletes;
    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at'
    ];
     public function examDetails(){
         return $this->hasMany(\App\Models\Examdetails::class, 'exam_id');
     }
}
