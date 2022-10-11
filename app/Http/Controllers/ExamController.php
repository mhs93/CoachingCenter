<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Rules\ExamTimeOverlap;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class ExamController extends Controller
{

    public function getList()
    {
        try {
            $data = Exam::select('id', 'name', 'batch_id', 'start_time', 'end_time', 'status')
                ->orderBy('id', 'DESC')->get();
            return DataTables::of($data)->addIndexColumn()
                //Batches
                ->addColumn('batch_id', function ($data){
                    $batch_ids='';
                    $batch_names = '';
                    if($data->batch_id){
                        $batch_ids = json_decode($data->batch_id);
                        if(in_array("0", $batch_ids)){
                            $batches = Batch::all();
                            foreach($batches as $key=>$item) {
                                $batch_names = "All Batch  ";
                            }
                        }else{
                            $batches = Batch::whereIn('id',$batch_ids)->get(['id','name']);
                            foreach($batches as $key=>$item) {
                                $batch_names .= $item->name.", ";
                            }
                        }
                    }else{
                        $batches='';
                    }
                    $batch_names = substr($batch_names, 0, -2);
                    return $batch_names;
                })

                // Start Time
                ->addColumn('start_time', function ($data){
                    $start_time='';
                    if($data->start_time){
                        $start_time = json_decode($data->start_time);
                    }
                    return $start_time;
                })

                // End Time
                ->addColumn('end_time', function ($data){
                    $end_time='';
                    if($data->end_time){
                        $end_time = json_decode($data->end_time);
                    }
                    return $end_time;
                })

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
                    if (Auth::user()->can('batches_edit')){
                        $showDetails = '<a href="' . route('admin.batches.show', $data->id) . '" class="btn btn-sm btn-info"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showDetails = '';
                    }
                    if (Auth::user()->can('batches_edit')){
                        $editButton = '<a href="' . route('admin.batches.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class=\'bx bxs-edit-alt\'></i></a>';
                    }else{
                        $editButton = '';
                    }
                    if (Auth::user()->can('batches_delete')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    return '<div class = "btn-group">'.$showDetails.$editButton.$deleteButton.'</div>';
                })

                ->rawColumns(['action', 'status', 'batch_id'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getSubject(Request $request)
    {
        $array = [];
        $batchs = Batch::whereIn('id', $request->batchId)->select('subject_id')->get();
        foreach($batchs as $batch) {
            $array[] = json_decode($batch->subject_id);
        }
        $batchIds = array_unique(call_user_func_array('array_merge', $array));

        $subjects = Subject::whereIn('id', $batchIds)->get();
        return $subjects;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'start_time'   =>  ['required', new ExamTimeOverlap()],
            'end_time'     =>  ['required', new ExamTimeOverlap()]
        ]);
        try {
            $exam = new Exam();
            $exam->name = $request->name;
            $exam->status = $request->status;
            $exam->note = json_encode($request->note);
            $exam->start_time = json_encode($request->start_time);
            $exam->end_time = json_encode($request->end_time);
            $exam->batch_id = json_encode($request->batch_id);
            $exam->subject_id = json_encode($request->subject_id);
            $exam->save();
            return redirect()->route('admin.exams.index')->with('t-success', 'New batches added successfully');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        //
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
            $exam->delete();
            return response()->json([
                'success' => true,
                'message' => 'Exam Deleted Successfully.',
            ]);
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
}
