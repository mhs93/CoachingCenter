<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory, SoftDeletes;

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'id')->withTrashed();
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id')->withTrashed();
    }
}
