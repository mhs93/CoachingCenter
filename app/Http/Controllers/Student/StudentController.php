<?php

namespace App\Http\Controllers\Student;

use App\Exports\ExportStudent;
use App\Imports\ImportStudent;
use PDF; 
use App\Models\Exam;
use App\Models\Mark;
use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
use App\Models\ExamDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Maatwebsite\Excel\Facades\Excel;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:student_modify')->except(['index','getList','show','studentPassword','passwordSubmit','studentPasswordSubmit']);
    }

    public function getList()
    {
        try {
            $user = User::findOrFail(Auth::id());

            if($user->type == '0' || $user->type == '3'){
                $data = Student::with(['batch' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->select('id', 'name', 'reg_no', 'email', 'batch_id', 'status')
                ->orderBy('id', 'DESC')
                ->get();
            }

            else{
                if($user->type == '1'){
                    $data = Student::with(['batch' => function ($query) {
                        $query->select('id', 'name');
                    }])
                    ->select('id', 'name', 'reg_no', 'email', 'batch_id', 'status')
                    ->orderBy('id', 'DESC')
                    ->get();
                }
                else{
                    $student = Student::where('id', $user->student_id)->first();
                    $data = Student::with(['batch' => function ($query) {
                            $query->select('id', 'name');
                        }])
                        ->select('id', 'name', 'reg_no', 'email', 'batch_id', 'status')
                        ->orderBy('id', 'DESC')
                        ->where('batch_id', $student->batch_id)
                        ->get();
                }
            }
            return DataTables::of($data)->addIndexColumn()
                //status
                ->addColumn('status', function ($data) {
                    if (Auth::user()->can('student_modify')) {
                        $button = ' <div class="form-check form-switch">';
                        $button .= ' <input onclick="statusConfirm(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                        return $button;
                    } else {
                        if ($data->status == 1) {
                            return '<div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" onclick="return false;"  checked />
                                </div>';
                        } else {
                            return '<div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" readonly />
                                </div>';
                        }
                    }
                })
                //Action
                ->addColumn('action', function ($data) {
                    if (Auth::user()->can('student_list')) {
                        // $profileShow = '<a href="javascript:void(0)" onclick="show(' . $data->id . ')" class="btn btn-sm btn-info text-white" title="Show"><i class="bx bxs-low-vision"></i></a>';
                        $profileShow = '<a href="' . route('admin.students.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class=\'bx bxs-low-vision\'></i></a>';
                    } else {
                        $profileShow = '';
                    }

                    if (Auth::user()->can('student_modify')) {
                        $profileEdit = '<a href="' . route('admin.students.edit', $data->id) . '" class="btn btn-sm btn-warning" title="edit"><i class=\'bx bxs-edit-alt\'></i></a>';
                    } else {
                        $profileEdit = '';
                    }

                    if (Auth::user()->can('student_modify')) {
                        $profileDelete = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    } else {
                        $profileDelete = '';
                    }

                    // Change Password
                    if (Auth::user()->can('student_modify')) {
                        $changePassword = '<a href="' . route('admin.students.password', $data->id) . '" class="btn btn-sm btn-info" title="change password"><i class="bx bxs-key"></i></a>';
                    } else {
                        $changePassword = '';
                    }

                    if (Auth::user()->can('student_payment')) {
                        $payment = '<a href="' . route('admin.student.payment', $data->id) . '" class="btn btn-sm btn-success" title="payment"><i class="bx bx-dollar-circle"></i></a>';
                    } else {
                        $payment = '';
                    }

//                    if (Auth::user()->can('student_list')) {
//                        $exam = '<a href="' . route('admin.students.marked.exam', $data->id) . '" class="btn btn-sm btn-primary" title="exam result"><i class="bx bx-receipt"></i></a>';
//                    } else {
//                        $exam = '';
//                    }
                    if (Auth::user()->can('student_modify')) {
                        $sms = '<a href="' . route('admin.student-registration-sms', $data->id) . '" class="btn btn-sm btn-warning" title="SMS"><i class="bx bxs-chat"></i></a>';
                    } else {
                        $sms = '';
                    }
                    return '<div class = "btn-group">'. $profileShow . $profileEdit . $profileDelete . $changePassword . $payment .$sms.'</div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        try {
            return view('dashboard.students.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // exam
    public function markedExam($id){
        $student = Student::where('id', $id)->first();
        $examDetails = ExamDetails::where('batch_id', $student->batch_id)
                    ->groupBy('exam_id')
                    ->get();
        $exams = [];
        foreach($examDetails as $examDetail){
            $data= Exam::select('id', 'name', 'start_date', 'end_date', 'status')
                ->orderBy('id', 'DESC')
                ->where('id',  $examDetail->exam_id)
                ->where('status', '1')
                ->where('mark_status', '1')
                ->first();
            if($data != null){
                array_push($exams, $data);
            }
        }
        return view('dashboard.students.exam', compact('exams', 'student'));
    }

    public function examResult($id1, $id2, $id3){
        // id1 = exam_id, id2 = batch_id, id3 = student_id
        $exam    =  Exam::findOrFail($id1);
        $batch   =  Batch::findOrFail($id2);
        $student =  Student::findOrFail($id3);
        $marks   =  Mark::where('exam_id', $id1)
                    ->where('batch_id', $id2)
                    ->where('student_id', $id3)
                    // ->orderByRaw('CONVERT(total, SIGNED) desc')
                    ->get();
        return view('dashboard.students.exam-result',compact('marks', 'exam', 'batch', 'student'));
    }

    // Change Password for Admin
    public function password($id){
        $student = Student::findOrFail($id);
        return view('dashboard.students.changepassword', compact('student'));
    }

    public function passwordSubmit(Request $req){
        $this->validate($req,
        [
            'password'=>'required|confirmed',
        ]);

        $user = User::where('student_id', $req->id)->first();
        $user->password = Hash::make($req->password);
        if($user->save()){
            return redirect()->route('admin.students.index')
                ->with('t-success', 'Password Updated Successfully');
        }else{
            return redirect()->route('admin.students.password', $req->id)->with('t-success', 'Current password does not match your old password...Please try again...');
        }
    }


    // Change Password for Student
    public function studentPassword(){
        return view('dashboard.students.stuchangepassword');
    }

    public function studentPasswordSubmit(Request $request){
        $this->validate($request,
        [
            'currentPassword' => 'required',
            'password' => 'required|confirmed'
        ]);
        try {
            $user = User::find(Auth::user()->id);
            $hashedPassword = Auth::user()->password;
            if (Hash::check($request->currentPassword, $hashedPassword)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->update();
//                return redirect()->route('admin.students.index')->with('t-success', 'Password Updated Successfully');
                return redirect()->route('admin.user.profile')->with('t-success', 'Password Updated Successfully');
            } else {
                return redirect()->route('admin.password')->with('t-error', 'Current password does not match your old password...Please try again...');
            }
        }catch (\Exception $exception){
            return $this->sendError('Password change error', ['error' => $exception->getMessage()]);
        }
    }


    public function create()
    {
        try {
            $batches   = Batch::where('status', 1)->select('id', 'name')->get();
            $latestReg = Student::latest()->first()->reg_no ?? "STD_1000";
            $expReg    = explode("_", $latestReg);
            if (!$latestReg) {
                $latestReg = 'STD_' . 10001;
            }else {
                $sum       = $expReg[1] + 1;
                $latestReg = 'STD_' . $sum;
            }
            return view('dashboard.students.create', compact('batches', 'latestReg'));
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store student data into database
     *
     * @param  mixed $request
     * @return void
     */

    public function store(StoreStudentRequest $request){
        if($request->adjustment_type){
            $this->validate($request, [
                'adjustment_type'    => 'required|string|unique:batches,name,NULL,id,deleted_at,NULL',
                "adjustment_balance" => "required",
                "total_amount"       => "required",
                "adjustment_cause"   => "required",
            ]);
        }

        DB::beginTransaction();
        try {
            $student                       = new Student();
            $student->name                 = $request->name;
            $student->reg_no               = $request->reg_no;
            $student->email                = $request->email;
            $student->batch_id             = $request->batch_id;
            $student->gender               = $request->gender;
            $student->current_address      = $request->current_address;
            $student->permanent_address    = $request->permanent_address;
            $student->contact_number       = $request->contact_number;
            $student->parent_information   = $request->parent_information;
            $student->parent_contact       = $request->parent_contact;
            $student->guardian_information = $request->guardian_information;
            $student->guardian_contact     = $request->guardian_contact;
            $student->initial_amount       = $request->initial_amount;
            $student->adjustment_balance   = $request->adjustment_balance;
            $student->adjustment_type      = $request->adjustment_type;
            $student->adjustment_cause     = $request->adjustment_cause;
            $student->total_amount         = $request->total_amount;
            $student->monthly_fee          = $request->monthly_fee;
            $student->note                 = $request->note;

            if ($request->has('profile')) {
                $imageUploade = $request->file('profile');
                $imageName    = time() . '.' . $imageUploade->getClientOriginalExtension();
                $imagePath    = public_path('images/users/');
                $imageUploade->move($imagePath, $imageName);
                $student->profile   =   $imageName;
            } else {
                $student->profile = 'user_image.jpg';
            }
            $student->created_by = Auth::id();
            $student->save();

            $user             = new User();
            $user->student_id = $student->id;
            $user->name       = $request->first_name . ' ' . $request->last_name;
            $user->password   = Hash::make("student");
            $user->email      = $request->email;
            $user->type       = 2;
            $user->save();

            // assign new role to the user
            $user->syncRoles(3);

            DB::commit();
            return redirect()->route('admin.students.index')
                ->with('t-success', 'New Student Added Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show student details
     *
     * @param  mixed $id
     * @return void
     */

    public function show($id)
    {
        try {
            // $student = Student::where('id', $id);
            // $balance = $student->adjustment_balance;
            // $array = [
            //     'student'=>$student,
            //     'balance'=>$balance
            // ];
            // return response()->json([
            //     'success' => true,
            //     'data' => $array,
            // ]);
            $student = Student::where('id', $id)
                        ->with('batch')
                        ->first();
            $balance = $student->adjustment_balance;
            return view('dashboard.students.show', compact('student', 'balance'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $student = Student::findOrFail($id);
            $batches = Batch::select('id', 'name')->get();
            $balance = $student->adjustment_balance;
            return view('dashboard.students.edit', compact('student', 'batches', 'balance'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        DB::beginTransaction();
        try {
            $user = User::where('student_id', $student->id)->first();

            if ($request->has('profile')) {
                $imagePath = public_path('images/users/');
                $old_image = $imagePath . $student->profile;
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
                $imageUpdate = $request->file('profile');
                $imageName = time() . '.' . $imageUpdate->getClientOriginalExtension();
                $imageUpdate->move($imagePath, $imageName);
                $student->profile = $imageName;
            } else {
                $imageName = 'user_image.jpg';
            }

            $student->name                 =   $request->name;
            $student->reg_no               =   $request->reg_no;
            $student->email                =   $request->email;
            $student->batch_id             =   $request->batch_id;
            $student->gender               =   $request->gender;
            $student->current_address      =   $request->current_address;
            $student->permanent_address    =   $request->permanent_address;
            $student->contact_number       =   $request->contact_number;
            $student->parent_contact       =   $request->parent_contact;
            $student->parent_information   =   $request->parent_information;
            $student->parent_contact       =   $request->parent_contact;
            $student->guardian_information =   $request->guardian_information;
            $student->guardian_contact     =   $request->guardian_contact;

            $student->initial_amount       =   $request->initial_amount;
            $student->adjustment_balance   =   $request->adjustment_balance;
            $student->adjustment_type      =   $request->adjustment_type;
            $student->adjustment_cause     =   $request->adjustment_cause;
            $student->total_amount         =   $request->total_amount;
            $student->monthly_fee          =   $request->monthly_fee;

            $student->updated_by           =   Auth::id();
            $student->update();

            $user->name = $request->name;
            $user->email = $request->email;
            // if ($request->password) {
            //     $user->password = Hash::make($request->password);
            // }
            $user->type = 2;
            $user->update();

            // assign new role to the user
            $user->syncRoles(3);

            DB::commit();
            return redirect()->route('admin.students.index')
                ->with('t-success', 'Student Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        try {
            $user = User::where('student_id', $student->id);
            $student = Student::findOrFail($student->id);

            // Image permanently delete from store
            $imagePath = public_path('images/users/');
            $old_image = $imagePath . $student->profile;
            if (file_exists($old_image)) {
                unlink($old_image);
            }
            $user->delete();
            $student->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    //status
    public function changeStatus(Student $student)
    {
        try {
            if ($student->status == 1) {
                $student->status = 0;
                $student->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Student inactivated successfully',
                ]);
            }

            $student->status = 1;
            $student->update();

            return response()->json([
                'success' => true,
                'message' => 'Student activated successfully',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getBatchFee(Request $request){
        if($request->batchId){
            $subjects = Batch::where('id', $request->batchId)->first();
            return [
                'status' => true,
                'data' => $subjects
            ];
        }
        else{
            return [
                'status' => false,
            ];
        }
    }

    public function print(){
        $students = Student::get();
        // dd($batches);
        return view('dashboard.students.print', compact('students') );
    }

    public function pdf(){
        $students = Student::get();
        $pdf = PDF::loadView('dashboard.students.pdf', compact('students') );
        return $pdf->download('studenthList.pdf');
    }
    public function importView(Request $request){
        return view('dashboard.students.index');
    }

    public function importStudents(Request $request){
        Excel::import(new ImportStudent, request()->file('file'));
        return redirect()->back()->with('message','Students imported successfully');
    }

    public function exportStudents()
    {
        return Excel::download(new ExportStudent, 'students.xlsx');
    }
}
