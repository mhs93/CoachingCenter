<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();

        if($user->type == 0){
            $user = Auth::user();
            return view('dashboard.profile.admin',compact('user'));
        }
        elseif ($user->type == 1){
          $user = User::where('id',Auth::user()->id)->with('teacher')->first();
            return view('dashboard.profile.teacher',compact('user'));
        }
        elseif($user->type == 2){
            $user = User::where('id',Auth::user()->id)->with('student')->first();
            return view('dashboard.profile.student',compact('user'));
        }
        elseif($user->type == 3){
            $user = User::where('id',Auth::user()->id)->with('student')->first();
            return view('dashboard.profile.accountant',compact('user'));
        }

    }
}
