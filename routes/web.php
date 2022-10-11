<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BatchController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendenceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});