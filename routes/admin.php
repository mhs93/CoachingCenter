<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Bank\BankController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Expense\ExpenseController;
// Start
use App\Http\Controllers\Payment\PaymentController;
// End
use App\Http\Controllers\Routine\RoutineController;
use App\Http\Controllers\Setting\SettingController;

use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\SMS\SmsController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Resource\ResourceController;
use App\Http\Controllers\Administration\RoleController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\TchPayment\TchpaymentController;

use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\BalanceSheetController;
use App\Http\Controllers\StudentPayment\StdpaymentController;
use App\Http\Controllers\TeacherAttendance\TattendanceContoller;

Auth::routes();
Route::get('/', DashboardController::class)->name('dashboard');


// Administration
Route::get('roles/lists', [RoleController::class, 'getList'])->name('roles.list');
Route::resource('roles', RoleController::class);

// Subject Routes
Route::put('subjects/change-status/{subject}', [SubjectController::class, 'changeStatus'])->name('subjects.change-status');
Route::get('subjects/lists', [SubjectController::class, 'getList'])->name('subjects.list');
Route::resource('/test', 'TestController')->except(['create', 'show']);
// Route::post('subeject/update/{id}', [SubjectController::class, 'update'])->name('update');
Route::resource('subjects', SubjectController::class);
Route::get('class/subjects/print',[SubjectController::class,'print'])->name('subjects.print');
Route::get('class/subjects/pdf',[SubjectController::class,'pdf'])->name('subjects.pdf');
// Route::get('class/routine/print',[RoutineController::class,'printClassRoutine'])->name('routine.print');
Route::get('/file-import',[SubjectController::class,'importView'])->name('import-view');
Route::post('/import-subjects',[SubjectController::class,'importSubjects'])->name('import-subjects');
Route::get('/export-subjects',[SubjectController::class,'exportSubjects'])->name('export-subjects');



// Batch Routes
Route::get('batches/get/subject/fee',[BatchController::class,'getSubjectFee'])->name('batch.getSubjectFee');
Route::get('batches/get/all/subjects',[BatchController::class,'getAllSubject'])->name('batch.getAllSubject');
Route::get('batches/create', [BatchController::class, 'create'])->name('batches.create');
Route::get('batches/lists', [BatchController::class, 'getList'])->name('batches.list');
//Route::get('batches/show/{id}', [BatchController::class, 'show'])->name('batches.show');
//Route::get('batches/edit/{id}', [BatchController::class, 'edit'])->name('batches.edit');
Route::post('batches/update', [BatchController::class, 'update'])->name('batches.update');
Route::put('batches/change-status/{batch}', [BatchController::class, 'changeStatus'])->name('batches.change-status');
Route::resource('batches', BatchController::class)->except('create', 'update');
Route::get('class/batches/print',[BatchController::class,'print'])->name('batches.print');
Route::get('class/batches/pdf',[BatchController::class,'pdf'])->name('batches.pdf');

Route::get('/file-import',[BatchController::class,'importView'])->name('import-view');
Route::post('/import-batches',[BatchController::class,'importBatches'])->name('import-batches');
Route::get('/export-batches',[BatchController::class,'exportbatches'])->name('export-batches');


// Student Routes
// Chnage Profile Pic for Studnet
Route::get('students/get/batch/fee',[StudentController::class,'getBatchFee'])->name('student.getBatchFee');
Route::get('students/change/pic', [StudentController::class, 'changePic'])->name('pic');
Route::post('students/change/pic', [StudentController::class, 'changePicSubmit'])->name('pic.submit');
// Change Password for Admin
Route::get('students/change/password/{id}', [StudentController::class, 'password'])->name('students.password');
Route::post('students/change/password', [StudentController::class, 'passwordSubmit'])->name('students.password.submit');
// Chnage Password for Studnet
Route::get('students/password', [StudentController::class, 'studentPassword'])->name('password');
Route::get('student/change/password', [StudentController::class, 'studentPassword'])->name('student..change.password');
//Route::get('students/password/{id}', [StudentController::class, 'studentPassword'])->name('password');
Route::post('students/password', [StudentController::class, 'studentPasswordSubmit'])->name('password.submit');
Route::get('students/marked/exam/{id}', [StudentController::class, 'markedExam'])->name('students.marked.exam'); //Student Exam
// Route::get('students/exam/{id}', [StudentController::class, 'exam'])->name('students.exam'); //Student Exam
// Route::get('students/exam/result/{id}', [StudentController::class, 'examResult'])->name('students.exam.result'); //Student Exam
// Route::get('students/exam/result/{id1}/{id2}', [StudentController::class, 'examResult'])->name('students.exam.result'); //Student Exam
Route::get('students/exam/result/{id1}/{id2}/{id3}', [StudentController::class, 'examResult'])->name('students.exam.result'); //Student Exam
Route::get('get-students', [StudentController::class, 'getList'])->name('students.list');
Route::put('students/change-status/{student}', [StudentController::class, 'changeStatus'])->name('students.change-status');
Route::resource('students', StudentController::class);
Route::get('class/students/print',[StudentController::class,'print'])->name('students.print');
Route::get('class/students/pdf',[StudentController::class,'pdf'])->name('students.pdf');
Route::get('/file-import',[StudentController::class,'importView'])->name('import-view');
Route::post('/import-students',[StudentController::class,'importStudents'])->name('import-students');
Route::get('/export-students',[StudentController::class,'exportStudents'])->name('export-students');
Route::get('/student/registration-info/sms/{id}',[SmsController::class,'StdRegistrationMessage'])->name('student-registration-sms');



