<?php

namespace App\Http\Controllers\TeacherAttendance;

use App\Models\Teacher;
use App\Models\Tattendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class TattendanceContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('can:teacher_attendance');
    }

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

    public function report(){
        return view('dashboard.tattendances.report');
        // return view('dashboard.attendances.report', compact('batches', 'students'));
    }

    public function getTeacherByMonth(Request $request){
        $month = date_format(date_create($request->month), "m");
        $year = date_format(date_create($request->month), "Y");
        $attendances = Tattendance::whereMonth('created_at', $month)
                                    ->whereYear('created_at', $year)
                                    ->get();
        $teacherIds = [];
        foreach($attendances as $item){
            $teacherIds[] = $item->teacher_id;
        }
        $teachers = Teacher::whereIn('id', $teacherIds)->get();
        return $teachers;
    }

    public function reportList(Request $request){
        $month = date_format(date_create($request->month), "m");
        $year = date_format(date_create($request->month), "Y");

        if ($request->teacher_id == null) {
            $reports = Tattendance::whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->with('teacher')
                        ->get();
        }
        else{
            $reports = Tattendance::whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->where('teacher_id', $request->teacher_id)
                        ->with('teacher')
                        ->get();
        }
        // return $reports;
        return view('dashboard.tattendances.reportlist', compact('reports'));
    }

 
    public function destroy($id)
    {
        //
    }
}
