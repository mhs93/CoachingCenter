<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __invoke(Request $request)
    {
        $totalStudent = count(Student::all());
        $totalTeacher = count(Teacher::get());
        $totalSubject = count(Subject::get());
        $totalBatch = count(Batch::get());

        $user = User::findOrFail(Auth::id());
        // User->type = 0 means Admin
        if($user->type == '0'){
            return view('dashboard.admin_dashboard', compact('totalStudent', 'totalTeacher', 'totalSubject', 'totalBatch'));
        }else{
            // User->type = 0 means Admin
            if($user->type == '1'){
                return view('dashboard.teacher_dashboard', compact('totalStudent', 'totalTeacher', 'totalSubject', 'totalBatch'));
            }
            //User->type = 0 means Admin
            else{
                return view('dashboard.student_dashboard', compact('totalStudent', 'totalTeacher', 'totalSubject', 'totalBatch'));
            }
        }


    }
}