// Teacher Routes
// Change Password for Admin
Route::get('admin/change/password/{id}', [TeacherController::class, 'adminPassword'])->name('adteacher.password');
Route::post('admin/change/password', [TeacherController::class, 'adminPasswordSubmit'])->name('adteacher.password.submit');
// Chnage Password for teacher
Route::get('teacher/change/password', [TeacherController::class, 'teacherPassword'])->name('teachers.password');
Route::post('teacher/change/password', [TeacherController::class, 'teacherPasswordSubmit'])->name('teachers.password.submit');
Route::get('teachers/get/all/subjects',[TeacherController::class,'getAllSubject'])->name('teacher.getAllSubject');
Route::get('teachers/lists', [TeacherController::class, 'getList'])->name('teachers.list');
// Route::get('get-teachers', [TeacherController::class, 'getList'])->name('teachers.list');
Route::put('teachers/change-status/{teacher}', [TeacherController::class, 'changeStatus'])->name('teachers.change-status');
Route::get('teacher/installment/sms/{id}',[SmsController::class,'TchPayMessage'])->name('teacher.payment.sms');
Route::get('teacher/registration/sms/{id}',[SmsController::class,'TchRegistrationMessage'])->name('teacher.registration.sms');
Route::resource('teachers', TeacherController::class);
Route::get('class/teachers/print',[TeacherController::class,'print'])->name('teachers.print');
Route::get('class/teachers/pdf',[TeacherController::class,'pdf'])->name('teachers.pdf');
Route::get('/file-import',[TeacherController::class,'importView'])->name('import-view');
Route::post('/import-teachers',[TeacherController::class,'importTeachers'])->name('import-teachers');
Route::get('/export-teachers',[TeacherController::class,'exportTeachers'])->name('export-teachers');

// Announcements Route
Route::get('announcements/get/all/bathces',[AnnouncementController::class,'getAllBatch'])->name('announcements.getAllBatch');
Route::get('announcements/get/all/subjects',[AnnouncementController::class,'getAllSubject'])->name('announcements.getAllSubject');
Route::get('announcements/lists', [AnnouncementController::class, 'getList'])->name('announcements.list');
Route::put('announcements/change-status/{announcement}', [AnnouncementController::class, 'changeStatus'])->name('announcements.change-status');
Route::resource('announcements', AnnouncementController::class);
Route::get('class/announcements/print',[AnnouncementController::class,'print'])->name('announcements.print');
Route::get('class/announcements/pdf',[AnnouncementController::class,'pdf'])->name('announcements.pdf');
Route::get('announcement/sms/{id}',[SmsController::class,'AnnouncementMessage'])->name('announcements.sms');

// Class room routes
Route::get('class-rooms/show/{id}', [ClassRoomController::class, 'show'])->name('classrooms.show');
Route::post('class-rooms/getSubjects', [ClassRoomController::class, 'getSubjects'])->name('classRoomGetSubjects');
Route::get('class-rooms/lists', [ClassRoomController::class, 'getList'])->name('class-rooms.list');
Route::put('class-rooms/change-status/{class_room}', [ClassRoomController::class, 'changeStatus'])->name('class-rooms.change-status');
Route::resource('class-rooms', ClassRoomController::class);
Route::get('class/class-rooms/print',[ClassRoomController::class,'print'])->name('class-rooms.print');
Route::get('class/class-rooms/pdf',[ClassRoomController::class,'pdf'])->name('class-rooms.pdf');



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
Route::get('account-list',[AccountController::class,'getList'])->name('account.list');
//Route::get('account-edit/{id}',[AccountController::class,'edit'])->name('account.edit');
//Route::get('account-update/{id}',[AccountController::class,'update'])->name('account.update');
Route::put('account-change-status/{account}',[AccountController::class,'changeStatus'])->name('account.change-status');
Route::resource('account', AccountController::class);
Route::get('class/account/pdf',[AccountController::class,'pdf'])->name('account.pdf');
Route::get('class/account/print',[AccountController::class,'print'])->name('account.print');

