<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamDetails;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;

use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\b;
use Yajra\DataTables\Facades\DataTables;

class MarkController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('can:mark_list')->except(['create','store','update','delete','changeStatus']);
//    }

    public function getList()
    {
        try {

            $user = User::findOrFail(Auth::id());
            if($user->type == '0'){
                $data = Exam::select('id', 'status', 'name')
                    ->where('mark_status', '1')
                    ->orderBy('id', 'DESC')
                    ->get();
            }
            else{
                if($user->type == '1'){
                    $data = Exam::select('id', 'status', 'name')
                    ->where('mark_status', '1')
                    ->orderBy('id', 'DESC')
                    ->get();
                }
                else{
                    $student = Student::where('id', $user->student_id)->first();
                    $examDetails = ExamDetails::where('batch_id', $student->batch_id)
                                ->groupBy('exam_id')
                                ->get();
                    $data = [];
                    foreach($examDetails as $examDetail){
                        $data[] = Exam::select('id', 'name', 'status')
                                ->orderBy('id', 'DESC')
                                ->where('id',  $examDetail->exam_id)
                                ->where('mark_status', '1')
                                ->first();
                    }
                    if($data){
                        if($data[0] == null){
                            $data = [];
                        }
                    }
                }
            }

            return DataTables::of($data)->addIndexColumn()
                //Status
                ->addColumn('status', function ($data) {
                    if(Auth::user()->can('mark_modify')){
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
                    if(Auth::user()->can('mark_modify')){
                        $editButton = '<a href="javascript:void(0)" onclick="edit(' . $data->id . ')" class="btn btn-sm btn-warning" title="Edit and Delete">Action</a>';
                    }else{
                        $editButton =  '';
                    }
                    return '<div class = "btn-group">'.$editButton.'</div>';
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $exams = Batch::select('id', 'name')
            ->where('status', 1)
            ->get();
            return view('dashboard.marks.index', compact('exams'));
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    //Start of Marks Creating Purpose Start
    public function getBatches(Request $request){
        $user = User::findOrFail(Auth::id());
        if($user->type == '0'){
            $bathces = Examdetails::with('batch')
                    ->with('exam')
                    ->where('exam_id', $request->examId)
                    ->groupBy('batch_id')
                    ->get();
            return $bathces;
        }
        else{
            if($user->type == '1'){
                $bathces = Examdetails::with('batch')
                    ->with('exam')
                    ->where('exam_id', $request->examId)
                    ->groupBy('batch_id')
                    ->get();
                return $bathces;
            }
            else{
                $student = Student::where('id', $user->student_id)->first();
                $bathces = Examdetails::with('batch')
                    ->with('exam')
                    ->where('exam_id', $request->examId)
                    ->where('batch_id', $student->batch_id)
                    ->groupBy('batch_id')
                    ->get();
                return $bathces;
            }
        }
    }

    public function getSubjects(Request $request){
        $batch = Batch::where('id', $request->batchId)->first();

        $subjectIds = json_decode($batch->subject_id);
        if( in_array("0", $subjectIds) ){
            $subjects = Subject::all();
        }else{
            $subjects = Subject::whereIn('id', $subjectIds)->get();
        }

        $students = Student::where('batch_id', $batch->id)->select('id', 'name')->get();
        $studentName = [];
        foreach($students as $st){
            $studentName[] = [
                'name'=>$st->name,
                'id'=>$st->id,
            ];
        }
        $subjectName = [];
        foreach($subjects as $su){
            $subjectName[] = [
                'name'=>$su->name,
                'id'=>$su->id,
            ];

        }
        $returnHTML = view('dashboard.marks.mark-render',compact('studentName','subjectName'))
            ->render();
        return $returnHTML;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $exams = Exam::select('id', 'name')
                ->where('status', 1)
                ->get();
            return view('dashboard.marks.create', compact('exams'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // End of Marks Creating Purpose Start

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Mark $mark)
    {
        $examBatchExist = Mark::where('exam_id', $request->exam_id)
                                ->where('batch_id', $request->batch_id)
                                ->first();

        if($examBatchExist != ''){
            return redirect()->route('admin.marks.index')->with('error', 'Marks already created');
        }

        try {
            $c = count($request->subject_id);
            // dd($c);
            $j = 0;
            $iMax = count($request->student_id);
            $examId = 0;

            for($i=0; $i< $iMax; $i++){
                $markAsSub = [];

                $mark = new Mark();
                $mark->status       =       $request->status;
                $mark->exam_id      =       $request->exam_id;
                $examId = $request->exam_id;
                $mark->batch_id     =       $request->batch_id;
                $mark->student_id   =       $request->student_id[$i];
                $mark->total        =       $request->total[$i];

                for($j; $j < $c; $j++){
                    $markAsSub[] = $request->mark[$j];
                }
                $c += count($request->subject_id);

                $mark->subject_id   =       json_encode($request->subject_id);
                $mark->mark         =       json_encode($markAsSub);
                $mark->note         =       strip_tags($request->note);
                $mark->save();
            }

            $exam = Exam::where('id', $examId)->first();
            $exam->mark_status = '1';
            $exam->save();

            return redirect()->route('admin.marks.index')->with('t-success', 'New mark added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    //Start of Marks Showing Purpose
    public function resulShowByExam(){
        try {
            $exams = Exam::select('id', 'name')
                ->where('status', 1)
                ->get();
            return view('dashboard.marks.reseult-show-with-exam', compact('exams'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getResults(Request $request){
        $examId  = $request->examId;
        $batchId = $request->batchId;
        $batch = Batch::where('id', $request->batchId)->first();
        $marks = Mark::where('batch_id', $batch->id)
                ->where('exam_id', $request->examId)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();
        $returnHTML = view('dashboard.marks.result-show-with-exam-render',compact('marks', 'examId', 'batchId'))
                ->render();
        return $returnHTML;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    //End of Marks Showing Purpose


    // Result Show In the Exam Create Page Start
    public function resultShowByBatch($id){
        $exam_id = $id;
        $batches = Mark::where('exam_id', $id)
                    ->groupBy('batch_id')
                    ->get();
        return view('dashboard.marks.result-show-by-batch', compact('batches', 'exam_id'));
    }

    public function resultShowByBatchRender(Request $request){
        $examId  = $request->examId;
        $batchId = $request->batchId;
        $batch = Batch::where('id', $request->batchId)->first();
        $marks = Mark::where('exam_id', $request->examId)
                ->where('batch_id', $batch->id)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();
        $returnHTML = view('dashboard.marks.result-show-with-exam-render',compact('marks', 'examId', 'batchId'))
                ->render();
        return $returnHTML;
    }
    // Result Show In the Exam Create Page End

    // Edit Start
    public function getMarkedBatches(Request $request){
        $bathces = Mark::with('batch')
                    ->with('exam')
                    ->where('exam_id', $request->examId)
                    ->groupBy('batch_id')
                    ->get();
        return $bathces;
    }

    public function edit($id1, $id2){
        $exam_id    = $id1;
        $batch_id   = $id2;
        $batch      = Batch::find($batch_id);
        $subjectIds = json_decode($batch->subject_id);

        $marks = Mark::where('batch_id', $id2)
                ->where('exam_id', $id1)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();

        return view('dashboard.marks.edit-mark',
                compact('marks', 'exam_id', 'batch_id', 'subjectIds'));
    }

    public function update(Request $request){
        $marks = Mark::where('batch_id', $request->batch_id)
            ->where('exam_id', $request->exam_id)
            ->get();

        $c = count($request->subject_id);
        $j = 0;
        $i = 0;

        $markAsSub = [];
        foreach( $marks as $key => $mark){
            $mark->student_id   =  $request->student_id[$i];
            $mark->total        =  $request->total[$i];
            for($j; $j < $c; $j++){
                $markAsSub[] = $request->mark[$j];
            }
            $c += count($request->subject_id);
            $mark->subject_id   =       json_encode($request->subject_id);
            $mark->mark         =       json_encode($markAsSub);

            $markAsSub = (array) null;
            $mark->update();
            $i++;
        }

        return redirect()->route('admin.marks.index')->with('t-success', 'Mark Edited successfully');
    }
    //Edit End

    public function delete($id1, $id2){
        try {
            $marks = Mark::where('batch_id', $id2)
                ->where('exam_id', $id1)
                ->get();
            foreach($marks as $mark){
                $mark->delete();
            }

            $mark = Mark::where('exam_id', $id1)->first();
            if(!$mark){
                $exam = Exam::findOrFail($id1);
                $exam->mark_status = '0';
                $exam->save();
            }

            return redirect()->route('admin.marks.index')->with('t-success', 'Mark deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // For Print
    public function printResult($id1, $id2){
        $examId  = $id1;
        $batchId = $id2;

        $exam  = Exam::findOrFail($examId);
        $batch = Batch::findOrFail($batchId);
        $startDate = Carbon::parse($batch->start_date)->format('d F, Y');
        $endDate = Carbon::parse($batch->end_date)->format('d F, Y');
        $marks = Mark::where('batch_id', $batchId)
                ->where('exam_id', $examId)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();
        return view('dashboard.marks.print-mark-sheet',
            compact('marks', 'exam', 'batch', 'startDate', 'endDate'));
    }


    // For PDF
    public function pdfGenerateForMark($id1, $id2){
        $examId  = $id1;
        $batchId = $id2;

        $exam  = Exam::findOrFail($examId);
        $batch = Batch::findOrFail($batchId);
        $startDate = Carbon::parse($batch->start_date)->format('d F, Y');
        $endDate = Carbon::parse($batch->end_date)->format('d F, Y');
        $marks = Mark::where('batch_id', $batchId)
                ->where('exam_id', $examId)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();

        $data = [
            'marks'     => $marks,
            'exam'      => $exam,
            'batch'     => $batch,
            'startDate' => $startDate,
            'endDate'   => $endDate
        ];
        // $image = base64_encode((asset('images/setting/logo/'.setting('logo'))));
        //dd($image);
        //dd(setting('logo'));
        // $pdf = PDF::loadView('dashboard.marks.pdf-mark-sheet', $data);
        $pdf = PDF::loadView('dashboard.marks.pdf-mark-sheet',
                compact('marks', 'exam', 'batch', 'startDate', 'endDate'));
        return $pdf->download('result.pdf');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    public function changeStatus(Mark $mark)
    {
        try {
            if($mark->status == 1) {
                $mark->status = 0;
                $mark->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Result inactivated successfully',
                ]);
            }

            $mark->status = 1;
            $mark->update();

            return response()->json([
                'success' => true,
                'message' => 'Resource activated successfully',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function StudentMark(){
        try {
            $exams = Exam::all();
            return view('dashboard.report.batch_wise_student_mark', compact('exams'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StudentMarkList(Request $request){

        try {
            if ($request->ajax()) {
                $data = Mark::with('student','exam','batch')
                ->where('exam_id', $request->exam_id)
                ->where('batch_id', $request->batch_id)
                ->where('student_id', $request->student_id)
                ->get();


                return Datatables::of($data)

                    ->addColumn('dateFormat', function (Mark $data) {
                        $date = Carbon::parse($data->created_at)->format('d M, Y');
                        return $date;
                    })

                    ->addColumn('reg_no', function (Mark $data) {
                        $value = isset($data->student->reg_no) ? $data->student->reg_no : null;
                        return $value;
                    })

                    ->addColumn('contact_number', function (Mark $data) {
                        $contact = isset($data->student->contact_number) ? $data->student->contact_number : null;
                        return $contact;
                    })

                    ->addColumn('subjects_mark', function (Mark $data) {
                        $subjectIds = json_decode($data->subject_id);
                        $subjects = Subject::whereIn('id', $subjectIds)->get();
                        $subMark = json_decode($data->mark);

                        $subNames = '';
                        $subMarks = '';

                        foreach($subjects as $key => $subject) {
                            $value = $subject->name;
                            $subNames.= $value .  '<br/>';
                            $subMarks.= $subMark[$key].  '<br/>';
                        }
                        return '<table >
                                    <tr >
                                        <td >'. $subNames.'</td>
                                        <td >'. $subMarks.'</td>
                                    </tr>
                                </table>';
                            })

                    ->addIndexColumn()
                    ->rawColumns(['dateFormat','reg_no','contact_number','subjects_mark'])
                    ->make(true);
                    // ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

}
