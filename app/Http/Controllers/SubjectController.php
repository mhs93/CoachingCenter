<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use PDF;
use Illuminate\Http\Request;
use App\Exports\ExportSubject;
use App\Imports\ImportSubject;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:subject_modify')->except(['index','getList','show']);
    }

    public function getList()
    {
        try {
            $data = Subject::select('id', 'name', 'code', 'fee', 'status')
                ->orderBy('id', 'DESC')->get();;

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if(Auth::user()->can('subject_modify')){
                        $button = ' <div class="form-check form-switch">';
                        $button .= ' <input onclick="statusConfirm(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                        return $button;
                    }else {
                        if ($data->status == 1) {
                            return '<div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" onclick="return false;"  checked />
                                    </div>';
                        } else {
                            return '<div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" readonly />
                                    </div>';
                        }
                        $button = ' <div class="form-check form-switch">';
                        $button .= ' <input onclick="statusConfirm(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                    }
                })
                ->addColumn('action', function ($data) {
                    if (Auth::user()->can('subject_list')){
                        $showButton = '<a href="javascript:void(0)" onclick="show(' . $data->id . ')" class="btn btn-sm btn-info text-white" title="Show"><i class="bx bxs-low-vision"></i></a>';
                    }else{
                        $showButton = '';
                    }
                    if(Auth::user()->can('subject_modify')){
                        $editButton = '<a href="javascript:void(0)" onclick="edit(' . $data->id . ')" class="btn btn-sm btn-warning" data-coreui-toggle="modal" data-coreui-target="#modalCollapse"><i class="bx bxs-edit-alt"></i></a>';
                    }else{
                        $editButton =  '';
                    }

                    if(Auth::user()->can('subject_modify')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    return '<div class = "btn-group">'.$showButton.$editButton.$deleteButton.'</div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function index()
    {
        try {
            return view('dashboard.subjects.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create(){
        return view('dashboard.subjects.create');
    }

    public function store(Request $request)
    {
        $messages = array(
            'fee.numeric'  => 'Subject fee can not be string, Please give numeric number',
        );
        $this->validate($request, array(
            'name'      =>      'required|string|unique:subjects,name,NULL,id,deleted_at,NULL',
            'code'      =>      'required|unique:subjects,code,NULL,id,deleted_at,NULL',
            'note'      =>      'nullable|max:255',
            'fee'       =>      'required|numeric',
        ), $messages);

        try {
            $subject             =   new Subject();
            $subject->name       =   $request->name;
            $subject->code       =   $request->code;
            $subject->note       =   strip_tags($request->note);
            $subject->fee        =   $request->fee;
            $subject->created_by =   Auth::id();
            $subject->save();
            return redirect()->route('admin.subjects.index')->with('t-success','Subject created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    /**
     * Show edit page
     *
     * @param  mixed $subject
     * @return void
     */

    public function edit(Subject $subject)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $subject,
                'message' => 'Subject edit data get successfully',
            ]);
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update batch data
     *
     * @param  mixed $request
     * @return void
     */

    public function update(Request $request)
    {
        //dd($request->all());
        // $this->validate($request, [
        //     'name'  =>  'required|string|unique:subjects,name,' . $subject->id . ',id,deleted_at,NULL',
        //     'code'  =>  'required|string|unique:subjects,code,' . $subject->id . ',id,deleted_at,NULL',
        //     'note'  =>  'nullable|max:255',
        //     'fee'   =>  'required',
        //     // 'status'    =>      'required|integer'
        // ]);

        try {
            $subject = Subject::find($request->id);
            $subject->name = $request->name;
            $subject->code = $request->code;
            $subject->note = $request->note;
            $subject->fee = $request->fee;
            $subject->updated_by = Auth::id();
            $subject->update();
            return response()->json([
                'success' => true,
                'message' => 'Subject Updated Successfully.',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete batch from database
     *
     * @param  mixed $subject
     * @return void
     */

    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return response()->json([
                'success' => true,
                'message' => 'Announcement Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Subject change status active or inactive.
     *
     * @param  mixed $subject
     * @return void
     */

    public function changeStatus(Subject $subject)
    {
        try {
            if($subject->status == 1) {
                $subject->status = 0;
                $subject->update();
                return response()->json([
                    'success' => true,
                    'message' => 'Subject inactivated successfully',
                ]);
            }
            $subject->status = 1;
            $subject->update();
            return response()->json([
                'success' => true,
                'message' => 'Subject activated successfully',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function importView(Request $request){
        return view('dashboard.subjects.index');
    }

    public function importSubjects(Request $request){
        Excel::import(new ImportSubject, request()->file('file'));
        return redirect()->back()->with('message','Subject imported successfully');
    }

    public function exportSubjects(Request $request){
        return Excel::download(new ExportSubject, 'subjects.xlsx');
    }

    public function print(){
        $subjects = Subject::get();
        return view('dashboard.subjects.print', compact('subjects') );
    }

    public function pdf(){
        $subjects = Subject::get();
        $pdf = PDF::loadView('dashboard.subjects.pdf', compact('subjects') );
        return $pdf->download('subjectList.pdf');
    }
}
