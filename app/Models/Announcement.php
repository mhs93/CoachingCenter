<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Batch;

class Announcement extends Model
{
    use HasFactory ,SoftDeletes;

    public function batches()
    {
        return $this->hasMany(Batch::class, 'batch_id', 'id')->withTrashed();
    }
}
