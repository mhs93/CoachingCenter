<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Batch;
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
            $data = Announcement::select('id', 'batch_id', 'title', 'status')
                ->orderBy('id', 'DESC')->get();

            return DataTables::of($data)->addIndexColumn()
                //Batch
                ->addColumn('batch_id', function ($data){
                    $subjectIds='';
                    $batchSubs= '';
                    if($data->batch_id != NULL){
                        $subjectIds = json_decode($data->batch_id);
                        if(in_array("0", $subjectIds)){
                            $subjects = Batch::get(['id','name']);
                            foreach($subjects as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }else{
                            $subjects = Batch::whereIn('id',$subjectIds)->get(['id','name']);
                            foreach($subjects as $key=>$item) {
                                $batchSubs .= $item->name.", ";
                            }
                        }
                    }else{
                        $subjects='';
                    }
                    // Remove last 2 elements from the $batchSubs string
                    $batchSubs = substr($batchSubs, 0, -2);
                    return $batchSubs;
                })
                //status
                ->addColumn('status', function ($data) {
                    if (Auth::user()->can('announcement_edit')){
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

                    if (Auth::user()->can('announcement_show')){
                        $showButton = '<a href="' . route('admin.announcements.show', $data->id) . '" class="btn btn-sm btn-info"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showButton = '';
                    }
                    if (Auth::user()->can('announcement_edit')){
                        $editButton = '<a href="' . route('admin.announcements.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class=\'bx bxs-edit-alt\'></i></a>';
                    }else{
                        $editButton = '';
                    }
                    if (Auth::user()->can('announcement_edit')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    return '<div class = "btn-group">'.$showButton.$editButton.$deleteButton.'</div>';
                })
                ->rawColumns(['action', 'status'])
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
                ->where('status', 1)->get();

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
            $announcement->description = $request->description;
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
            $announcement->description = $request->description;
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
