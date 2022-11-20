<?php

namespace App\Http\Controllers\Routine;

use App\Models\Batch;

use App\Models\Routine;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use function Symfony\Component\String\length;


class RoutineController extends Controller
{
    public function getlist(){

        // $data = Routine::select('id','batch_id','subject_id','day','start_time','end_time')
        //     ->orderBy('id', 'DESC')->get();

        $user = User::findOrFail(Auth::id());
        if($user->type == '0'){
            $data = Routine::select('id','batch_id','subject_id','day','start_time','end_time')
                    ->orderBy('id', 'DESC')
                    ->get();
        }
        else{
            if($user->type == '1'){
                $data = Routine::select('id','batch_id','subject_id','day','start_time','end_time')
                    ->orderBy('id', 'DESC')
                    ->get();
            }
            else{
                $student = Student::where('id', $user->student_id)->first();
                $data = Routine::select('id','batch_id','subject_id','day','start_time','end_time')
                    ->orderBy('id', 'DESC')
                    ->where('batch_id', $student->batch_id)
                    // ->orWhere('batch_id', 0)
                    ->get();
            }
        }

        return DataTables::of($data)->addIndexColumn()
            ->addColumn('batch_name',function ($data){
                return $data->batch->name;
            })
            ->addColumn('subject_name',function ($data){
                return $data->subject->name;
            })
            ->addColumn('day',function ($data){
                if($data->day == 1){
                    return '<span>Saturday</span>';
                }elseif ($data->day == 2){
                    return '<span>Sunday</span>';
                }elseif ($data->day == 3){
                    return '<span>Monday</span>';
                }elseif ($data->day == 4){
                    return '<span>Tuesday</span>';
                }elseif ($data->day == 5){
                    return '<span>Wednesday</span>';
                }elseif ($data->day == 6){
                    return '<span>Thursday</span>';
                }elseif ($data->day == 7){
                    return '<span>Friday</span>';
                }
            })

            ->addColumn('action', function ($data) {
                if (Auth::user()->can('routine_modify')) {
                    $routineEdit = '<a href="' . route('admin.routine.edit', $data->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class=\'bx bxs-edit-alt\'></i></a>';
                } else {
                    $routineEdit = '';
                }
                if (Auth::user()->can('routine_modify')) {
                    $routineDelete = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                } else {
                    $routineDelete = '';
                }

                return '<div class = "btn-group">'. $routineEdit . $routineDelete .'</div>';
            })
            ->rawColumns(['subject_name','batch_name','day','action', 'status'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.routine.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSubject(Request $request)
    {
        $batch = Batch::where('id', $request->batchId)->select('subject_id')->first();
        $batchs = json_decode($batch->subject_id);
        $subjects = Subject::whereIn('id', $batchs)->get();
        return $subjects;
    }

    public function create()
    {
        try{
            $batches = Batch::all()->where('status',1);
            return view('dashboard.routine.create',compact('batches'));
        }catch (\Exception $e) {
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
        $request->validate([
            'batch_id' =>'required',
            'subject_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try{
            $batch = Batch::findOrFail($request->batch_id);
            $batchSubjects = json_decode($batch->subject_id);
            for ($k=0; $k<count($request->subject_id); $k++){
                $day="day_".$request->subject_id[$k];
                $dayCount= count($request->$day);
                for($key=0; $key<$dayCount; $key++){
                    $ttt=$request->$day;
                    $routine = new Routine();
                    $routine->subject_id = $request->subject_id[$k];
                    $routine->batch_id = $request->batch_id;
                    $routine->day = $ttt[$key];
                    $routine->start_time = $request->start_time[$key];
                    $routine->end_time = $request->end_time[$key];
                    $routine->status = $request->status;
                    $routine->note = $request->note;
                    $routine->save();
                }
            }
            return redirect()->route('admin.routine.index')->with('t-success','routine created successfully');
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        dd($id);
//        DB::beginTransaction();
        try{
            $routine = Routine::with('batch')->findOrFail($id);
            $batches = Batch::where('status',1)->get();
            return view('dashboard.routine.edit',compact('routine','batches'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        $request->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        try{
            $routine = Routine::findOrFail($id);
//            $routine->batch_id = $request->batch_id;
//            $routine->subject_id = $subId;
            $routine->day = $request->day;
            $routine->start_time = $request->start_time;
            $routine->end_time = $request->end_time;
            $routine->status = $request->status;
            $routine->note = $request->note;
            $routine->save();
            return redirect()->route('admin.routine.index')->with('t-success','routine updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Routine $routine)
    {
        Routine::where('id', $routine->id)->delete();
        return redirect()->back()->with('t-error','Routine deleted successfully');
    }
    public function changeStatus(Routine $routine)
    {
        try {
            if($routine->status == 1) {
                $routine->status = 0;
                $routine->update();
                return response()->json([
                    'success' => true,
                    'message' => 'Routine inactivated successfully',
                ]);
            }
            $routine->status = 1;
            $routine->update();
            return response()->json([
                'success' => true,
                'message' => 'Routine activated successfully',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