Route::get('transaction/list',[TransactionController::class,'getList'])->name('transaction.list');
Route::resource('transaction',TransactionController::class);
Route::get('account-balance/{id}',[TransactionController::class,'getAccountBalance'])->name('account-balance');

Route::get('balance-sheet',[BalanceSheetController::class,'balanceSheet'])->name('balance-sheet');
Route::get('class/balance-sheet/print',[BalanceSheetController::class,'print'])->name('balance-sheet.print');
Route::get('class/balance-sheet/pdf',[BalanceSheetController::class,'pdf'])->name('balance-sheet.pdf');

//Resource
//Route::get('resources/show/{id}', [ResourceController::class, 'show'])->name('resources.show');
Route::put('resources/change-status/{resource}', [ResourceController::class, 'changeStatus'])->name('resources.change-status');
Route::get('resources/lists', [ResourceController::class, 'getList'])->name('resources.list');
Route::resource('resources', ResourceController::class);
Route::get('class/resources/print',[ResourceController::class,'print'])->name('resources.print');
Route::get('class/resources/pdf',[ResourceController::class,'pdf'])->name('resources.pdf');

// Routine Route Start
Route::get('class/routine/print',[RoutineController::class,'printClassRoutine'])->name('routine.print');
Route::get('class/routine/pdf',[RoutineController::class,'pdfClassRoutine'])->name('routine.pdf');
Route::get('getsub',[RoutineController::class,'getSubject'])->name('routine.getsub');
Route::get('routine.lists',[RoutineController::class,'getlist'])->name('routine.list');
//Route::get('routine/edit/{id}',[RoutineController::class,'edit'])->name('routine.edit');
Route::post('routine-update{id}',[RoutineController::class,'update'])->name('routine.update');
Route::put('routines/change-status/{routine}', [RoutineController::class, 'changeStatus'])->name('routine.change-status');
Route::resource('routine',RoutineController::class)->except('update');
// Routine Route End

// Exam Route Start
//Route::get('exams/show/{id}', [ExamController::class, 'show'])->name('exams.show');
//Route::get('exams/edit/{id}', [ExamController::class, 'edit'])->name('exams.edit');
//Route::post('exams/update', [ExamController::class, 'update'])->name('exams.update');
Route::post('/getSub', [ExamController::class, 'getSubject'])->name('exams.getSub');
Route::put('exams/change-status/{exam}', [ExamController::class, 'changeStatus'])->name('exams.change-status');
Route::get('exams/lists', [ExamController::class, 'getList'])->name('exams.lists');
Route::resource('exams', ExamController::class);
Route::get('class/exams/pdf',[ExamController::class,'pdf'])->name('exams.pdf');
Route::get('class/exams/print',[ExamController::class,'print'])->name('exams.print');
// Exam Route End


// Mark Route Start
//edit
Route::post('marks/getMarkedBatches', [MarkController::class, 'getMarkedBatches'])->name('marks.getMarkedBatches');
Route::get('mark/edit/{id1}/{id2}', [MarkController::class, 'edit'])->name('mark.edit');
Route::post('mark/edit/submit', [MarkController::class, 'update'])->name('mark.update');
//end edit

//Delete
Route::get('mark/delete/{id1}/{id2}', [MarkController::class, 'delete'])->name('mark.delete');
//end Delete

//SMS
// Route::get('mark/sms/{id1}/{id2}', [MarkController::class, 'markSms'])->name('mark.sms');
Route::get('mark/sms/{id1}/{id2}',[SmsController::class,'markSms'])->name('mark.sms');
//End SMS


Route::post('marks/getBatches', [MarkController::class, 'getBatches'])->name('marks.getBatches');
Route::post('marks/getSubjects', [MarkController::class, 'getSubjects'])->name('marks.getSubjects');

Route::post('marks/get-Results', [MarkController::class, 'getResults'])->name('result.get-Results');
Route::get('result/result-show-by-exam', [MarkController::class, 'resulShowByExam'])->name('result-show-by-exam');


// Result show without the exam id
Route::get('marks/result-show-by-batch/{id}', [MarkController::class, 'resultShowByBatch'])->name('result-show-by-batch');
Route::post('marks/result-show-by-batch-render', [MarkController::class, 'resultShowByBatchRender'])->name('result.result-show-by-batch-render');

