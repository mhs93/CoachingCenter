<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Bank\BankController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ClassroutineController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Resource\ResourceController;
// Start
use App\Http\Controllers\Administration\RoleController;
// End
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Attendance\AttendanceController;

use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\BalanceSheetController;
use App\Http\Controllers\Routine\RoutineController;

Route::get('/', DashboardController::class)->name('dashboard');

// Administration
Route::get('roles/lists', [RoleController::class, 'getList'])->name('roles.list');
Route::resource('roles', RoleController::class);

// Batch Routes
Route::get('batches/create', [BatchController::class, 'create'])->name('batches.create');
Route::get('batches/lists', [BatchController::class, 'getList'])->name('batches.list');
Route::get('batches/show/{id}', [BatchController::class, 'show'])->name('batches.show');
//Route::get('batches/edit/{id}', [BatchController::class, 'edit'])->name('batches.edit');
Route::post('batches/update', [BatchController::class, 'update'])->name('batches.update');
Route::put('batches/change-status/{batch}', [BatchController::class, 'changeStatus'])->name('batches.change-status');
Route::resource('batches', BatchController::class)->except('create', 'update');

// Subject Routes
Route::get('subjects/lists', [SubjectController::class, 'getList'])->name('subjects.list');
Route::get('subjects/show', [SubjectController::class, 'show'])->name('subjects.show');
Route::post('subjects/update', [SubjectController::class, 'update'])->name('subjects.update');
Route::put('subjects/change-status/{subject}', [SubjectController::class, 'changeStatus'])->name('subjects.change-status');
Route::resource('subjects', SubjectController::class);

// Student Routes
// Change Password for Admin
Route::get('students/change/password/{id}', [StudentController::class, 'password'])->name('students.password');
Route::post('students/change/password', [StudentController::class, 'passwordSubmit'])->name('students.password.submit');
// Chnage Password for Studnet
Route::get('students/password', [StudentController::class, 'studentPassword'])->name('password');
Route::post('students/password', [StudentController::class, 'studentPasswordSubmit'])->name('password.submit');
Route::get('get-students', [StudentController::class, 'getList'])->name('students.list');
Route::put('students/change-status/{student}', [StudentController::class, 'changeStatus'])->name('students.change-status');
Route::resource('students', StudentController::class);

// Teacher Routes
// Change Password for Admin
Route::get('admin/change/password/{id}', [TeacherController::class, 'adminPassword'])->name('adteacher.password');
Route::post('admin/change/password', [TeacherController::class, 'adminPasswordSubmit'])->name('adteacher.password.submit');
// Chnage Password for teacher
Route::get('teacher/change/password', [TeacherController::class, 'teacherPassword'])->name('teachers.password');
Route::post('teacher/change/password', [TeacherController::class, 'teacherPasswordSubmit'])->name('teachers.password.submit');
Route::get('teachers/lists', [TeacherController::class, 'getList'])->name('teachers.list');
// Route::get('get-teachers', [TeacherController::class, 'getList'])->name('teachers.list');
Route::put('teachers/change-status/{teacher}', [TeacherController::class, 'changeStatus'])->name('teachers.change-status');
Route::resource('teachers', TeacherController::class);

// Announcements Route
Route::get('announcements/lists', [AnnouncementController::class, 'getList'])->name('announcements.list');
Route::put('announcements/change-status/{announcement}', [AnnouncementController::class, 'changeStatus'])->name('announcements.change-status');
Route::resource('announcements', AnnouncementController::class);

// Class room routes
Route::get('class-rooms/show/{id}', [ClassRoomController::class, 'show'])->name('classrooms.show');
Route::post('class-rooms/getSubjects', [ClassRoomController::class, 'getSubjects'])->name('getSubjects');
Route::get('class-rooms/lists', [ClassRoomController::class, 'getList'])->name('class-rooms.list');
Route::put('class-rooms/change-status/{class_room}', [ClassRoomController::class, 'changeStatus'])->name('class-rooms.change-status');
Route::resource('class-rooms', ClassRoomController::class);

Route::get('profile', [ProfileController::class, 'index'])->name('user.profile');
//Route::get('student-profile/{id}',[ProfileController::class,'studentProfile'])->name('student.profile');
//Route::get('teacher-profile/{id}',[ProfileController::class,'teacherProfile'])->name('teacher.profile');

Route::get('payment-category-list', [PaymentController::class, 'categoryList'])->name('category.list');
Route::get('payment-category-create', [PaymentController::class, 'categoryCreate'])->name('category.create');
Route::post('payment-category-store', [PaymentController::class, 'categoryStore'])->name('category.store');
Route::get('payment-category-edit/{id}', [PaymentController::class, 'catEdit'])->name('category.edit');
Route::put('payment-category-update', [PaymentController::class, 'catUpdate'])->name('category.update');
Route::post('payment-category-delete/{id}', [PaymentController::class, 'catDelete'])->name('category.delete');
Route::resource('payments', PaymentController::class);

Route::resource('bank', BankController::class);
Route::resource('account', AccountController::class);

Route::get('transaction/list',[TransactionController::class,'getList'])->name('transaction.list');
Route::resource('transaction',TransactionController::class);
Route::get('account-balance/{id}',[TransactionController::class,'getAccountBalance'])->name('account-balance');

Route::get('balance-sheet',[BalanceSheetController::class,'balanceSheet'])->name('balance-sheet');

//Resource
Route::get('resources/show/{id}', [ResourceController::class, 'show'])->name('resources.show');
Route::put('resources/change-status/{resource}', [ResourceController::class, 'changeStatus'])->name('resources.change-status');
Route::get('resources/lists', [ResourceController::class, 'getList'])->name('resources.list');
Route::resource('resources', ResourceController::class);


Route::get('getsub',[RoutineController::class,'getSubject'])->name('routine.getsub');
Route::resource('routine',RoutineController::class);


// Exam Controller Start
Route::post('/getSub', [ExamController::class, 'getSubject'])->name('exams.getSub');
Route::put('exams/change-status/{exam}', [ExamController::class, 'changeStatus'])->name('exams.change-status');
Route::get('exams/lists', [ExamController::class, 'getList'])->name('exams.lists');
Route::resource('exams', ExamController::class);
// Exam Controller End

Route::post('/students-by-batch', [AttendanceController::class, 'studentsByBatch'])
        ->name('students.by.batch');

//Route::post('/get-attendance',[AttendanceController::class,'getAttendance'])->name('');
Route::get('attendance-report', [AttendanceController::class, 'report'])->name('attendances.report');
Route::post('get-student-by-batch', [AttendanceController::class, 'getStudentByBatch'])->name('get-student-by-batch');
Route::post('attendance-report-list', [AttendanceController::class, 'reportList'])->name('attendance.report.list');
Route::resource('attendances', AttendanceController::class)->except('create');

Route::post('attendances-update', [AttendanceController::class, 'update'])->name('attendances.update');

// Start
Route::get('setting/general', [SettingController::class, 'general'])->name('setting.general');
Route::put('setting/general', [SettingController::class, 'generalUpdate']);

// End
Route::post('/getState', [ResourceController::class, 'getState'])->name('getState');
