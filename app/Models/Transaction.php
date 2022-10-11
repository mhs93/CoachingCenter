<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @return mixed
     */
    public function account(){
        return $this->belongsTo(Account::class,'account_id','id')->select('id', 'account_no','account_holder')->withTrashed();
    }
}
