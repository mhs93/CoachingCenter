<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\FrontEnd\FrontEndController;

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

Route::get('/',[FrontEndController::class,'index']);
Route::post('contact/store',[FrontEndController::class,'contactStore'])->name('contact.store');
Route::get('contact/messages',[FrontEndController::class,'messages'])->name('contact.messages');
Route::get('messages/lists',[FrontEndController::class,'getList'])->name('contact.messages.list');
Route::delete('messages/delete/{id}',[FrontEndController::class,'messageDelete'])->name('contact.messages.delete');
//Route::get('/', function () {
//    return view('welcome');
//});

// Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
// Route::get('/admin', [DashboardController::class, 'index2'])->name('dashboard2');
