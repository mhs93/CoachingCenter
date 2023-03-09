<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Batch extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = ['name','status','subject_id','note','start_date','end_date','total_amount'];
    
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'id' )->withTrashed();
    }

    public function students()
    {
        return $this->hasMany(Student::class)->withTrashed();
    }
}
