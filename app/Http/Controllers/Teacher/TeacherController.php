<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Subject;

class TeacherController extends Controller
{
    /**
     * Get all teacher lists
     *
     * @return void
     */

    public function getList()
    {
        try {
            $data = Teacher::select('id', 'name', 'email', 'status', 'subject_id')
            ->orderBy('id', 'DESC')->get();
            return DataTables::of($data)->addIndexColumn()
                //Subject
                ->addColumn('subject_id', function ($data){
                    $subjectIds='';
                    $batchSubs= '';
                    if($data->subject_id != NULL){
                        $subjectIds = json_decode($data->subject_id);
                        if(in_array("0", $subjectIds)){
                            $subjects = Subject::get(['id','name']);
                            foreach($subjects as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }else{
                            $subjects = Subject::whereIn('id',$subjectIds)->get(['id','name']);
                            foreach($subjects as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }
                    }else{
                        $subjects='';
                    }
                    // Remove last 2 elements from the $batchSubs string
                    $batchSubs = substr($batchSubs, 0, -2);
                    return $batchSubs;
                })

                //status
                ->addColumn('status', function ($data) {
                    if(Auth::user()->can('teacher_edit')){
                        $button = ' <div class="form-check form-switch">';
                        $button .= ' <input onclick="statusConfirm(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';
                        return $button;
                    }else{
                        if ($data->status == 1) {
                            return '<div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" onclick="return false;"  checked />
                                    </div>';
                        }else{
                            return '<div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" readonly />
                                    </div>';
                        }
                    }
                })

                //Action
                ->addColumn('action', function ($data) {
                    if (Auth::user()->can('teacher_profile')){
                        $showProfile = '<a href="' . route('admin.teachers.show', $data->id) . '" class="btn btn-sm btn-info"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showProfile = '';
                    }
                    if (Auth::user()->can('teacher_edit')){
                        $editProfile = '<a href="' . route('admin.teachers.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class=\'bx bxs-edit-alt\'></i></a>';
                    }else{
                        $editProfile = '';
                    }
                    if (Auth::user()->can('teacher_delete')){
                        $deleteProfile = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteProfile = '';
                    }
                     // Change Password
                     if (Auth::user()->can('student_delete')) {
                        $chnagePassword = '<a href="' . route('admin.adteacher.password', $data->id) . '" class="btn btn-sm btn-info"><i class="cis-key"></i></a>';
                    } else {
                        $chnagePassword = '';
                    }
                    return '<div class = "btn-group">'.$showProfile.$editProfile.$deleteProfile.$chnagePassword.'</div>';
                })
                ->rawColumns(['action', 'status', 'student_id'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Change Password for Admin
    public function adminPassword($id){
        $teacher = Teacher::findOrFail($id);
        return view('dashboard.teachers.adminChangePassword', compact('teacher'));
    }

    public function adminPasswordSubmit(Request $request){
        $this->validate($request,
        [
            'password'=>'required|confirmed',
        ]);

        $user = User::where('teacher_id', $request->id)->first();
        $user->password = Hash::make($request->password);
        if($user->save()){
            return redirect()->route('admin.teachers.index')
                ->with('t-success', 'Password Updated Successfully');
        }else{
            return redirect()->route('admin.adteacher.password', $request->id)->with('t-success', 'Current password does not match your old password...Please try again...');
        }
    }

     // Change Password for Student
     public function teacherPassword(){
        return view('dashboard.teachers.teacherChangePassword');
    }

    public function teacherPasswordSubmit(Request $request){
        $this->validate($request,
        [
            'currentPassword' => 'required',
            'password' => 'required|confirmed'
        ]);
        try {
            $hashedPassword = Auth::user()->password;
            if (Hash::check($request->currentPassword, $hashedPassword)) {
                $password = Hash::make($request->password);
                return redirect()->route('admin.teachers.index')
                ->with('t-success', 'Password Updated Successfully');
            } else {
                return redirect()->route('admin.teachers.password')->with('t-success', 'Current password does not match your old password...Please try again...');
            }
        }catch (\Exception $exception){
            return $this->sendError('Password change error', ['error' => $exception->getMessage()]);
        }
    }

    /**
     * Load teacher index page
     *
     * @return void
     */

    public function index()
    {
        try {
            return view('dashboard.teachers.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Got to teacher create page
     *
     * @return void
     */

    public function create()
    {
        try {
            $subjects = Subject::select('id', 'name')
                ->where('status', 1)
                ->get();
            $latestReg = Teacher::latest()->first()->reg_no ?? "TCH_1000";
            $expReg = explode("_", $latestReg);
            if(!$latestReg)
            {
                $latestReg = 'TCH_' . 10001;
            }else{
                $sum = $expReg[1] + 1;
                $latestReg = 'TCH_' . $sum;
            }

            return view('dashboard.teachers.create', compact('subjects', 'latestReg'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store teacher data into database
     *
     * @param  mixed $request
     * @return void
     */

    public function store(StoreTeacherRequest $request)
    {
        DB::beginTransaction();
        try {
            $teacher = new Teacher();
            $teacher->name = $request->name;
            $teacher->reg_no = $request->reg_no;
            $teacher->email = $request->email;
            $teacher->gender = $request->gender;
            if (in_array("0", $request->subject_id)){
                $teacher->subject_id = json_encode($request->subject_id);
            }
            else{
                $teacher->subject_id = json_encode($request->subject_id);
            }
            $teacher->current_address = $request->current_address;
            $teacher->permanent_address = $request->permanent_address;
            $teacher->contact_number = $request->contact_number;
            $teacher->monthly_salary = $request->monthly_salary;
            $teacher->note = $request->note;

            if ($request->has('profile')) {
                $imageUploade = $request->file('profile');
                $imageName = time() . '.' . $imageUploade->getClientOriginalExtension();
                $imagePath = public_path('images/users/');
                $imageUploade->move($imagePath, $imageName);

                $teacher->profile = $imageName;
            } else {
                $teacher->profile = 'user_image.jpg';
            }
            $teacher->created_by = Auth::id();
            $teacher->save();

            $user = new User();
            $user->teacher_id = $teacher->id;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->password = Hash::make('teacher');
            // $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->type = 1;
            $user->save();

            // assign new role to the user
            $user->syncRoles(2);

            DB::commit();
            return redirect()->route('admin.teachers.index')
                ->with('t-success', 'New teacher Added Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show teacher details
     *
     * @param  mixed $id
     * @return void
     */

    public function show($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $subjectIds = json_decode($teacher->subject_id);
            $batchSubs= '';
            if(in_array("0", $subjectIds)){
                $subjects = Subject::get(['id','name']);
                foreach($subjects as $key=>$item) {
                    $batchSubs .= $item->name.", ";
                }
            }else{
                $subjects = Subject::whereIn('id',$subjectIds)->get(['id','name']);
                foreach($subjects as $key=>$item) {
                    $batchSubs .= $item->name.", ";
                }
            }
            // Remove last 2 elements from the $batchSubs string
            $batchSubs = substr($batchSubs, 0, -2);
            return view('dashboard.teachers.show', compact('teacher', 'batchSubs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
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
            $teacher = Teacher::findOrFail($id);
            $subjects = Subject::select('id', 'name')->get();
            return view('dashboard.teachers.edit', compact('teacher', 'subjects'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    /**
     * Update teacher data
     *
     * @param  mixed $request
     * @param  mixed $teacher
     * @return void
     */

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        DB::beginTransaction();
        try {
            $user = User::where('teacher_id', $teacher->id)->first();
            if ($request->has('profile')) {
                $imagePath = public_path('images/users/');
                $old_image = $imagePath . $teacher->profile;
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
                $imageUpdate = $request->file('profile');
                $imageName = time() . '.' . $imageUpdate->getClientOriginalExtension();
                $imageUpdate->move($imagePath, $imageName);
                $teacher->profile = $imageName;
            } else {
                $imageName = 'user_image.jpg';
            }
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->gender = $request->gender;
            $teacher->subject_id = json_encode($request->subject_id);
            $teacher->current_address = $request->current_address;
            $teacher->permanent_address = $request->permanent_address;
            $teacher->contact_number = $request->contact_number;
            $teacher->note = $request->note;
            $teacher->updated_by = Auth::id();
            $teacher->update();

            $user->name = $request->name;
            $user->email = $request->email;
            // if ($request->password) {
            //     $user->password = Hash::make($request->password);
            // }
            $user->type = 1;
            $user->update();
            // assign new role to the user
            $user->syncRoles(2);
            DB::commit();
            return redirect()->route('admin.teachers.index')
                ->with('t-success', 'Teacher Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete teacher from database
     *
     * @param  mixed $teacher
     * @return void
     */

    public function destroy(Teacher $teacher)
    {
        try {
            $user = User::where('teacher_id', $teacher->id);
            $teacher = Teacher::findOrFail($teacher->id);
            // Image permanently delete from store
            $imagePath = public_path('images/users/');
            $old_image = $imagePath . $teacher->profile;
            if (file_exists($old_image)) {
                unlink($old_image);
            }
            $user->delete();
            $teacher->delete();
            return response()->json([
                'success' => true,
                'message' => 'Teacher Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    //status
    public function changeStatus(Teacher $teacher)
    {
        try {
            if($teacher->status == 1) {
                $teacher->status = 0;
                $teacher->update();
                return response()->json([
                    'success' => true,
                    'message' => 'Teacher inactivated successfully',
                ]);
            }
            $teacher->status = 1;
            $teacher->update();
            return response()->json([
                'success' => true,
                'message' => 'Teacher activated successfully',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
