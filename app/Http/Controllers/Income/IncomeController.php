<?php

namespace App\Http\Controllers\Income;

use PDF;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Income;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller
{
    public function getlist(){
        try {
            $data = Income::with('account')->select('id','income_source','account_id','amount','payment_type','cheque_number','created_at')
                ->orderBy('id', 'DESC')
                ->get();

            return DataTables::of($data)->addIndexColumn()

                ->addColumn('created_at',function ($data){
                    return $data->created_at->format('d-m-Y');
                })
                ->addColumn('account',function ($data){
                    if($data->account_id){
                        if ($data->account_id == 1){
                            return 'cash account';
                        }else{
                            return $data->account->account_no;
                        }
                    }else{
                        return 'Deleted';
                    }
                    // if ($data->account_id == 1){
                    //     return 'cash account';
                    // }else{
                    //     return $data->account->account_no;
                    // }
                })
                ->addColumn('payment_type',function ($data){
                    if ($data->payment_type == 1){
                        return 'Cheque';
                    }else{
                        return 'Cash';
                    }
                })
                ->addColumn('cheque_number',function ($data){
                    if ($data->cheque_number == NULL){
                        return '--';
                    }else{
                        return $data->cheque_number;
                    }
                })
                ->addColumn('action', function ($data) {
                    if (Auth::user()->can('income_manage')){
                        $showDetails = '<a href="javascript:void(0)" onclick="show(' . $data->id . ')" class="btn btn-sm btn-info text-white" title="Show"><i class="bx bxs-low-vision"></i></a>';
                        // $showDetails = '<a href="' . route('admin.income.show', $data->id) . '" class="btn btn-sm btn-info" title="Show"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showDetails = '';
                    }
                    if (Auth::user()->can('income_manage')){
                        $incomeEdit = '<a href="' . route('admin.income.edit', $data->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class=\'bx bx-edit\'></i></a>';
                    }else{
                        $incomeEdit = '';
                    }
                    if (Auth::user()->can('income_manage')){
                        $incomePrint = '<a href="' . route('admin.income.print', $data->id) . '" class="btn btn-sm btn-info" title="Print"><i class=\'bx bxs-printer\'></i></a>';
                    }else{
                        $incomePrint = '';
                    }
                    if (Auth::user()->can('income_manage')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    return '<div class = "btn-group">'.$showDetails.$incomeEdit.$incomePrint.$deleteButton.'</div>';
                })

                ->rawColumns(['account', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.income.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::where('account_no','!=','cash')->get();
        return view('dashboard.income.create',compact('accounts'));
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
            'income_source' => 'required|string',
            'amount'        => 'required|integer',
            'payment_type'  => 'required',
            'account_id'    => 'nullable',
            'note'          => 'nullable|string',
            'cheque_number' => 'nullable|string'
        ]);

        try{
            DB::beginTransaction();
            $income = new Income();
            $income->income_source = $request->income_source;
            $income->amount = $request->amount;
            $income->payment_type = $request->payment_type;
            if ($income->payment_type == 1){
                $income->account_id = $request->account_id;
                $income->cheque_number = $request->cheque_number;
            }else{
                $income->account_id = 1;
                $income->cheque_number = NULL;
            }
            $income->note = $request->note;
            $income->created_by = Auth::id();
            $income->save();

            $transaction = new Transaction();
            $transaction->date = Carbon::now();
            $transaction->transaction_type = '1';
            $transaction->income_id = $income->id;
            $transaction->amount = $request->amount;
            $transaction->payment_type = $request->payment_type;
            if ($transaction->payment_type == 1){
                $transaction->account_id = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }else{
                $transaction->account_id = 1;
                $transaction->cheque_number = NULL;
            }
            $transaction->note = $request->note;
            $transaction->created_by = Auth::id();
            $transaction->save();
            DB::commit();
            return redirect()->route('admin.income.index')->with('t-success','Income Created successfully');
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
        $income = Income::findOrFail($id);
        return response()->json([
            'success' => true,
            'data'    => $income,
        ]);
        // return view('dashboard.income.show',compact('income'));
    }

    public function print($id)
    {
        $data = Income::findOrFail($id);
        return view('dashboard.income.print',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income = Income::findOrFail($id);
        $accounts = Account::all();
        return view('dashboard.income.edit',compact('income','accounts'));
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
            'income_source'     =>      'required|string',
            'amount'            =>      'required|integer',
            'payment_type'      =>      'required',
            'account_id'        =>      'nullable',
            'note'              =>      'nullable|string',
            'cheque_number'     =>      'nullable|string'
        ]);

        try{
            DB::beginTransaction();
            $income = Income::findOrFail($id);
            $transaction = Transaction::where('income_id',$request->id)->first();

            $income->income_source = $request->income_source;
            $income->amount = $request->amount;
            $income->payment_type = $request->payment_type;
            if ($request->payment_type == 1){
                $income->account_id = $request->account_id;
                $income->cheque_number = $request->cheque_number;
            }else{
                $income->account_id = 1;
                $income->cheque_number = NULL;
            }
            $income->note = $request->note;
            $income->created_by = Auth::id();
            $income->update();

            $transaction->date = Carbon::now();
            $transaction->transaction_type = '1';
            $transaction->income_id = $income->id;
            $transaction->amount = $request->amount;
            $transaction->payment_type = $request->payment_type;
            if ($transaction->payment_type == 1){
                $transaction->account_id = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }else{
                $transaction->account_id = 1;
                $transaction->cheque_number = NULL;
            }
            $transaction->note = $request->note;
            $transaction->created_by = Auth::id();
            $transaction->update();
            DB::commit();
            return redirect()->route('admin.income.index')->with('t-success','Income Updated Successfully');
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
    public function destroy($id)
    {
        try {
            $income = Income::findOrFail($id)->delete();
            $transaction = Transaction::where('income_id',$id)->delete();
            $income->deleted_by = Auth::id();
            return response()->json([
                'success' => true,
                'message' => 'Income Deleted Successfully',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }

    public function allPrint(){
        $incomes = Income::get();
        return view('dashboard.income.all-print', compact('incomes') );
    }

    public function pdf(){
        $incomes = Income::get();
        $pdf = PDF::loadView('dashboard.income.pdf', compact('incomes') );
        return $pdf->download('Income List.pdf');
    }
}
