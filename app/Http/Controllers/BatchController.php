<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportBatch;
use App\Imports\ImportBatch;
use PDF;
use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:batches_modify')->except(['index','getList','show']);
    }

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
                    if(Auth::user()->can('batches_modify')){
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
                    if (Auth::user()->can('batches_list')){
                        $showDetails = '<a href="javascript:void(0)" onclick="show(' . $data->id . ')" class="btn btn-sm btn-info text-white" title="Show"><i class="bx bxs-low-vision"></i></a>';
                        // $showDetails = '<a href="' . route('admin.batches.show', $data->id) . '" class="btn btn-sm btn-info" title="Show"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showDetails = '';
                    }
                    if (Auth::user()->can('batches_modify')){
                        $editButton = '<a href="' . route('admin.batches.edit', $data->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class=\'bx bxs-edit-alt\'></i></a>';
                    }else{
                        $editButton = '';
                    }
                    if (Auth::user()->can('batches_modify')){
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
//         dd($request->all());
        $this->validate($request, [
            'name'       => 'required|string|unique:batches,name,NULL,id,deleted_at,NULL',
            "subject_id" => "required",
            "start_date" => "required",
            "end_date"   => "required",
            "image"   => "required",
        ],
        [
            'batch_fee.numeric' => 'Batch fee must be numeric',
        ]);

        if( $request->start_date > $request->end_date ) {
            return back()->with('error', 'Start date must be less than or equal to the end date');
        }

        if($request->adjustment_type){
            $this->validate($request, [
                'adjustment_type'    => 'required|string|unique:batches,name,NULL,id,deleted_at,NULL',
                "adjustment_balance" => "required",
                "total_amount"       => "required",
                "adjustment_cause"   => "required",
            ]);
        }

        try {
            $batch              = new Batch();
            $batch->name        = $request->name;
            // $batch->status = $request->status;
            $batch->note        = $request->note;
            $batch->start_date  = $request->start_date;
            $batch->end_date    = $request->end_date;
            $batch->created_by  = Auth::id();

            if (in_array("0", $request->subject_id)){
                $empty=[];
                $subjects = Subject::select('id')
                    ->where('status', 1)
                    ->get();
                foreach ($subjects as $subject){
                    $sub_data=$subject->id;
                    $empty[]=strval($sub_data);
                }
                $batch->subject_id = json_encode($empty);
            }
            else{
                $batch->subject_id = json_encode($request->subject_id);
            }

            $batch->initial_amount     =  $request->initial_amount;
            $batch->adjustment_balance =  $request->adjustment_balance;
            $batch->adjustment_type    =  $request->adjustment_type;
            $batch->total_amount       =  $request->total_amount;
            $batch->adjustment_cause   =  $request->adjustment_cause;

            if ($request->has('image')) {
                $imageUploade = $request->file('image');
                $imageName    = time() . '.' . $imageUploade->getClientOriginalExtension();
                $imagePath    = public_path('images/batches/');
                $imageUploade->move($imagePath, $imageName);
                $batch->image   =   $imageName;
            } else {
                $batch->image = 'batch_image.jpg';
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
                $batchSubs = "All Subject, ";
            }else{
                $subjects = Subject::whereIn('id', $subjectIds)->get(['id','name']);
                foreach($subjects as $key=>$item) {
                    $batchSubs .= $item->name.", ";
                }
            }
            $batchSubs = substr($batchSubs, 0, -2);
            $balance = $batch->adjustment_balance;
            $array = [
                'batch'     => $batch,
                'batchSubs' => $batchSubs,
                'balance'   => $balance
            ];

            return response()->json([
                'success' => true,
                'data'    => $array,
            ]);
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
            $balance = $batch->adjustment_balance;
            $subjects = Subject::select('id', 'name')->get();
            return view('dashboard.batches.edit', compact('batch', 'subjects', 'balance'));
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
        ]);

        try {
            $batch = Batch::findOrFail($request->batch_id);
            $batch->name        =   $request->name;
            $batch->subject_id  =   json_encode($request->subject_id);
            $batch->note        =   $request->note;
            $batch->start_date  =   $request->start_date;
            $batch->end_date    =   $request->end_date;

            $batch->initial_amount      =   $request->initial_amount;
            $batch->adjustment_balance  =   $request->adjustment_balance;
            $batch->adjustment_type     =   $request->adjustment_type;
            $batch->total_amount        =   $request->total_amount;
            $batch->adjustment_cause    =   $request->adjustment_cause;

            if ($request->has('image')) {
                $imagePath = public_path('images/batches/');
                $old_image = $imagePath . $batch->image;
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
                $imageUpdate = $request->file('image');
                $imageName = time() . '.' . $imageUpdate->getClientOriginalExtension();
                $imageUpdate->move($imagePath, $imageName);
                $batch->image = $imageName;
            } else {
                $imageName = 'batch_image.jpg';
            }

            $batch->updated_by = Auth::id();
            $batch->update();

            return redirect()->route('admin.batches.index')->with('t-success', 'Batch updated successfully');
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

    public function getAllSubject(){
        return Subject::get();
    }

    public function getSubjectFee(Request $request){
        if($request->subjectId){
            if(in_array("0", $request->subjectId)){
                $subjectFee = Subject::sum('fee');
                return [
                    'status' => 'fee',
                    'data' => $subjectFee
                ];
            }
            else{
                $subjects = Subject::whereIn('id', $request->subjectId)->get();
                return [
                    'status' => true,
                    'data' => $subjects
                ];
            }
        }
        else{
            return [
                'status' => false,
            ];
        }
    }

    public function importView(Request $request){
        return view('dashboard.batches.index');
    }

    public function importBatches(Request $request){
        Excel::import(new ImportBatch, request()->file('file'));
        return redirect()->back()->with('message','Batch imported successfully');
    }

    public function exportBatches()
    {
        return Excel::download(new ExportBatch, 'batches.xlsx');
    }
    public function print(){
        $batches = Batch::get();
        // dd($batches);
        return view('dashboard.batches.print', compact('batches') );
    }

    public function pdf(){
        $batches = Batch::get();
        $pdf = PDF::loadView('dashboard.batches.pdf', compact('batches') );
        return $pdf->download('batchList.pdf');
    }
}
