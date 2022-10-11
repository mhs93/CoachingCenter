<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory ,SoftDeletes;
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'subject_id', 'id')->withTrashed();
    }
}
