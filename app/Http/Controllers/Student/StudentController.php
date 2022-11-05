<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
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


class StudentController extends Controller
{
    /**
     * Get all student lists
     *
     * @return void
     */

    public function getList()
    {
        try {
            $data = Student::with(['batch' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->select('id', 'name', 'reg_no', 'email', 'batch_id', 'status')
                ->orderBy('id', 'DESC')
                ->get();

            return DataTables::of($data)->addIndexColumn()
                //status
                ->addColumn('status', function ($data) {
                    if (Auth::user()->can('student_edit')) {
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
                    if (Auth::user()->can('student_profile')) {
                        $profileShow = '<a href="' . route('admin.students.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class=\'bx bxs-low-vision\'></i></a>';
                    } else {
                        $profileShow = '';
                    }

                    if (Auth::user()->can('student_edit')) {
                        $profileEdit = '<a href="' . route('admin.students.edit', $data->id) . '" class="btn btn-sm btn-warning" title="edit"><i class=\'bx bxs-edit-alt\'></i></a>';
                    } else {
                        $profileEdit = '';
                    }
                    if (Auth::user()->can('student_delete')) {
                        $profileDelete = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    } else {
                        $profileDelete = '';
                    }
                    // Change Password
                    if (Auth::user()->can('student_password')) {
                        $changePassword = '<a href="' . route('admin.students.password', $data->id) . '" class="btn btn-sm btn-info" title="change password"><i class="bx bxs-key"></i></a>';
                    } else {
                        $changePassword = '';
                    }

                    if (Auth::user()->can('student_payment')) {
                        $payment = '<a href="' . route('admin.student.payment', $data->id) . '" class="btn btn-sm btn-success" title="payment"><i class="bx bx-dollar-circle"></i></a>';
                    } else {
                        $payment = '';
                    }
                    return '<div class = "btn-group">'. $profileShow . $profileEdit . $profileDelete . $changePassword . $payment .'</div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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
            $hashedPassword = Auth::user()->password;
            if (Hash::check($request->currentPassword, $hashedPassword)) {
                $password = Hash::make($request->password);
                return redirect()->route('admin.students.index')
                ->with('t-success', 'Password Updated Successfully');
            } else {
                return redirect()->route('admin.password')->with('t-danger', 'Current password does not match your old password...Please try again...');
//                return redirect()->route('admin.password')->with('errors', 'Current password does not match your old password...Please try again...');

            }

        }catch (\Exception $exception){
            return $this->sendError('Password change error', ['error' => $exception->getMessage()]);
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


    public function create()
    {
        try {
            $batches = Batch::where('status', 1)
                ->select('id', 'name')
                ->get();
              $latestReg = Student::latest()->first()->reg_no ?? "STD_1000";
              $expReg = explode("_", $latestReg);
              if (!$latestReg) {
                  $latestReg = 'STD_' . 10001;
              } else {
                  $sum = $expReg[1] + 1;
                  $latestReg = 'STD_' . $sum;

              }
              return view('dashboard.students.create', compact('batches', 'latestReg'));
//            return view('dashboard.students.create', compact('batches'));
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

    public function store(StoreStudentRequest $request)
    {
        DB::beginTransaction();
        try {
            $student = new Student();
            $student->name = $request->name;
            $student->reg_no = $request->reg_no;
            // $student->reg_no = '1234';
            $student->email = $request->email;
            $student->batch_id = $request->batch_id;
            $student->gender = $request->gender;
            $student->current_address = $request->current_address;
            $student->permanent_address = $request->permanent_address;
            $student->contact_number = $request->contact_number;
            $student->parent_contact = $request->parent_contact;
            $student->monthly_fee = $request->monthly_fee;
            $student->note = $request->note;

            if ($request->has('profile')) {
                $imageUploade = $request->file('profile');
                $imageName = time() . '.' . $imageUploade->getClientOriginalExtension();
                $imagePath = public_path('images/users/');
                $imageUploade->move($imagePath, $imageName);
                $student->profile = $imageName;
            } else {
                $student->profile = 'user_image.jpg';
            }
            $student->created_by = Auth::id();
            $student->save();


            $user = new User();
            $user->student_id = $student->id;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->password = Hash::make("student");
            $user->email = $request->email;
            $user->type = 2;
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
            $student = Student::where('id', $id)->with('batch')->first();
            return view('dashboard.students.show', compact('student'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show edit page
     *
     * @param  mixed $id
     * @return void
     */

    public function edit($id)
    {
        try {
            $student = Student::findOrFail($id);
            $batches = Batch::select('id', 'name')->get();
            return view('dashboard.students.edit', compact('student', 'batches'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * Update student data
     *
     * @param  mixed $request
     * @param  mixed $student
     * @return void
     */

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

            $student->name = $request->name;
            $student->reg_no = $request->reg_no;
            $student->email = $request->email;
            $student->batch_id = $request->batch_id;
            $student->gender = $request->gender;
            $student->current_address = $request->current_address;
            $student->permanent_address = $request->permanent_address;
            $student->contact_number = $request->contact_number;
            $student->parent_contact = $request->parent_contact;
            $student->updated_by = Auth::id();
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

    /**
     * Delete student from database
     *
     * @param  mixed $student
     * @return void
     */

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
}
