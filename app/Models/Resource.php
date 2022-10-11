<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model
{
    use HasFactory, SoftDeletes;

    public function batches()
    {
        return $this->hasMany(Batch::class, 'batch_id', 'id')->withTrashed();
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'subject_id', 'id');
    }
}
