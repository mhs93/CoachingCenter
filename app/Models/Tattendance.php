<?php

namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tattendance extends Model
{
    use HasFactory, SoftDeletes;
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id')->withTrashed();
    }
}

