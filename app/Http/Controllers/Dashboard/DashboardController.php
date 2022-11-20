<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Batch;
use App\Models\Income;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __invoke(Request $request)
    {
        $totalStudent   =    count(Student::all());
        $totalTeacher   =    count(Teacher::get());
        $totalSubject   =    count(Subject::get());
        $totalBatch     =    count(Batch::get());

        $incomes = Transaction::where('transaction_type', 1)
                                ->orWhere('transaction_type', 3)
                                ->sum('amount');
        // $total_income = 0;
        // foreach($incomes as $income){
        //     $total_income += $income->amount;
        // }
        $total_income = $incomes;

        $expenses = Transaction::where('transaction_type', '2')->get();
        $total_enpense = 0;
        foreach($expenses as $expense){
            $total_enpense += $expense->amount;
        }

        $total_profit  = $total_income - $total_enpense;


        $user = User::findOrFail(Auth::id());
        // User->type = 0 means Admin
        if($user->type == '0'){
            return view('dashboard.admin_dashboard',
                compact('totalStudent', 'totalTeacher', 'totalSubject', 'totalBatch',
                'total_income', 'total_enpense', 'total_profit') );
        }
        // User->type = 0 means Accountant
        else if($user->type == '3'){
            return view('dashboard.accountant_dashboard',
                compact('totalStudent', 'totalTeacher', 'totalSubject', 'totalBatch',
                'total_income', 'total_enpense', 'total_profit') );
        }
        else{
            // User->type = 1 means Teacher
            if($user->type == '1'){
                return view('dashboard.teacher_dashboard',
                    compact('totalStudent', 'totalTeacher', 'totalSubject', 'totalBatch'));
            }
            //User->type = 2 means Student
            else{
                return view('dashboard.student_dashboard',
                    compact('totalStudent', 'totalTeacher', 'totalSubject', 'totalBatch'));
            }
        }


    }
}
