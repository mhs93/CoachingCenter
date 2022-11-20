<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    /**
     * Get all announcement lists
     *
     * @return void
     */

    public function getList()
    {
        try {

            $user = User::findOrFail(Auth::id());
            if($user->type == '0'){
                $data = Announcement::select('id', 'batch_id', 'title', 'status')
                        ->orderBy('id', 'DESC')
                        ->get();
            }
            else{
                if($user->type == '1'){
                    $data = Announcement::select('id', 'batch_id', 'title', 'status')
                            ->orderBy('id', 'DESC')
                            ->get();
                }
                else{
                    $student = Student::where('id', $user->student_id)->first();
                    $data = Announcement::select('id', 'batch_id', 'title', 'status')
                            ->orderBy('id', 'DESC')
                            // ->orWhere('batch_id', 0)
                            ->get();
                    $announcement = [];
                    foreach($data as $item){
                        $batchIds = json_decode($item->batch_id);
                        if(in_array($student->batch_id, $batchIds)){
                            array_push($announcement, $item);
                        }
                        if(in_array("0", $batchIds)){
                            array_push($announcement, $item);
                        }
                    }
                    $data = $announcement;
                }
            }

            return DataTables::of($data)->addIndexColumn()
                //Batch
                ->addColumn('batch_id', function ($data){
                    $batchIds='';
                    $batchSubs= '';
                    if($data->batch_id){
                        $batchIds = json_decode($data->batch_id);
                        if(in_array("0", $batchIds)){
                            $batchSubs .= "All Batch".", ";
                        }else{
                            $batches = Batch::whereIn('id', $batchIds)->get(['id','name']);
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

                //status
                ->addColumn('status', function ($data) {
                    if (Auth::user()->can('announcement_manage')){
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

                    if (Auth::user()->can('announcement_manage')){
                        $showButton = '<a href="' . route('admin.announcements.show', $data->id) . '" class="btn btn-sm btn-info" title="Show"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showButton = '';
                    }
                    if (Auth::user()->can('announcement_manage')){
                        $editButton = '<a href="' . route('admin.announcements.edit', $data->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class=\'bx bxs-edit-alt\'></i></a>';
                    }else{
                        $editButton = '';
                    }
                    if (Auth::user()->can('announcement_manage')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    return '<div class = "btn-group">'.$showButton.$editButton.$deleteButton.'</div>';
                })
                ->rawColumns(['action', 'status', 'batch_id'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Load announcement index page
     *
     * @return void
     */

    public function index()
    {
        try {
            return view('dashboard.announcements.index');
        } catch (\Exception $e) {
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
            $batches = Batch::select('id', 'name', 'status')
                ->where('status', 1)
                ->get();

            return view('dashboard.announcements.create', compact('batches'));
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
        // dd($request->all());
        $this->validate($request, [
            'batch_id'    => 'required',
            'title'       => 'required|string',
            'description' => 'nullable',
        ],
        [
            'batch_id.required' => 'Batch is required',
        ]);
        try {
            $announcement = new Announcement();
            if (in_array("0", $request->batch_id)){
                $announcement->batch_id = json_encode($request->batch_id);
            }
            else{
                $announcement->batch_id = json_encode($request->batch_id);
            }
            $announcement->title = $request->title;
            $announcement->note = $request->note;
            $announcement->created_by = Auth::id();
            $announcement->save();
            return redirect()->route('admin.announcements.index')
                ->with('t-success', 'New announcements added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $subjectIds = json_decode($announcement->batch_id);
            $batchSubs= '';
            if(in_array("0", $subjectIds)){
                // $subjects = Batch::get(['id','name']);
                $bathces = Batch::all();
                foreach($bathces as $key=>$item) {
                    $batchSubs .= $item->name.", ";
                }
            }else{
                $bathces = Batch::whereIn('id',$subjectIds)->get(['id','name']);
                foreach($bathces as $key=>$item) {
                    $batchSubs .= $item->name.", ";
                }
            }
            // Remove last 2 elements from the $batchSubs string
            $batchSubs = substr($batchSubs, 0, -2);
            return view('dashboard.announcements.show', compact('announcement', 'bathces', 'batchSubs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        try {
            // All batches
            $batches = Batch::select('id', 'name', 'status')->get();
            return view('dashboard.announcements.edit', compact('batches', 'announcement'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $announcement
     * @return void
     */

    public function update(Request $request, Announcement $announcement)
    {
        $this->validate($request, [
            'batch_id'    => 'required',
            'title'       => 'required|string',
            'description' => 'nullable',
        ],
        [
            'batch_id.required' => 'Please Select batch',
        ]);
        try {
            $announcement->batch_id = json_encode($request->batch_id);
            $announcement->title = $request->title;
            $announcement->note = $request->note;
            $announcement->updated_by = Auth::id();
            $announcement->update();

            return redirect()->route('admin.announcements.index')
                ->with('t-success', 'New announcements updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete announcement from database
     *
     * @param  mixed $announcement
     * @return void
     */

    public function destroy(Announcement $announcement)
    {
        try {
            $announcement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Announcement Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Subject change status active or inactive.
     *
     * @param  mixed $subject
     * @return void
     */

    public function changeStatus(Announcement $announcement)
    {
        try {
            if ($announcement->status == 1) {
                $announcement->status = 0;
                $announcement->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Announcement inactivated successfully',
                ]);
            }

            $announcement->status = 1;
            $announcement->update();

            return response()->json([
                'success' => true,
                'message' => 'Announcement activated successfully',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
