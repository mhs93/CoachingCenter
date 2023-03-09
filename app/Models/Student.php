<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['name','reg_no','email','batch_id','gender','current_address','permanent_address',
        'contact_number','parent_information','parent_contact','guardian_information','guardian_contact',
        'status','total_amount','monthly_fee'];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'id')->withTrashed();
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }
}
