<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,SoftDeletes;

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'id')->withTrashed();
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }
}
