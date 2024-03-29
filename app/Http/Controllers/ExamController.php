<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Support\Carbon;
use App\Models\Exam;
use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:exam_modify')->except(['index','getList','show']);
    }

    public function getList()
    {
        try {
            // $data = Exam::select('id', 'name', 'status')
            //     ->orderBy('id', 'DESC')->get();

            $user = User::findOrFail(Auth::id());
            if($user->type == '0'){
                $data = Exam::with('examDetails.batch')
                    ->select('id', 'name', 'start_date', 'end_date', 'status')
                    ->orderBy('id', 'DESC')
                    ->get();
            }
            else{
                if($user->type == '1'){
                    $data = Exam::select('id', 'name', 'status')
                        ->orderBy('id', 'DESC')
                        ->where('status', '1')
                        ->get();
                }
                else{
                    $student = Student::where('id', $user->student_id)->first();
                    $examDetails = ExamDetails::where('batch_id', $student->batch_id)
                                ->groupBy('exam_id')
                                ->get();
                    $data = [];
                    foreach($examDetails as $examDetail){
                        $data[] = Exam::select('id', 'name', 'start_date', 'end_date', 'status')
                            ->orderBy('id', 'DESC')
                            ->where('id',  $examDetail->exam_id)
                            ->where('status', '1')
                            ->first();
                    }
                }
            }

            return DataTables::of($data)->addIndexColumn()
                //Batch
                ->addColumn('batch_id', function ($data) {
                    // $batch = Exam::with('examDetails.batch')
                    //     ->get();
                    // foreach($data as $exam){
                    //     $da .= '<div>'. $exam.examDetails.batch.name .'</div>';
                    // }

                    // foreach($data as $exam){
                    //     $batch = $exam.examDetails.batch.name;
                    // }
                    // return $batch.examDetails.batch.name;

                })

                //Status
                ->addColumn('status', function ($data) {
                    if(Auth::user()->can('exam_modify')){
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
                    if (Auth::user()->can('exam_list')){
                        $showDetails = '<a href="' . route('admin.exams.show', $data->id) . '" class="btn btn-sm btn-info" title="Show"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showDetails = '';
                    }
                    if (Auth::user()->can('exam_modify')){
                        $editButton = '<a href="' . route('admin.exams.edit', $data->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class=\'bx bxs-edit-alt\'></i></a>';
                    }else{
                        $editButton = '';
                    }
                    if (Auth::user()->can('exam_modify')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    if (Auth::user()->can('exam_list')){
                        $resultButton = '<a href=" '. route('admin.result-show-by-batch', $data->id) . '" class="btn btn-sm btn-success">See Result</a>';
                    }
                    else{
                        $resultButton = '';
                    }
                    return '<div class = "btn-group">'.$showDetails.$editButton.$deleteButton.$resultButton.'</div>';
                })
                ->addColumn('start_date', function ($data){
                    return  Carbon::parse($data->start_date)->format('Y/m/d');
                })
                ->addColumn('end_date', function ($data){
                    return  Carbon::parse($data->end_date)->format('Y/m/d');
                })

                ->rawColumns(['action', 'batch_id', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getSubject(Request $request)
    {
        $batches = Batch::whereIn('id', $request->batchId)
                        ->select('subject_id','name')
                        ->get();
        $array = [];
        foreach($batches as $batch) {
            $array = json_decode($batch->subject_id);
            if( in_array("0", $array) ){
                $subjects = Subject::all();
            }else{
                $subjects = Subject::whereIn('id', $array)->get();
            }

            $subjectDetails [] = [
                'batch' => $batch->name,
                'subject' => $subjects
            ];
        }
        $returnHTML = view('dashboard.exams.exam-render')
            ->with('subjectDetails', $subjectDetails)->render();
        return $returnHTML;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $batches = Batch::select('id', 'name')
            ->where('status', 1)
            ->get();
            return view('dashboard.exams.index', compact('batches'));
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $batches = Batch::select('id', 'name')
                ->where('status', 1)
                ->get();
                return view('dashboard.exams.create', compact('batches'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required|string',
            'start_date' => 'required',
            'start_date' => 'required',
            'batch_id'   => 'required',
        ]);

        if($request->start_date > $request->end_date){
            return back()->with('error', 'Start date must be less than or equal to the end date');
        }

        DB::beginTransaction();
        try {
            $exam = new Exam();
            $exam->name       = $request->name;
            $exam->status     = $request->status;
            $exam->start_date = $request->start_date;
            $exam->end_date   = $request->end_date;
            $exam->note       = strip_tags($request->note);
            $exam->save();
            $x = 0;
            foreach($request->batch_id as $batchKey=> $batchId){
                $batch = Batch::findOrFail($batchId);
                $batchSub = json_decode($batch->subject_id);

                if( in_array("0", $batchSub) ){
                    $batchSubjects= [];
                    $subs = Subject::pluck('id');
                    foreach($subs as $sub){
                        $batchSubjects [] = $sub;
                    }
                    // $subs = Subject::pluck('id');
                    // $batchSubjects =  $subs->id;
                }
                else{
                    $batchSubjects = $batchSub;
                }

                foreach($batchSubjects as $subkey => $subId){
                    $examDetail = new ExamDetails();
                    $examDetail->exam_id     =  $exam->id;
                    $examDetail->batch_id    =  $batchId;
                    $examDetail->subject_id  =  $subId;
                    $examDetail->date        =  $request->date[$x];
                    $examDetail->start_time  =  $request->start_time[$x];
                    $examDetail->end_time    =  $request->end_time[$x];
                    $examDetail->save();
                    $x++;
                }
                DB::commit();
            }
            return redirect()->route('admin.exams.index')->with('t-success', 'New exam added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $exam = Exam::with('examDetails')
                ->where('id', $id)
                ->first();
            return view('dashboard.exams.show', compact('exam'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        DB::beginTransaction();
        try {
            $exam = Exam::findOrFail($id);
            $examDetails = ExamDetails::with(['batch' => function ($query) {
                                            $query->select('id', 'name');
                                        }])
                                        ->with(['subject' => function ($query) {
                                            $query->select('id', 'name');
                                        }])
                                        ->where('exam_id', $exam->id)
                                        ->get();

            return view('dashboard.exams.edit', compact('exam', 'examDetails'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $exam = Exam::findOrFail($request->id);
            $exam->name       = $request->name;
            $exam->start_date = $request->start_date;
            $exam->end_date   = $request->end_date;
            $exam->status     = $request->status;
            $exam->note       = $request->note;
            $exam->update();

            $x = 0;
            $examDetails = ExamDetails::where('exam_id', $request->id)->get();
            foreach($examDetails as $key => $exam){
                $exam->date        =  $request->date[$x];
                $exam->start_time  =  $request->start_time[$x];
                $exam->end_time    =  $request->end_time[$x];
                $exam->update();
                $x++;
            }

            return redirect()->route('admin.exams.index')->with('t-success', 'Exam updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        try {
            $examDetails = ExamDetails::where('exam_id', $exam->id)->get();
            foreach($examDetails as $exams){
                $exams->delete();
            }
            $exam->delete();
            return redirect()->route('admin.exams.index')->with('t-success', 'Exam Deleted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function changeStatus(Exam $exam)
    {
        try {
            if($exam->status == 1) {
                $exam->status = 0;
                $exam->update();
                return response()->json([
                    'success' => true,
                    'message' => 'Exam inactivated successfully',
                ]);
            }
            $exam->status = 1;
            $exam->update();
            return response()->json([
                'success' => true,
                'message' => 'Exam activated successfully',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function print(){
        $exams = Exam::get();
        return view('dashboard.exams.print', compact('exams') );
    }

    public function pdf(){
        $exams = Exam::get();
        $pdf = PDF::loadView('dashboard.exams.pdf', compact('exams') );
        return $pdf->download('Account List.pdf');
    }
}
