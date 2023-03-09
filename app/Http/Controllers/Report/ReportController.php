<?php

namespace App\Http\Controllers\Report;

use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Tattendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function ActiveInactiveStudent(){
        try {
            return view('dashboard.report.student_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function ActiveInactiveStudentList(Request $request){
        try {
            if ($request->ajax()) {

                $data = Student::with('batch')->where('status', $request->student_id)->get();

                return Datatables::of($data)

                    ->addColumn('batch_name', function (Student $data) {
                        $name = isset($data->batch->name) ? $data->batch->name : null;
                        return $name;
                    })

                    ->addColumn('action', function (Student $data) {
                        return '<a href="' . route('admin.students.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class="bx bxs-show"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action', 'batch_name'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getBatchWiseSubject(Request $request){
        $batchId= $request->id;
        $batch= Batch::where('id', $batchId)->first();
        $subjectIds= json_decode($batch->subject_id);
        $subjects= Subject::whereIn('id', $subjectIds)->get();
        return response()->json($subjects);
    }

    public function BatchWiseStudent(){
        try {
            $batches =  Batch::all();
            return view('dashboard.report.batch_wise_student', compact('batches'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function BatchWiseStudentList(Request $request){

        try {
            if ($request->ajax()) {

                $data = Student::with('batch')->where('batch_id', $request->batch_id)->where('status', $request->status)->get();

                return Datatables::of($data)

                    ->addColumn('action', function (Student $data) {
                        return '<a href="' . route('admin.students.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class="bx bxs-show"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StudentAttendance(){
        try {
            $batches = Batch::all();
            return view('dashboard.report.student_attendance', compact('batches'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getBatchWiseStudent(Request $request){
        $student = Student::where('batch_id', $request->batch_id)->get();
        return response()->json($student);
    }

    public function StudentAttendanceList(Request $request){

        try {
            if ($request->ajax()) {

                $data = Attendance::with('batch','student')
                ->where('student_id', $request->student_id)
                ->where('date', '>', $request->start_date)
                ->where('date', '<=', $request->end_date)
                ->get();

                return Datatables::of($data)

                    ->addColumn('batch_name', function (Attendance $data) {
                        $name = isset($data->batch->name) ? $data->batch->name : null;
                        return $name;
                    })

                    ->addColumn('student_name', function (Attendance $data) {
                        $name = isset($data->student->name) ? $data->student->name : null;
                        return $name;
                    })

                    ->addColumn('reg_no', function (Attendance $data) {
                        $value = isset($data->student->reg_no) ? $data->student->reg_no : null;
                        return $value;
                    })

                    ->addColumn('contact_number', function (Attendance $data) {
                        $contact = isset($data->student->contact_number) ? $data->student->contact_number : null;
                        return $contact;
                    })

                    ->addColumn('status', function (Attendance $data) {
                        if($data->status == 0){
                             $button = 'Absence' ;
                        }else{
                            $button = 'Present' ;
                        }
                        return $button;
                    })

                    ->addColumn('action', function (Attendance $data) {
                        return '<a href="' . route('admin.students.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class="bx bxs-show"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['batch_name','student_name','contact_number','status','action'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function BatchWiseAttendance(){
        try {
            // $students =  Student::where('status', 1)->get();
            $batches =  Batch::all();
            return view('dashboard.report.batch_wise_attendance', compact('batches'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function BatchWiseAttendanceList(Request $request){

        try {
            if ($request->ajax()) {

                $data = Attendance::with('batch','student')
                ->where('batch_id', $request->batch_id)
                ->where('status', $request->status)
                ->where('date', '>', $request->start_date)
                ->where('date', '<=', $request->end_date)
                ->get();

                return Datatables::of($data)

                    ->addColumn('student_name', function (Attendance $data) {
                        $name = isset($data->student->name) ? $data->student->name : null;
                        return $name;
                    })

                    ->addColumn('reg_no', function (Attendance $data) {
                        $value = isset($data->student->reg_no) ? $data->student->reg_no : null;
                        return $value;
                    })

                    ->addColumn('contact_number', function (Attendance $data) {
                        $contact = isset($data->student->contact_number) ? $data->student->contact_number : null;
                        return $contact;
                    })

                    ->addColumn('email_address', function (Attendance $data) {
                        $contact = isset($data->student->email) ? $data->student->email : null;
                        return $contact;
                    })

                    ->addColumn('action', function (Attendance $data) {
                        return '<a href="' . route('admin.students.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class="bx bxs-show"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['student_name','contact_number','email_address','action'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function SubjectWiseAttendance(){
        try {
            $batches =  Batch::all();
            return view('dashboard.report.subject_wise_attendance', compact('batches'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function SubjectWiseAttendanceList(Request $request){
        try {
            if ($request->ajax()) {
                $data = Attendance::with('batch','student')
                    ->where('batch_id', $request->batch_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('date', '>', $request->start_date)
                    ->where('date', '<', $request->end_date)
                    ->get();

                return Datatables::of($data)

                    ->addColumn('student_name', function ($data) {
                        $name = isset($data->student->name) ? $data->student->name : null;
                        return $name;
                    })

                    ->addColumn('reg_no', function ($data) {
                        $value = isset($data->student->reg_no) ? $data->student->reg_no : null;
                        return $value;
                    })

                    ->addColumn('contact_number', function ($data) {
                        $contact = isset($data->student->contact_number) ? $data->student->contact_number : null;
                        return $contact;
                    })

                    ->addColumn('status', function ($data) {
                        if($data->status == 0){
                             $button = 'Absence' ;
                        }else{
                            $button = 'Present' ;
                        }
                        return $button;
                    })

                    ->addColumn('action', function ($data) {
                        return '<a href="' . route('admin.students.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class="bx bxs-show"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['student_name', 'reg_no','contact_number','status','action'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function ActiveInactiveTeacher()
    {
        try {
            return view('dashboard.report.teacher_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function ActiveInactiveTeacherList(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Teacher::where('status', $request->teacher_id)->get();

                return Datatables::of($data)
                    ->addColumn('action', function (Teacher $data) {
                        return '<a href="' . route('admin.teachers.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class="bx bxs-show"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action', 'subject_name'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function TeacherAttendance()
    {
        try {
            $teachers = Teacher::all();
            return view('dashboard.report.teacher_attendance', compact('teachers'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function TeacherAttendanceList(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Tattendance::with('teacher')
                    ->where('teacher_id', $request->teacher_id)
                    ->where('date', '>', $request->start_date)
                    ->where('date', '<=', $request->end_date)
                    ->get();
                return Datatables::of($data)

                    ->addColumn('teacher_name', function ($data) {
                        $name = isset($data->teacher->name) ? $data->teacher->name : null;
                        return $name;
                    })

                    ->addColumn('reg_no', function ($data) {
                        $value = isset($data->teacher->reg_no) ? $data->teacher->reg_no : null;
                        return $value;
                    })

                    ->addColumn('contact_number', function ($data) {
                        $contact = isset($data->teacher->contact_number) ? $data->teacher->contact_number : null;
                        return $contact;
                    })

                    ->addColumn('status', function ($data) {
                        if ($data->status == 0) {
                            $button = 'Absence';
                        } else {
                            $button = 'Present';
                        }
                        return $button;
                    })

                    ->addColumn('action', function ($data) {
                        return '<a href="' . route('admin.teachers.show', $data->id) . '" class="btn btn-sm btn-info" title="view"><i class="bx bxs-show"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['teacher_name','reg_no','contact_number', 'status', 'action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }

}