// PDF Route
Route::get('result/marks/pdf-generate-for-mark/{id1}/{id2}', [MarkController::class, 'pdfGenerateForMark'])->name('result.pdf-generate-for-mark');
Route::get('result/marks/print-result/{id1}/{id2}', [MarkController::class, 'printResult'])->name('result.print-result');

Route::put('marks/change-status/{mark}', [MarkController::class, 'changeStatus'])->name('marks.change-status');
Route::get('marks/lists', [MarkController::class, 'getList'])->name('marks.lists');
Route::resource('marks', MarkController::class)->except('edit', 'update');
// Mark Route End



// Attendance Route Start
Route::post('/students-by-batch', [AttendanceController::class, 'studentsByBatch'])
    ->name('students.by.batch');
//Route::post('/get-attendance',[AttendanceController::class,'getAttendance'])->name('');
Route::get('attendance-report', [AttendanceController::class, 'report'])->name('attendances.report');
Route::post('get-student-by-batch', [AttendanceController::class, 'getStudentByBatch'])->name('get-student-by-batch');
Route::post('attendance-report-list', [AttendanceController::class, 'reportList'])->name('attendance.report.list');
Route::resource('attendances', AttendanceController::class)->except('create');
Route::post('attendances-update', [AttendanceController::class, 'update'])->name('attendances.update');
// Attendance Route End

// Teaccher Attendance Route Start
Route::post('tattendances-update', [TattendanceContoller::class, 'update'])->name('tattendances.update');
Route::post('/teachers-by-name', [TattendanceContoller::class, 'teachersByName'])
        ->name('teachers.by.name');
Route::get('teacher-attendance-report', [TattendanceContoller::class, 'report'])->name('teachers.attendances.report');
Route::post('teacher-attendance-report-list', [TattendanceContoller::class, 'reportList'])->name('teachers.attendance.report.list');
Route::post('get-teacher-by-month', [TattendanceContoller::class, 'getTeacherByMonth'])->name('get-teacher-by-month');
Route::resource('tattendances', TattendanceContoller::class)->except('update');
// Teaccher Attendance Route End

// Start
Route::get('setting/general', [SettingController::class, 'general'])->name('setting.general');
Route::post('setting/general', [SettingController::class, 'generalUpdate'])->name('generalUpdate');

// End
Route::post('/getSubjects', [ResourceController::class, 'getSubjects'])->name('getSubjects');

//student payment
Route::get('student-payment-index/{id}',[StdpaymentController::class,'index'])->name('student.payment');
Route::get('student-payment/create/{id}',[StdpaymentController::class,'create'])->name('student.payment.create');
Route::get('student-payment/edit/{id}',[StdpaymentController::class,'edit'])->name('student.payment.edit');
Route::post('payment.student.update/{id}',[StdpaymentController::class,'update'])->name('student.payment.update');
Route::get('payment.student.stdprint/{id}',[StdpaymentController::class,'stdprint'])->name('student.payment.stdprint');
Route::get('payment.student.delete/{id}',[StdpaymentController::class,'delete'])->name('student.payment.delete');
Route::get('payment.student.show/{id}',[StdpaymentController::class,'show'])->name('student.payment.show');
Route::get('payment.student.installments',[StdpaymentController::class,'installments'])->name('student.payment.installments');
Route::get('student/installment/sms/{id}',[SmsController::class,'StdPayMessage'])->name('student.payment.sms');
Route::resource('std-payment',StdpaymentController::class);

//Teacher Payment
Route::get('teacher-payment-index/{id}',[TchpaymentController::class,'index'])->name('teacher.payment');
Route::get('teacher-payment/create/{id}',[TchpaymentController::class,'create'])->name('teacher.payment.create');
Route::get('teacher-payment/edit/{id}',[TchpaymentController::class,'edit'])->name('teacher.payment.edit');
Route::post('payment.teacher.update/{id}',[TchpaymentController::class,'update'])->name('teacher.payment.update');
Route::get('payment.teacher.tchprint/{id}',[TchpaymentController::class,'tchprint'])->name('teacher.payment.tchprint');
Route::get('payment.teacher.delete/{id}',[TchpaymentController::class,'delete'])->name('teacher.payment.delete');
Route::get('payment.teacher.show/{id}',[TchpaymentController::class,'show'])->name('teacher.payment.show');
Route::get('payment.teacher.installments',[TchpaymentController::class,'installments'])->name('teacher.payment.installments');
Route::get('teacher/installment/sms/{id}',[SmsController::class,'TchPayMessage'])->name('teacher.payment.sms');
Route::resource('tch-payment',TchpaymentController::class);

