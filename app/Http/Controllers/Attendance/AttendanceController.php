<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Batch;

use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        try {
            $batches = Batch::all();
            return view('dashboard.attendances.index', compact('batches'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function studentsByBatch(Request $request)
    {
        try {
            $attendances = Attendance::where('batch_id', $request->batch_id)->where('date', $request->date)->with('student')->get();
            $date = $request->date;

            if (empty($attendances->toArray())) {
                $students = Student::where('batch_id', $request->batch_id)->with('batch')->get();
                return view('dashboard.attendances.list', compact('students', 'date'));
            } else {
                return view('dashboard.attendances.list', compact('attendances', 'date'));
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        for ($i = 0; $i < count($request->student_id); $i++) {
            $atten = 'attendance_' . $i;
            $student = new Attendance();
            $student->student_id = $request->student_id[$i];
            $student->batch_id = $request->batch_id[$i];
            $student->date = $request->date[$i];
            $student->status = $request->$atten;
            $student->created_by = Auth::id();
            $student->save();
        }
        return redirect()->route('admin.attendances.index')->with('attendance successfully done');
    }

    protected function update(Request $request)
    {
        for ($i = 0; $i < count($request->student_id); $i++) {
            $atten = 'attendance_' . $i;
            $student = Attendance::where('student_id', $request->student_id[$i])->first();
            $student->student_id = $request->student_id[$i];
            $student->batch_id = $request->batch_id[$i];
            $student->date = $request->date[$i];
            $student->status = $request->$atten;
            $student->created_by = Auth::id();
            $student->update();
        }
        return redirect()->route('admin.attendances.index')->with('attendance successfully updated');
    }

    public function report()
    {
        $batches = Batch::all();
        $students = Student::all();

        return view('dashboard.attendances.report', compact('batches', 'students'));
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function reportList(Request $request)
    {

        $month = date_format(date_create($request->month), "m");
        $year = date_format(date_create($request->month), "Y");

        if ($request->student_id == null) {
            $reports = Attendance::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('batch_id', $request->batch_id)
                ->with('batch', 'student')
                ->get();
        } else {
            $reports = Attendance::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where(['batch_id' => $request->batch_id, 'student_id' => $request->student_id])
                ->with('batch', 'student')
                ->get();
        }
        return view('dashboard.attendances.reportlist', compact('reports'));
    }

    public function getStudentByBatch(Request $request)
    {
        $data = Student::where('batch_id', $request->batch_id)
            ->where('status', 1)
            ->get(['id','name']);

        return $data;
    }
}
