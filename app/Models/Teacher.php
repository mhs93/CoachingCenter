<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['subject_id','name','reg_no','email','gender','monthly_salary'];

    public function subjects()
    {
//        return $this->hasMany(Subject::class, 'subject_id', 'id')->withTrashed();
        return $this->hasMany(Subject::class, 'id', 'subject_id')->withTrashed();
    }

}
