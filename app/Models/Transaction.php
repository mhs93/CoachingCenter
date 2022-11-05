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
    public function stpayment(){
        return $this->belongsTo(Stdpayment::class,'stdpayment_id','id')->withTrashed();
    }
    public function tchpayment(){
        return $this->belongsTo(Tchpayment::class,'tchpayment_id','id')->withTrashed();
    }
    public function income(){
        return $this->belongsTo(Income::class,'income_id','id')-self::withTrashed();
    }
}
