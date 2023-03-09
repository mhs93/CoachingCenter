<?php

namespace App\Http\Controllers\StudentPayment;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Carbon\Carbon;
use App\Models\Stdpayment;
use App\Models\Student;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StdpaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:payment_manage')->except(['installments','show']);
    }

    public function index($id)
    {
        $student = Student::with('batch')->findOrFail($id);
        $stdpayments = Stdpayment::where('std_id', $id)->with('account')->get();
        $month = Carbon::now()->format('Y-m');
        $stdpaymentmonth = Stdpayment::where('std_id', $id)->where('month', $month)->with('account')->first();


        if ($stdpaymentmonth != NULL){
            if ($stdpaymentmonth->month == $month){
//            $dueAmount = $student->monthly_fee - $stdpaymentmonth->total_amount;
                $dueAmount = 0;
            }else{
                $dueAmount = $student->monthly_fee;
            }
        }else{
            $dueAmount = 'No payment yet';
        }
        return view('dashboard.std_payment.index',compact('student','stdpayments','dueAmount'));
    }


    public function create($id)
    {
        $student = Student::findOrFail($id);
        $accounts = Account::where('account_no','!=','cash')->get();
        return view('dashboard.std_payment.create',compact('student', 'accounts'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'month'              => 'required|string',
            'adjustment_type'    => 'nullable|integer',
            'adjustment_balance' => 'nullable|string',
            'adjustment_cause'   => 'nullable|string',
            'payment_type'       => 'required|integer',
            'cheque_number'      => 'nullable|string|unique:stdpayments,cheque_number,NULL,id,deleted_at,NULL',
            'total_amount'       => 'required|integer',
            'note'               => 'nullable|max:255',
        ]);

        if($request->adjustment_type){
            $this->validate($request,[
                'adjustment_type'    => 'required|integer',
                'adjustment_balance' => 'required|string',
                'adjustment_cause'   => 'required|string',
            ]);
        }

        if($request->payment_type == 1){
            $this->validate($request,[
                'account_id'    => 'required|integer',
                'cheque_number' => 'required|string',
            ]);
        }

        try{
            DB::beginTransaction();
            $stdpayment = new Stdpayment();
            $stdpayment->std_id             = $request->std_id;
            $stdpayment->month              = $request->month;
            $stdpayment->adjustment_type    = $request->adjustment_type;
            $stdpayment->adjustment_balance = $request->adjustment_balance;
            $stdpayment->adjustment_cause   = $request->adjustment_cause;
            $stdpayment->payment_type       = $request->payment_type;
            if ($stdpayment->payment_type == 1){
                $stdpayment->account_id    = $request->account_id;
                $stdpayment->cheque_number = $request->cheque_number;
            }else{
                $stdpayment->account_id    = 1;
                $stdpayment->cheque_number = NULL;
            }
            $stdpayment->total_amount = $request->total_amount;
            $stdpayment->note         = $request->note;
            $stdpayment->created_by   = Auth::id();
            $stdpayment->save();

            $transaction = new Transaction();
            $transaction->date              = Carbon::now();
            $transaction->stdpayment_id     = $stdpayment->id;
            $transaction->transaction_type  = '1';
            $transaction->payment_type      = $request->payment_type;
            if ($transaction->payment_type  == 1){
                $transaction->account_id    = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }elseif ($transaction->payment_type == 2){
                $transaction->account_id    = 1;
            }
            $transaction->amount     = $request->total_amount;
            $transaction->note       = $request->note;
            $transaction->created_by = Auth::id();
            $transaction->save();

            DB::commit();
            return redirect()->route('admin.student.payment', $request->std_id)->with('t-success','payment created successfully');
        }catch (\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function show($id)
    {
        $details = Stdpayment::findOrFail($id);
        return view('dashboard.std_payment.show',compact('details'));
    }


    public function edit($id)
    {
        $stdpayment = Stdpayment::findOrFail($id);
        $accounts = Account::all();
        $balance = $stdpayment->adjustment_balance;
        return view('dashboard.std_payment.edit',compact( 'stdpayment','accounts','balance'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'month' => 'required|string',
            'additional_amount' => 'integer|nullable',
            'discount_amount' => 'integer|nullable',
            'payment_type' => 'required|integer',
            'cheque_number' => 'nullable|string|unique:stdpayments,cheque_number,' . $request->id . ',id,deleted_at,NULL',
            'total_amount' => 'required|integer',
            'note' => 'nullable|max:255',
        ]);
        try{
            DB::beginTransaction();
            $transaction = Transaction::where('stdpayment_id',$request->id)->first();

            $stdpayment = Stdpayment::findOrFail($id);
            $stdpayment->month = $request->month;
            $stdpayment->adjustment_type = $request->adjustment_type;
            $stdpayment->adjustment_balance = $request->adjustment_balance;
            $stdpayment->adjustment_cause = $request->adjustment_cause;
            $stdpayment->payment_type = $request->payment_type;
            if ($request->payment_type == 1){
                $stdpayment->account_id = $request->account_id;
                $stdpayment->cheque_number = $request->cheque_number;
            }else{
                $stdpayment->account_id = 1;
                $stdpayment->cheque_number = NULL;
            }
            $stdpayment->total_amount = $request->total_amount;
            $stdpayment->note = $request->note;
            $stdpayment->updated_by = Auth::id();
            $stdpayment->update();

            $transaction->date = Carbon::now();
            $transaction->stdpayment_id = $stdpayment->id;
            $transaction->transaction_type = '1';
            $transaction->payment_type = $request->payment_type;
            if ($transaction->payment_type == 1){
                $transaction->account_id = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }else{
                $transaction->account_id = 1;
                $transaction->cheque_number = NULL;
            }
            $transaction->amount = $request->total_amount;
            $transaction->note = $request->note;
            $transaction->updated_by = Auth::id();
            $transaction->update();

            DB::commit();
            return redirect()->route('admin.student.payment', $stdpayment->std_id)->with('t-success','payment updated successfully');

        }catch (\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function stdprint($id){
        $data = Stdpayment::findOrFail($id);
        return view('dashboard.std_payment.print',compact('data'));
    }


    public function delete($id)
    {
        try {
            $stdpayment =Stdpayment::findOrFail($id);
            $transaction = Transaction::where('stdpayment_id',$id)->delete();
            $stdpayment->deleted_by = Auth::id();
            $stdpayment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payment Deleted Successfully.',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function installments()
    {
        $id = User::select('student_id')->where('id', Auth::id())->first();

        $stdId=$id->student_id;
        $student = Student::with('batch')->findOrFail($id->student_id);
        $stdpayments = Stdpayment::where('std_id', $stdId)->with('account')->get();
        $month = Carbon::now()->format('Y-m');
        $stdpaymentmonth = Stdpayment::where('std_id', $stdId)->where('month', $month)->with('account')->first();

        if ($stdpaymentmonth != NULL){
            if ($stdpaymentmonth->month == $month){
                $dueAmount = '0 tk';
            }else{
                $dueAmount = $student->monthly_fee;
            }
        }else{
            $dueAmount = 'No payment yet';
        }
        return view('dashboard.std_payment.index',compact('student','stdpayments','dueAmount'));
    }
}
