<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FrontEndController extends Controller
{
    public function index(){
        $batches = Batch::with('subjects')->where('status', 1)->get();
        $teachers = Teacher::where('status', 1)->get();
        $setting = Setting::all()->first();
        return view('welcome',compact('batches','teachers','setting'));
    }

    public function contactStore(Request $request){
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ],
        [
            'name.required'=>'please enter your name',
            'phone.required'=>'please enter your phone number',
            'email.email'=>'enter a valid email address',
            'subject.email'=>'please enter a subject',
            'email.required'=>'Please enter email address',
            'message.required'=>'Please enter your message',
        ]);

        $contact=new Contact();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return redirect()->back();
    }

    public function getList()
    {
        try {
            $data = Contact::select('id', 'name', 'phone', 'email', 'subject','message')
                ->orderBy('id', 'DESC')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    return '<div class = "btn-group">'.$deleteButton.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function messages(){
        try {
            return view('frontend.contact');
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function messageDelete($id)
    {
        try {
            $message = Contact::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Message Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
