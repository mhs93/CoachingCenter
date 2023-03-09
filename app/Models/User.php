<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;


    public function student()
    {
        return $this->belongsTo(Student::class,'student_id')->withTrashed();
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id')->withTrashed();
    }

    // public function accountant(){
    //     return $this->belongsTo(Accountant::class,'teacher_id')->withTrashed();
    // }

    public function get_roles()
    {
        $roles = [];
        foreach ($this->getRoleNames() as $key => $role) {
            $roles[$key] = $role;
        }
        return $roles;
    }
}
