<?php

namespace App\Http\Controllers\TchPayment;

use App\Http\Controllers\Controller;
use App\Models\Tchpayment;
use App\Models\Account;
use App\Models\Teacher;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TchpaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $teacher = Teacher::findOrFail($id);
        $tchpayments = Tchpayment::where('tch_id', $id)->with('account')->get();
        return view('dashboard.tch_payment.index',compact('teacher','tchpayments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $teacher = Teacher::findOrFail($id);
        $accounts = Account::all();
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
            'month' => 'required|string',
            'additional_amount' => 'integer|nullable',
            'discount_amount' => 'integer|nullable',
            'payment_type' => 'required|integer',
            'cheque_number' => 'nullable|string|unique:stdpayments,cheque_number,NULL,id,deleted_at,NULL',
            'total_amount' => 'required|integer',
            'note' => 'nullable|max:255',
        ]);
        try{
            DB::beginTransaction();
            $tchpayment = new Tchpayment();
            $tchpayment->tch_id = $request->tch_id;
            $tchpayment->month = $request->month;
            $tchpayment->additional_amount = $request->additional_amount;
            $tchpayment->discount_amount = $request->discount_amount;
            $tchpayment->payment_type = $request->payment_type;
            if ($tchpayment->payment_type == 1){
                $tchpayment->account_id = $request->account_id;
                $tchpayment->cheque_number = $request->cheque_number;
            }elseif ($tchpayment->payment_type == 2){
                $tchpayment->account_id = 0;
            }
            $tchpayment->total_amount = $request->total_amount;
            $tchpayment->note = $request->note;
            $tchpayment->created_by = Auth::id();
            $tchpayment->save();

            $transaction = new Transaction();
            $transaction->date = Carbon::now();
            $transaction->tchpayment_id = $tchpayment->id;
            $transaction->transaction_type = '2';
            $transaction->amount = $request->total_amount;
            $transaction->payment_type = $request->payment_type;
            if ($transaction->payment_type == 1){
                $transaction->account_id = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }elseif ($transaction->payment_type == 2){
                $transaction->account_id = 0;
            }
            $transaction->note = $request->note;
            $transaction->created_by = Auth::id();
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
        $accounts = Account::all();
        return view('dashboard.tch_payment.edit',compact( 'tchpayment','accounts'));
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
            'month' => 'required|string',
            'additional_amount' => 'integer|nullable',
            'discount_amount' => 'integer|nullable',
            'payment_type' => 'required|integer',
            'cheque_number' => 'nullable|string|unique:tchpayments,cheque_number,' . $request->id . ',id,deleted_at,NULL',
            'total_amount' => 'required|integer',
            'note' => 'nullable|max:255',
        ]);
        try{
            DB::beginTransaction();
            $transaction = Transaction::where('tchpayment_id', $request->id)->first();

            $tchpayment = Tchpayment::findOrFail($id);
            $tchpayment->month = $request->month;
            $tchpayment->additional_amount = $request->additional_amount;
            $tchpayment->discount_amount = $request->discount_amount;
            $tchpayment->payment_type = $request->payment_type;
            if ($request->payment_type == 2){
                $tchpayment->cheque_number = NULL;
            }else{
                $tchpayment->cheque_number = $request->cheque_number;
            }
            $tchpayment->account_id = $request->account_id;
            $tchpayment->total_amount = $request->total_amount;
            $tchpayment->note = $request->note;
            $tchpayment->updated_by = Auth::id();
            $tchpayment->update();

            $transaction->date = Carbon::now();
            $transaction->tchpayment_id = $tchpayment->id;
            $transaction->transaction_type = '2';
            $transaction->amount = $request->total_amount;
            $transaction->payment_type = $request->payment_type;
            if ($transaction->payment_type == 1){
                $transaction->account_id = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }elseif ($transaction->payment_type == 2){
                $transaction->account_id = 0;
            }
            $transaction->note = $request->note;
            $transaction->created_by = Auth::id();
            $transaction->update();

            DB::commit();
            return redirect()->route('admin.teacher.payment', $tchpayment->tch_id)->with('t-success','payment updated successfully');

        }catch (\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
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
}
