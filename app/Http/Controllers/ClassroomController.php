<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ClassRoom;
use function Termwind\div;
use Illuminate\Http\Request;
use App\Rules\ClassroomTimeOverlap;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ClassRoomController extends Controller
{
    /**
     * Get all class room lists
     *
     * @return void
     */

    public function getList()
    {
        try {
            // $data = ClassRoom::with(['batch' => function ($query) {
            //                             $query->select('id', 'name');
            //                         },
            //                         'subject' => function ($query) {
            //                             $query->select('id', 'name');
            //                         }
            //                         ])->orderBy('id', 'DESC')
            //                         ->get();

            $user = User::findOrFail(Auth::id());
            if($user->type == '0'){
                $data = ClassRoom::with(['batch' => function ($query) {
                            $query->select('id', 'name');
                        },
                        'subject' => function ($query) {
                            $query->select('id', 'name');
                        }
                        ])->orderBy('id', 'DESC')
                        ->get();
            }
            else{
                if($user->type == '1'){
                    $data = ClassRoom::with(['batch' => function ($query) {
                            $query->select('id', 'name');
                        },
                        'subject' => function ($query) {
                            $query->select('id', 'name');
                        }
                        ])->orderBy('id', 'DESC')
                        ->get();
                }
                else{
                    $student = Student::where('id', $user->student_id)->first();
                    $data = ClassRoom::with(['batch' => function ($query) {
                            $query->select('id', 'name');
                        },
                        'subject' => function ($query) {
                            $query->select('id', 'name');
                        } ])
                        ->where('batch_id', $student->batch_id)
                        ->orderBy('id', 'DESC')
                        ->get();
                    }
                }

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('class_type', function($data){
                    if ($data->class_type == 1){
                        return 'Physical';
                    }if ($data->class_type == 2){
                        return 'Online';

                    }
                })
                ->addColumn('class_link',function ($data){
                    if($data->class_link == NULL){
                        return '--';
                    }else{
                        return $data->class_link;
                    }
                })
                ->addColumn('access_key',function ($data){
                    if($data->access_key == NULL){
                        return '--';
                    }else{
                        return $data->access_key;
                    }
                })
                ->addColumn('status', function ($data) {
                    if (Auth::user()->can('classRooms_edit')){
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
                ->addColumn('action', function ($data) {
                    if (Auth::user()->can('classRooms_show')){
                        // $classRoomShow = '<a onclick="showDetailsModal(' . $data->id . ')" class="btn btn-sm btn-info"><i class=\'bx bxs-low-vision\'></i></a>';
                        $showButton = '<a href="' . route('admin.class-rooms.show', $data->id) . '" class="btn btn-sm btn-info"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        // $classRoomShow = '';
                        $showButton = '';
                    }
                    if (Auth::user()->can('classRooms_edit')){
                        $classRoomEdit = '<a href="' . route('admin.class-rooms.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class=\'bx bxs-edit-alt\'></i></a>';
                    }else{
                        $classRoomEdit = '';
                    }
                    if (Auth::user()->can('classRooms_delete')){
                        $classRoomDelete = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $classRoomDelete = '';
                    }
                    // return '<div class = "btn-group">'.$classRoomShow.$classRoomEdit.$classRoomDelete.' </div>';
                    return '<div class = "btn-group">'.$showButton.$classRoomEdit.$classRoomDelete.' </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getSubjects(Request $request)
    {
        $batches = Batch::where('id', $request->batchId)->select('subject_id')->first();

        $subject_id = json_decode($batches->subject_id);
        $subjects = Subject::whereIn('id', $subject_id)->get();
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
            return view('dashboard.classrooms.index');
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
            return view('dashboard.classrooms.create', compact('batches'));
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
        // Validation check
        $this->validate($request, [
            'batch_id'     =>  'required|integer',
            'subject_id'   =>  'required',
            'class_type'   =>  'required|string',
            'class_link'   =>  'nullable|string',
            'access_key'   =>  'nullable|string',
            'duration'     =>  'required|string',
            'start_time'   =>  ['required', new ClassroomTimeOverlap()],
            'end_time'     =>  ['required', new ClassroomTimeOverlap()]
        ],
        [
            'batch_id.required'     => 'Batch is required',
            'batch_id.integer'      => 'Batch is required',
            'subject_id.required'   => 'Subject is required',
        ]);

        try {
            $classRoom = new ClassRoom();
            $classRoom->batch_id    =  $request->batch_id;
            $classRoom->subject_id  =  $request->subject_id;
            $classRoom->class_type  =  $request->class_type;
            $classRoom->class_link  =  $request->class_link;
            $classRoom->access_key  =  $request->access_key;
            $classRoom->duration    =  $request->duration;
            $classRoom->date        =  $request->date;
            $classRoom->start_time  =  $request->start_time;
            $classRoom->end_time    =  $request->end_time;
            $classRoom->note = strip_tags($request->note);
            $classRoom->created_by  =  Auth::id();
            $classRoom->save();

            return redirect()->route('admin.class-rooms.index')
                ->with('t-success', 'New class room added successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $classroom = ClassRoom::findOrFail($id);
            $batchId = $classroom->batch_id;
            $subjectId = $classroom->subject_id;
            $batch = Batch::where('id', $batchId)->first(['id','name']);
            $subject= Subject::where('id', $subjectId)->first(['id','name']);;
            return view('dashboard.classrooms.show', compact('classroom', 'batch', 'subject'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassRoom $classRoom)
    {
        try {
            // $batches = Batch::select('id', 'name', 'status')->get();
            // $batchId = $classRoom->batch_id;
            // $subjectId = json_decode(Batch::where('id', $batchId)->first()->subject_id);
            // $subjects = Subject::whereIn('id', $subjectId)->get();

            $data = new Batch();
//            dd($data);
            $batches = $data->select('id', 'name', 'status')->get();
            $subjectId = json_decode($data->where('id', $classRoom->batch_id)->first()->subject_id);
            $subjects = Subject::whereIn('id', $subjectId)->get();

            return view('dashboard.classrooms.edit', compact('batches', 'subjects', 'classRoom'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassRoom $classRoom)
    {
        // Validation check
        $this->validate($request, [
            'batch_id'    => 'required|integer',
            'subject_id'    => 'required|integer',
            'class_type'  => 'required|string',
            'class_link'  => 'nullable|string',
            'access_key'  => 'nullable|string',
            'duration'    => 'required|string',
            'start_time'  => 'required|string',
            'end_time'    => 'required|string'
        ]);

        try {
            $classRoom->batch_id = $request->batch_id;
            $classRoom->subject_id = $request->subject_id;
            $classRoom->class_type = $request->class_type;
            if ($request->class_type == 1){
                $classRoom->class_link = NUll;
                $classRoom->access_key = NUll;
            }else{
                $classRoom->class_link = $request->class_link;
                $classRoom->access_key = $request->access_key;
            }
            $classRoom->duration = $request->duration;
            $classRoom->start_time = $request->start_time;
            $classRoom->end_time = $request->end_time;
            $classRoom->updated_by = Auth::id();
            $classRoom->update();

            return redirect()->route('admin.class-rooms.index')
                ->with('t-success', 'New class room updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassRoom  $classRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassRoom $classRoom)
    {
        try {
            $classRoom->delete();

            return response()->json([
                'success' => true,
                'message' => 'Class Room Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Class room change status active or inactive.
     *
     * @param  mixed $subject
     * @return void
     */

    public function changeStatus(ClassRoom $classRoom)
    {
        try {
            if ($classRoom->status == 1) {
                $classRoom->status = 0;
                $classRoom->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Class room inactivated successfully',
                ]);
            }

            $classRoom->status = 1;
            $classRoom->update();

            return response()->json([
                'success' => true,
                'message' => 'Class room activated successfully',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
