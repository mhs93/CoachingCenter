<?php


namespace App\Http\Controllers\Resource;

use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ResourceController extends Controller
{
    public function getList()
    {
        try {
            $user = User::findOrFail(Auth::id());
            if($user->type == '0'){
                $data = Resource::select('id', 'title', 'batch_id', 'status')
                        ->orderBy('id', 'DESC')
                        ->get();
            }
            else{
                if($user->type == '1'){
                    $data = Resource::select('id', 'title', 'batch_id', 'status')
                            ->orderBy('id', 'DESC')
                            ->get();
                }
                else{
                    $student = Student::where('id', $user->student_id)->first();
                    $data = Resource::select('id', 'title', 'batch_id', 'status')
                            ->orderBy('id', 'DESC')
                            ->get();
                    $resources = [];
                    foreach($data as $item){
                        $batchIds = json_decode($item->batch_id);
                        if(in_array($student->batch_id, $batchIds)){
                            array_push($resources, $item);
                        }
                    }
                    $data = $resources;
                }
            }

            return DataTables::of($data)->addIndexColumn()
                //batch
                ->addColumn('batch_id', function ($data){
                    $batchIds='';
                    $batchSubs= '';
                    if($data->batch_id){
                        $batchIds = json_decode($data->batch_id);
                        if(in_array("0", $batchIds)){
                            $batchSubs .= "All Batch".", ";
                        }else{
                            $batches = Batch::whereIn('id',$batchIds)->get(['id','name']);
                            foreach($batches as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }
                    }else{
                        $batches='';
                    }
                    // Remove last 2 elements from the $batchSubs string
                    $batchSubs = substr($batchSubs, 0, -2);
                    return $batchSubs;
                })


                //Status
                ->addColumn('status', function ($data) {
                    if(Auth::user()->can('resources_list')){
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

                //action
                ->addColumn('action', function ($data) {
                    if (Auth::user()->can('upload_show')){

                        $showDetails = '<a href="' . route('admin.resources.show', $data->id) . '" class="btn btn-sm btn-info" title="Show"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showDetails = '';
                    }
                    if (Auth::user()->can('upload_delete')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    return '<div class = "btn-group">'.$showDetails.$deleteButton.'</div>';
                })
                ->rawColumns(['action', 'status', 'batch_id'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    // Get Subject Batch Wise
    public function getSubjects(Request $request)
    {
        $subjectIds = [];
        if(in_array("0", $request->batchId)){
            $batches = Batch::all();
        }else{
            $batches = Batch::whereIn('id', $request->batchId)->select('subject_id')->get();
        }
        foreach($batches as $batch) {
            $subjectIds[] = json_decode($batch->subject_id);
        }
        $uniqueSubjectIds = array_unique(call_user_func_array('array_merge', $subjectIds));

        $subjects = Subject::whereIn('id', $uniqueSubjectIds)->get();
        return $subjects;
    }

    public function index()
    {
        $resources = Resource::all();
        return view('dashboard.resources.index', compact('resources'));
    }

    public function create()
    {
        $batches = Batch::all();
        $subjects = Subject::all();
        return view('dashboard.resources.create', compact('batches', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'subject_id' => 'required',
                'title' => 'required',
                'batch_id' => 'required',
                'subject_id' => 'required',
                'file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf,docx|max:4096'
            ],
            [
                'subject_id.required' => 'Subject is required',
                'batch_id.required' => 'Batch is required',
                'title.required' => 'Title is required',
                'file.mimes' => 'File must be png, jpg, jpeg, csv, txt, xlx, xls, pdf, docx',
            ]
        );

        DB::beginTransaction();
        try {
            $resource = new Resource();
            $resource->title = $request->title;
            $resource->subject_id = json_encode($request->subject_id);

            if (in_array("0", $request->batch_id)){
                $resource->batch_id = json_encode($request->batch_id);
            }
            else{
                $resource->batch_id = json_encode($request->batch_id);

            }


            // $resource->batch_id = json_encode($request->batch_id);
            $resource->note = $request->note;
            $resource->file = $request->file;

            if ($request->has('file')) {
                $fileUploade = $request->file('file');
                $fileName = time() . '.' . $fileUploade->getClientOriginalExtension();
                $filePath = public_path('files/');
                $fileUploade->move($filePath, $fileName);

                $resource->file = $fileName;
            }
            $resource->save();
            DB::commit();
            return redirect()->route('admin.resources.index')
                ->with('t-success', 'File uploaded successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', '$e');
        }
    }

    public function changeStatus(Resource $resource)
    {
        try {
            if($resource->status == 1) {
                $resource->status = 0;
                $resource->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Resource inactivated successfully',
                ]);
            }

            $resource->status = 1;
            $resource->update();

            return response()->json([
                'success' => true,
                'message' => 'Resource activated successfully',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function show($id)
    {
        $resource = Resource::findOrFail($id);
        $batch_name = '';
        $resource_batches = json_decode($resource->batch_id);
        $bathces = Batch::whereIn('id', $resource_batches)->get(['id','name']);
        foreach($bathces as $key=>$item) {
            $batch_name .= $item->name.", ";
        }
        $batch_name = substr($batch_name, 0, -2);
        if($resource->subject_id){
            $subject_name = '';
            $resource_subjects = json_decode($resource->subject_id);
            if(in_array("0", $resource_subjects)){
                $subjects = Subject::all();
                foreach($subjects as $key=>$item) {
                    $subject_name .= $item->name.", ";
                }
            }else{
                $subjects = Subject::whereIn('id', $resource_subjects)->get(['id','name']);
                foreach($subjects as $key=>$item) {
                    $subject_name .= $item->name.", ";
                }
            }
        }else{
            $subjects='';
        }
        $subject_name = substr($subject_name, 0, -2);
        return view('dashboard.resources.show', compact('resource', 'batch_name', 'subject_name'));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
//
    }

    public function destroy($id)
    {
        try {
            $resource = Resource::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Resource deleted successfully',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }
}
