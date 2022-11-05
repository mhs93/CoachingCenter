<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BatchController extends Controller
{
    /**
     * Get all batch lists
     *
     * @return void
     */

    public function getList()
    {
        try {
            $data = Batch::select('id', 'name', 'subject_id', 'status')
                ->orderBy('id', 'DESC')
                ->get();

            return DataTables::of($data)->addIndexColumn()
                //Subject
                ->addColumn('subject_id', function ($data){
                    $batchSubs= '';
                    $subjectIds = '';
                    if($data->subject_id){
                        $subjectIds = json_decode($data->subject_id);
                        if(in_array("0", $subjectIds)){
                            $batchSubs = "All Subjects".", ";
                        }else{
                            $subjects = Subject::whereIn('id',$subjectIds)->get(['id','name']);
                            foreach($subjects as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }
                    }else{
                        $subjects='';
                    }
                    $batchSubs = substr($batchSubs, 0, -2);
                    return $batchSubs;
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
                    if (Auth::user()->can('batches_show')){
                        $showDetails = '<a href="' . route('admin.batches.show', $data->id) . '" class="btn btn-sm btn-info" title="Show"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showDetails = '';
                    }
                    if (Auth::user()->can('batches_edit')){
                        $editButton = '<a href="' . route('admin.batches.edit', $data->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class=\'bx bxs-edit-alt\'></i></a>';
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

                ->rawColumns(['action', 'status', 'subject_id'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Load batch index page
     *
     * @return void
     */

    public function index()
    {
        try {
            $subjects = Subject::select('id', 'name')
                ->where('status', 1)
                ->get();
            return view('dashboard.batches.index', compact('subjects'));
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $subjects = Subject::select('id', 'name')
                ->where('status', 1)
                ->get();
            return view('dashboard.batches.create', compact('subjects'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store branch data into database
     *
     * @param  mixed $request
     * @return void
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:batches,name,NULL,id,deleted_at,NULL',
            "subject_id"    => "required",
            'batch_fee' => 'required|numeric'
        ],
            [
                'batch_fee.numeric' => 'Batch fee must be numeric',
            ]);
        try {
            $batch = new Batch();
            $batch->name = $request->name;
            // $batch->status = $request->status;
            $batch->note = $request->note;
            $batch->start_time = $request->start_time;
            $batch->end_time = $request->end_time;
            $batch->batch_fee = $request->batch_fee;
            $batch->created_by = Auth::id();
            if (in_array("0", $request->subject_id)){
                $batch->subject_id = json_encode($request->subject_id);
            }
            else{
                $batch->subject_id = json_encode($request->subject_id);
            }
            $batch->save();
            return redirect()->route('admin.batches.index')->with('t-success', 'New batches added successfully');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $batch = Batch::findOrFail($id);
            $subjectIds = json_decode($batch->subject_id);
            $batchSubs= '';
            if(in_array("0", $subjectIds)){
                $subjects = Subject::get(['id','name']);
                foreach($subjects as $key=>$item) {
                    $batchSubs .= $item->name.", ";
                }
            }else{
                $subjects = Subject::whereIn('id',$subjectIds)->get(['id','name']);
                foreach($subjects as $key=>$item) {
                    $batchSubs .= $item->name.", ";
                }
            }
            // Remove last 2 elements from the $batchSubs string
            $batchSubs = substr($batchSubs, 0, -2);
            return view('dashboard.batches.show', compact('batch', 'subjects', 'batchSubs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }


    /**
     * Show edit page
     *
     * @param  mixed $id
     * @return void
     */

    public function edit($id)
    {
        try {
            $batch = Batch::findOrFail($id);
            $subjects = Subject::select('id', 'name')->get();
            return view('dashboard.batches.edit', compact('batch', 'subjects'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    /**
     * Update batch data
     *
     * @param  mixed $request
     * @return void
     */

    public function update(Request $request, Batch $batch)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:subjects,name,' . $batch->id . ',id,deleted_at,NULL',

            // 'status' => 'nullable|integer',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
//        [
//            // 'status.integer' => 'Select the status',
//            'end_time.after' => 'End Date must be after start date',
//            'start_time.after' => 'Start Date must be today or after today',
//        ]);
        try {
            $batch = Batch::findOrFail($request->batch_id);
            $batch->name = $request->name;
            $batch->status = $request->status;
            $batch->subject_id = json_encode($request->subject_id);
            $batch->note = $request->note;
            $batch->start_time = $request->start_time;
            $batch->end_time = $request->end_time;
            $batch->updated_by = Auth::id();
            $batch->update();

            return redirect()->route('admin.batches.index')->with('t-success', 'Batch edited successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete batch from database
     *
     * @param  mixed $batch
     * @return void
     */

    public function destroy(Batch $batch)
    {
        try {
            $batch->delete();

            return response()->json([
                'success' => true,
                'message' => 'Batch Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Batch change status active or inactive.
     *
     * @param  mixed $batch
     * @return void
     */

    public function changeStatus(Batch $batch)
    {
        try {
            if($batch->status == 1) {
                $batch->status = 0;
                $batch->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Batch inactivated successfully',
                ]);
            }

            $batch->status = 1;
            $batch->update();

            return response()->json([
                'success' => true,
                'message' => 'Batch activated successfully',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
