<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory,SoftDeletes;

    public function account(){
        return $this->belongsTo(Account::class,'account_id','id')->withTrashed();
    }
}
