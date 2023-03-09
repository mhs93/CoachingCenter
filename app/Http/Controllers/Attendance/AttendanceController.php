<?php

namespace App\Http\Controllers\Attendance;
use PDF;

use Carbon\Carbon;
use App\Models\Batch;

use App\Models\Student;
use App\Models\Subject;

use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:attendance_manage')->except(['report','reportList']);
    }

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
            $date = $request->date;
            $currentDate = date('Y-m-d');
            if($date > $currentDate) {
                return back()->with('error', 'Your date must be less than or equal current date');
            }

            $attendances = Attendance::with('student')
                ->where('batch_id', $request->batch_id)
                ->where('subject_id', $request->subject_id)
                ->where('date', $request->date)
                ->get();

            $batch = Batch::where('id', $request->batch_id)->first();
            $subject = Subject::where('id', $request->subject_id)->first();

            if (empty($attendances->toArray())) {
                $students = Student::where('batch_id', $request->batch_id)
                            ->with('batch')
                            ->get();
                return view('dashboard.attendances.list', compact('students', 'date','batch','subject'));
            } else {
                return view('dashboard.attendances.list', compact('attendances', 'date','batch','subject'));
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            for ($i = 0; $i < count($request->student_id); $i++) {
                $atten = 'attendance_' . $i;
                $student = new Attendance();
                $student->student_id = $request->student_id[$i];
                $student->batch_id   = $request->batch_id[$i];
                $student->subject_id = $request->subject_id[$i];
                $student->date       = $request->date[$i];
                $student->status     = $request->$atten;
                $student->created_by = Auth::id();
                $student->save();
            }
            return redirect()->route('admin.attendances.index')->with('t-success','Attendance successfully taken');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    //Update
    protected function update(Request $request)
    {
        try{
            for ($i = 0; $i < count($request->student_id); $i++) {
                $atten               =  'attendance_' . $i;
                $student             =  Attendance::where('student_id', $request->student_id[$i])->first();
                $student->student_id =  $request->student_id[$i];
                $student->batch_id   =  $request->batch_id[$i];
                $student->subject_id =  $request->subject_id[$i];
                $student->date       =  $request->date[$i];
                $student->status     =  $request->$atten;
                $student->created_by =  Auth::id();
                $student->update();
            }
            return redirect()->route('admin.attendances.index')->with('t-success','Attendance successfully updated');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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
        // return $reports;
        return view('dashboard.attendances.reportlist', compact('reports'));
    }

    public function getStudentByBatch(Request $request)
    {
        $data = Student::where('batch_id', $request->batch_id)
            ->where('status', 1)
            ->get(['id','name']);
        return $data;
    }

    public function print(){
        $teachers = Teacher::get();
        return view('dashboard.teachers.print', compact('teachers') );
    }

    public function pdf(){
        $teachers = Teacher::get();
        $pdf = PDF::loadView('dashboard.teachers.pdf', compact('teachers') );
        return $pdf->download('teacherList.pdf');
    }
}
