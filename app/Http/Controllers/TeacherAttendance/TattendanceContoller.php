<?php

namespace App\Http\Controllers\TeacherAttendance;

use App\Models\Batch;
use App\Models\Teacher;
use App\Models\Tattendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class TattendanceContoller extends Controller
{
    public function index()
    {
        try {
            $teahcers = Teacher::all();
            return view('dashboard.tattendances.index', compact('teahcers'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function teachersByName(Request $request){
        try {
            $attendances = Tattendance::where('date', $request->date)
                    ->whereIn('teacher_id', $request->teacher_id)
                    ->get();
            $date = $request->date;

            $currentDate = date('Y-m-d');
            if($date > $currentDate) {
                return back()->with('error', 'Your date must be less than or equal current date');
            }


            if (empty($attendances->toArray())) {
                $teachers = Teacher::whereIn('id', $request->teacher_id)->get();
                return view('dashboard.tattendances.list', compact('teachers', 'date'));
            } else {
                return view('dashboard.tattendances.list', compact('attendances', 'date'));
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Store
    public function store(Request $request)
    {
        try {
            for ($i = 0; $i < count($request->teacher_id); $i++) {
                $atten = 'attendance_' . $i;
                $teacher = new Tattendance();
                $teacher->teacher_id = $request->teacher_id[$i];
                $teacher->date = $request->date[$i];
                $teacher->status =  $request->$atten;
                $teacher->created_by = Auth::id();
                $teacher->save();
            }
            // return redirect()->route('admin.attendances.index')->with('t-success', 'Attendance successfully taken');
            return redirect()->route('admin.tattendances.index')->with('t-success', 'Teacher Attendance Added Successfully Done');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    // Update
    public function update(Request $request)
    {
        try{
            for ($i = 0; $i < count($request->teacher_id); $i++) {
                $atten = 'attendance_' . $i;
                $teacher = Tattendance::where('teacher_id', $request->teacher_id[$i])->first();
                $teacher->teacher_id = $request->teacher_id[$i];
                $teacher->date = $request->date[$i];
                $teacher->status = $request->$atten;
                $teacher->updated_by = Auth::id();
                $teacher->update();
            }
            return redirect()->route('admin.tattendances.index')->with('t-success', 'Teacher Attendance Successfully Updated');
        }
        catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        //
    }
}
