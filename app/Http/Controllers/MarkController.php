<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\String\b;
use Yajra\DataTables\Facades\DataTables;

class MarkController extends Controller
{
    public function getList()
    {
        try {
            // $data = Exam::select('id', 'status', 'name')
            //     ->orderBy('id', 'DESC')->get();

            // $user = User::findOrFail(Auth::id());
            // if($user->type == '0'){
            //     $data = Mark::select('id', 'status', 'exam_id')
            //         ->with('exam')
            //         ->groupBy('exam_id')
            //         ->orderBy('id', 'DESC')
            //         ->get();
            // }
            // else{
            //     if($user->type == '1'){
            //         $data = Mark::select('id', 'status', 'exam_id')
            //             ->with('exam')
            //             ->groupBy('exam_id')
            //             ->orderBy('id', 'DESC')
            //             ->get();
            //     }
            //     else{
            //         $student = Student::where('id', $user->student_id)->first();
            //         // return $student;
            //         $data = Mark::select('id', 'status', 'exam_id')
            //             ->where('batch_id', $student->batch_id)
            //             ->with('exam')
            //             ->groupBy('exam_id')
            //             ->orderBy('id', 'DESC')
            //             ->get();
            //     }
            // }

            $data = Exam::select('id', 'status', 'name')
                    ->where('mark_status', '1')
                    ->orderBy('id', 'DESC')
                    ->get();

            return DataTables::of($data)->addIndexColumn()
                //Status
                ->addColumn('status', function ($data) {
                    if(Auth::user()->can('batches_edit')){
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
                    // if (Auth::user()->can('mark_edit')){
                    //     $showDetails = '<a href="' . route('admin.exams.show', $data->id) . '" class="btn btn-sm btn-info"><i class=\'bx bxs-low-vision\'></i></a>';
                    // }else{
                    //     $showDetails = '';
                    // }


                    // if (Auth::user()->can('mark_edit')){
                    //     $editButton = '<a href="' . route('admin.marks.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class=\'bx bxs-edit-alt\'></i></a>';
                    // }else{
                    //     $editButton = '';
                    // }

                    if(Auth::user()->can('mark_edit')){
                        $editButton = '<a href="javascript:void(0)" onclick="edit(' . $data->id . ')" class="btn btn-sm btn-warning" title="Edit"><i class="bx bxs-edit-alt"></i></a>';
                    }else{
                        $editButton =  '';
                    }

                    // if (Auth::user()->can('mark_delete')){
                    //     $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    // }else{
                    //     $deleteButton = '';
                    // }

                    if (Auth::user()->can('mark_delete')){
                        $deleteButton = '<a href="' . route('admin.marks.deleteted', $data->id) . '" class="btn btn-sm btn-danger text-white" title="Delete"><i class="bx bxs-trash"></i></a>';

                    }else{
                        $deleteButton = '';
                    }
                    // return '<div class = "btn-group">'.$showDetails.$editButton.$deleteButton.'</div>';
                    return '<div class = "btn-group">'.$editButton.$deleteButton.'</div>';
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
        // $bathces = Examdetails::with('batch')
        //             ->with('exam')
        //             ->where('exam_id', $request->examId)
        //             ->groupBy('batch_id')
        //             ->get();

        // return $bathces;
        // jhsd
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
            return redirect()->route('admin.marks.index')->with('error', 'Exam and Batch alreaduy exist');
        }

        try {
            $c = count($request->subject_id);
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
    public function resultShow(){
        try {
            $exams = Exam::select('id', 'name')
                ->where('status', 1)
                ->get();
            return view('dashboard.marks.reseultShowWithExam', compact('exams'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getResults(Request $request){
        $batch = Batch::where('id', $request->batchId)->first();
        $marks = Mark::where('batch_id', $batch->id)
                ->where('exam_id', $request->examId)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();
        // return $marks;
        $returnHTML = view('dashboard.marks.result-show-with-exam-render',compact('marks'))
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
    public function resultBatchShow($id){
        $exam_id = $id;
        $batches = Mark::where('exam_id', $id)
                    ->groupBy('batch_id')
                    ->get();
        return view('dashboard.marks.resultBatchShow', compact('batches', 'exam_id'));
    }

    public function resultBatchShowRender(Request $request){
        $batch = Batch::where('id', $request->batchId)->first();
        $marks = Mark::where('batch_id', $batch->id)
                ->where('exam_id', $request->examId)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();
        // return $marks;
        $returnHTML = view('dashboard.marks.result-show-with-exam-render',compact('marks'))
        // $returnHTML = view('dashboard.marks.result-render',compact('marks'))
                ->render();
        return $returnHTML;
    }
    // Result Show In the Exam Create Page End

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        $marks = Mark::with(['batch' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->where('exam_id', $exam->id)
                ->get();
        $batch = [];
        foreach($marks as $m){
            $batch[] = $m->batch;
        }
        $batch = array_unique($batch);
        return view('dashboard.marks.edit', compact('batch'));
    }

    public function getResultsEdit(Request $request){
        $batch = Batch::where('id', $request->batchId)
                        ->first();
        $marks = Mark::where('batch_id', $batch->id)
                ->orderByRaw('CONVERT(total, SIGNED) desc')
                ->get();

        $returnHTML = view('dashboard.marks.edit-result-render',compact('marks'))
            ->render();
        return $returnHTML;
    }

    // Start
    public function getMarkedBatches(Request $request){
        $bathces = Mark::with('batch')
                    ->with('exam')
                    ->where('exam_id', $request->examId)
                    ->groupBy('batch_id')
                    ->get();
        return $bathces;
    }

    public function markedShow($id1, $id2){
        $exam_id = $id1;
        $batch_id = $id2;
        $marks = Mark::where('batch_id', $id2)
                ->where('exam_id', $id1)
                ->get();

        return view('dashboard.marks.edit-mark', compact('marks', 'exam_id', 'batch_id'));
    }

    public function markShowSubmit(Request $request){
        // dd($request->all());
        $marks = Mark::where('batch_id', $request->batch_id)
            ->where('exam_id', $request->exam_id)
            ->get();

        $c = count($request->subject_id);
        $j = 0;
        $iMax = count($request->student_id);
        $i = 0;

        $markAsSub = [];
        foreach( $marks as $key => $mark){

            $mark->student_id   =       $request->student_id[$i];
            $mark->total        =       $request->total[$i];
            // for($j; $j < $c; $j++){
            //     $markAsSub[] = $request->mark[$j];
            // }
            // $c += count($request->subject_id);
            $mark->subject_id   =       json_encode($request->subject_id);
            // $mark->mark         =       json_encode($markAsSub);
            $mark->mark         =       json_encode($request->mark);
            $i++;
            // $markAsSub = (array) null;
            $mark->update();
        }

        return redirect()->route('admin.marks.index')->with('t-success', 'Mark Edited successfully');


        // for($i=0; $i< $iMax; $i++){
        //     $markAsSub = [];

        //     $mark->student_id   =       $request->student_id[$i];
        //     $mark->total        =       $request->total[$i];

        //     for($j; $j < $c; $j++){
        //         $markAsSub[] = $request->mark[$j];
        //     }
        //     // $c += count($request->subject_id);

        //     $mark->subject_id   =       json_encode($request->subject_id);
        //     $mark->mark         =       json_encode($markAsSub);
        //     $mark->update();
        // }
        // return redirect()->route('admin.marks.index')->with('t-success', 'Mark Edited successfully');
    }

    public function markedDelete($id1, $id2){
        try {
            $marks = Mark::where('batch_id', $id2)
                ->where('exam_id', $id1)
                ->get();
            foreach($marks as $mark){
                $mark->delete();
            }
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Mark Deleted Successfully.',
            // ]);
            return redirect()->route('admin.marks.index')->with('message', 'Mark deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updatee(Request $request)
    {
        try {
            // return redirect()->route('admin.exams.index')->with('t-success', 'Exam updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            // $mark = Mark::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Result deleted successfully',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    // public function markDelete(Request $request){
    //     $marks = Mark::where('batch_id', $request->batchId)
    //             ->where('exam_id', $request->examId)
    //             ->get();
    //     foreach($marks as $mark){
    //         $mark->delete();
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Marks Deleted Successfully.',
    //     ]);
    // }

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
}
