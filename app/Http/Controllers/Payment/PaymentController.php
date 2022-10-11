<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Paymentcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payments=Payment::all();
        return view('dashboard.payments.index',compact('payments'));
    }

    public function create()
    {
        return view('dashboard.payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reg_no'=>'required|string',
            'amount'=>'required|string',
            'paid_amount'=>'required|string',
            'due_amount'=>'required|string',
        ]);
        $payment=new Payment();
        $payment->reg_no = $request->reg_no;
        $payment->amount = $request->amount;
        $payment->paid_amount = $request->paid_amount;
        $payment->due_amount = $request->due_amount;

        $payment->save();
        return redirect()->route('admin.payments.index')->with('success','Payment Added Successfully');
    }

    public function show(payment $payment)
    {
        //
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('dashboard.payments.edit',compact('payment'));
    }

    public function update(Request $request, payment $payment)
    {
        $request->validate([
        'reg_no'=>'required|string',
        'amount'=>'required|string',
        'paid_amount'=>'required|string',
        'due_amount'=>'required|string',
    ]);
        Payment::where('id',$request->id)->update([
            'reg_no' => $request->reg_no,
            'amount' => $request->amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount,
        ]);
        return redirect()->route('admin.payments.index')->with('success','payment Updated successfully');
    }
    
    public function destroy(payment $payment)
    {
        $payment = Payment::where('id',$payment->id)->delete();
        return redirect()->back()->with('success', 'Payment Deleted Successfully');
    }

    public function categoryList(){
        $categorys = Paymentcategory::all();
        return view('dashboard.payments.category', compact('categorys'));
    }
    public function categoryCreate(){
        return view('dashboard.payments.create_category');
    }
    public function categoryStore(Request $request){
        $request->validate([
            'cat_name'=> 'required|string',
            'amount' => 'required|string',
        ]);
        $cat = new Paymentcategory();
        $cat->cat_name = $request->cat_name;
        $cat->amount = $request->amount;
        $cat->save();
        return redirect()->route('admin.category.list')->with('success','Category created successfully');
    }

    public function catEdit($id)
    {
        $cat = Paymentcategory::findOrFail($id);
        return view('dashboard.payments.edit_category',compact('cat'));
    }

    public function catUpdate(Request $request){
        $request->validate([
            'cat_name'=>'required|string',
            'amount'=>'required|string',
        ]);
        Paymentcategory::where('id',$request->id)->update([
            'cat_name' => $request->cat_name,
            'amount' => $request->amount,
        ]);
        return redirect()->route('admin.category.list')->with('success','updated successfully');
    }
    public function catDelete(Paymentcategory $paymentcategory){
        $payment = Paymentcategory::where('id', $paymentcategory->id)->delete();
        return redirect()->back()->with('success','payment category deleted successfully');
    }
}
