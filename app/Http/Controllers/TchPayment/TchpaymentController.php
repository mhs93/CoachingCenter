<?php

namespace App\Http\Controllers\TchPayment;

use App\Http\Controllers\Controller;
use App\Models\Tchpayment;
use App\Models\Account;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Termwind\ValueObjects;

class TchpaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:payment_manage')->except(['installments','show']);
    }
    public function index($id)
    {
        $teacher = Teacher::findOrFail($id);
        $tchpayments = Tchpayment::where('tch_id', $id)->with('account')->get();
        $month = Carbon::now()->format('Y-m');
        $tchpaymentmonth = Tchpayment::where('tch_id',$id)->where('month',$month)->with('account')->first();
        if ($tchpaymentmonth != NULL){
            if ($tchpaymentmonth->month == $month){
//            $dueAmount = $teacher->monthly_fee - $tchpaymentmonth->total_amount;
                $dueAmount = 0;
            }else{
                $dueAmount = $teacher->monthly_fee;
            }
        }else{
            $dueAmount = 'No payment yet';
        }
        return view('dashboard.tch_payment.index',compact('teacher','tchpayments','dueAmount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $teacher = Teacher::findOrFail($id);
        $accounts = Account::where('account_no','!=','cash')->get();
        return view('dashboard.tch_payment.create',compact('teacher', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        if($request->total_amount > $request->current_balance){
            return redirect()->back()->with('error', "Don't have enough balance");
        }

        try{
            DB::beginTransaction();
            $tchpayment                     = new Tchpayment();
            $tchpayment->tch_id             = $request->tch_id;
            $tchpayment->month              = $request->month;
            $tchpayment->adjustment_type    = $request->adjustment_type;
            $tchpayment->adjustment_balance = $request->adjustment_balance;
            $tchpayment->adjustment_cause   = $request->adjustment_cause;
            $tchpayment->payment_type       = $request->payment_type;
            if ($tchpayment->payment_type   == 1){
                $tchpayment->account_id     = $request->account_id;
                $tchpayment->cheque_number  = $request->cheque_number;
            }elseif ($tchpayment->payment_type == 2){
                $tchpayment->account_id     = 1;
            }
            $tchpayment->total_amount = $request->total_amount;
            $tchpayment->note         = $request->note;
            $tchpayment->created_by   = Auth::id();
            $tchpayment->save();

            $transaction                    = new Transaction();
            $transaction->date              = Carbon::now();
            $transaction->tchpayment_id     = $tchpayment->id;
            $transaction->transaction_type  = '2';
            $transaction->amount            = $request->total_amount;
            $transaction->payment_type      = $request->payment_type;
            if ($transaction->payment_type  == 1){
                $transaction->account_id    = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }elseif ($transaction->payment_type == 2){
                $transaction->account_id    = 1;
            }
            $transaction->note              = $request->note;
            $transaction->created_by        = Auth::id();
            $transaction->save();

            DB::commit();
            return redirect()->route('admin.teacher.payment', $request->tch_id)->with('t-success','payment created successfully');
        }catch (\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $details = Tchpayment::findOrFail($id);
        return view('dashboard.tch_payment.show',compact('details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tchpayment = Tchpayment::findOrFail($id);
        $accounts   = Account::all();
        $balance    = $tchpayment->adjustment_balance;
        return view('dashboard.tch_payment.edit',compact( 'tchpayment','accounts','balance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'month'              => 'required|string',
            'adjustment_type'    => 'nullable|integer',
            'adjustment_balance' => 'nullable|string',
            'adjustment_cause'   => 'nullable|string',
            'payment_type'       => 'required|integer',
            'cheque_number'      => 'nullable|string|unique:tchpayments,cheque_number,' . $request->id . ',id,deleted_at,NULL',
            'total_amount'       => 'required|integer',
            'note'               => 'nullable|max:255',
        ]);
        try{
            DB::beginTransaction();
            $transaction = Transaction::where('tchpayment_id', $request->id)->first();

            $tchpayment                     = Tchpayment::findOrFail($id);
            $tchpayment->month              = $request->month;
            $tchpayment->adjustment_type    = $request->adjustment_type;
            $tchpayment->adjustment_balance = $request->adjustment_balance;
            $tchpayment->adjustment_cause   = $request->adjustment_cause;
            $tchpayment->payment_type       = $request->payment_type;
            if ($request->payment_type == 2){
                $tchpayment->cheque_number  = NULL;
            }else{
                $tchpayment->cheque_number  = $request->cheque_number;
            }
            $tchpayment->account_id         = $request->account_id;
            $tchpayment->total_amount       = $request->total_amount;
            $tchpayment->note               = $request->note;
            $tchpayment->updated_by         = Auth::id();
            $tchpayment->update();

            $transaction->date              = Carbon::now();
            $transaction->tchpayment_id     = $tchpayment->id;
            $transaction->transaction_type  = '2';
            $transaction->amount            = $request->total_amount;
            $transaction->payment_type      = $request->payment_type;
            if ($transaction->payment_type  == 1){
                $transaction->account_id    = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }elseif ($transaction->payment_type == 2){
                $transaction->account_id    = 1;
            }
            $transaction->note              = $request->note;
            $transaction->created_by        = Auth::id();
            $transaction->update();

            DB::commit();
            return redirect()->route('admin.teacher.payment', $tchpayment->tch_id)->with('t-success','payment updated successfully');

        }catch (\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function tchprint($id){
//        dd($id);
        $data = Tchpayment::findOrFail($id);
        return view('dashboard.tch_payment.print',compact('data'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $tchpayment =Tchpayment::findOrFail($id);
            $tchpayment->deleted_by = Auth::id();
            $tchpayment->save();
            $tchpayment->delete();

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
        $id = User::select('teacher_id')->where('id', Auth::id())->first();
        $tchId=$id->teacher_id;
        $teacher = Teacher::findOrFail($tchId);
        $tchpayments = Tchpayment::where('tch_id', $tchId)->with('account')->get();
        $month = Carbon::now()->format('Y-m');
        $tchpaymentmonth = Tchpayment::where('tch_id', $tchId)->where('month', $month)->with('account')->first();

//        dd($tchpaymentmonth);
        if ($tchpaymentmonth != NULL){
            if ($tchpaymentmonth->month == $month){
                $dueAmount = '0 tk';
            }else{
                $dueAmount = $teacher->monthly_fee;
            }
        }else{
            $dueAmount = 'No payment yet';
        }
        return view('dashboard.tch_payment.index',compact('teacher','tchpayments','dueAmount'));
    }
}