//reports
//students report by active/inactive
Route::get('active-inactive-students',[ReportController::class, 'ActiveInactiveStudent'])->name('active-inactive-students');
Route::get('all-active-inactive-students',[ReportController::class, 'ActiveInactiveStudentList'])->name('all-active-inactive-students');

Route::get('get-batch-wise-student',[ReportController::class, 'getBatchWiseStudent'])->name('get-batch-wise-student');

Route::get('get-batch-wise-subject', [ReportController::class, 'getBatchWiseSubject'])->name('get-batch-wise-sub');

Route::get('students-attendance',[ReportController::class, 'StudentAttendance'])->name('students-attendance');
Route::get('students-attendance-list',[ReportController::class, 'StudentAttendanceList'])->name('students-attendance-list');

//students report by subjects
Route::get('subject-wise-attendance',[ReportController::class, 'SubjectWiseAttendance'])->name('subject-wise-attendance');
Route::get('subject-wise-attendance-list',[ReportController::class, 'SubjectWiseAttendanceList'])->name('subject-wise-attendance-list');

//batch active inactive
Route::get('batch-wise-students',[ReportController::class, 'BatchWiseStudent'])->name('batch-wise-students');
Route::get('batch-wise-student-list',[ReportController::class, 'BatchWiseStudentList'])->name('batch-wise-student-list');

Route::get('batch-wise-attendance',[ReportController::class, 'BatchWiseAttendance'])->name('batch-wise-attendance');
Route::get('batch-wise-attendance-list',[ReportController::class, 'BatchWiseAttendanceList'])->name('batch-wise-attendance-list');

//teacher report by active/inactive
Route::get('active-inactive-teachers',[ReportController::class, 'ActiveInactiveTeacher'])->name('active-inactive-teachers');
Route::get('all-active-inactive-teachers',[ReportController::class, 'ActiveInactiveTeacherList'])->name('all-active-inactive-teachers');

Route::get('teachers-attendance', [ReportController::class, 'TeacherAttendance'])->name('teachers-attendance');
Route::get('teachers-attendance-list', [ReportController::class, 'TeacherAttendanceList'])->name('teachers-attendance-list');

//Income
Route::get('income-list',[IncomeController::class,'getlist'])->name('income.list');
//Route::get('income-edit/{id}',[IncomeController::class,'edit'])->name('income.edit');
//Route::post('income-update/{id}',[IncomeController::class,'update'])->name('income.update');
Route::get('income-print/{id}',[IncomeController::class,'print'])->name('income.print');
Route::resource('income',IncomeController::class);
Route::get('class/income/pdf',[IncomeController::class,'pdf'])->name('income.pdf');
Route::get('class/income/all-print',[IncomeController::class,'allPrint'])->name('income.all-print');

//Expense
Route::get('expense-list',[ExpenseController::class,'getlist'])->name('expense.list');
//Route::get('expense-edit/{id}',[ExpenseController::class,'edit'])->name('expense.edit');
//Route::post('expense-update/{id}',[ExpenseController::class,'update'])->name('expense.update');
Route::get('expense-print/{id}',[ExpenseController::class,'print'])->name('expense.print');
Route::resource('expense',ExpenseController::class);
Route::get('class/expense/pdf',[ExpenseController::class,'pdf'])->name('expense.pdf');
Route::get('class/expense/all-print',[ExpenseController::class,'allPrint'])->name('expense.all-print');

//accounts statement
Route::get('accounts-statement', [TransactionController::class, 'AccountStatement'])->name('accounts-statement');
Route::get('accounts-statement-list', [TransactionController::class, 'AccountStatementList'])->name('accounts-statement-list');

//students transaction
Route::get('students-transaction', [TransactionController::class, 'StudentsTransaction'])->name('students-transaction');
Route::get('students-transaction-list', [TransactionController::class, 'StudentsTransactionList'])->name('students-transaction-list');

//teachers transactions
Route::get('teachers-transaction', [TransactionController::class, 'TeachersTransaction'])->name('teachers-transaction');
Route::get('teachers-transaction-list', [TransactionController::class, 'TeachersTransactionList'])->name('teachers-transaction-list');

Route::get('class/transaction/pdf',[TransactionController::class,'pdf'])->name('transaction.pdf');
Route::get('class/transaction/print',[TransactionController::class,'print'])->name('transaction.print');

//students mark report
Route::get('students-mark', [MarkController::class, 'StudentMark'])->name('students-mark');
Route::get('students-mark-list', [MarkController::class, 'StudentMarkList'])->name('students-mark-list');


Route::get('generate-pdf', [MarkController::class, 'generatePDF'])->name('pdf');
