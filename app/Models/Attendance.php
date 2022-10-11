<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function batch()
    {
        return $this->belongsTo(Batch::class)->withTrashed();
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }
}
