<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function getlist(){
        try {
            $data = Expense::with('account')->select('id','expense_purpose','account_id','amount','payment_type','cheque_number','created_at')
                ->orderBy('id', 'DESC')
                ->get();

            return DataTables::of($data)->addIndexColumn()

                ->addColumn('account',function ($data){
                    if ($data->account_id == 0){
                        return 'cash account';
                    }else{
                        return $data->account->account_no;
                    }
                })
                ->addColumn('payment_type',function ($data){
                    if ($data->payment_type == 1){
                        return 'Cheque';
                    }else{
                        return 'Cash';
                    }
                })
                ->addColumn('action', function ($data) {
                    if (Auth::user()->can('expense_show')){
                        $showDetails = '<a href="' . route('admin.expense.show', $data->id) . '" class="btn btn-sm btn-info" title="Show"><i class=\'bx bxs-low-vision\'></i></a>';
                    }else{
                        $showDetails = '';
                    }
                    if (Auth::user()->can('expense_edit')){
                        $expenseEdit = '<a href="' . route('admin.expense.edit', $data->id) . '" class="btn btn-sm btn-info" title="Edit"><i class=\'bx bx-edit\'></i></a>';
                    }else{
                        $expenseEdit = '';
                    }
                    if (Auth::user()->can('expense_delete')){
                        $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                    }else{
                        $deleteButton = '';
                    }
                    return '<div class = "btn-group">'.$showDetails.$expenseEdit.$deleteButton.'</div>';
                })

                ->rawColumns(['account', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function index()
    {
        return view('dashboard.expense.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::all();
        return view('dashboard.expense.create',compact('accounts'));
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
            'expense_purpose' => 'required|string',
            'amount' => 'required|integer',
            'payment_type' => 'required',
            'account_id' => 'nullable|integer',
            'note' => 'nullable|string',
            'cheque_number' => 'nullable|string'
        ]);

        try{
            DB::beginTransaction();
            $expense = new Expense();
            $expense->expense_purpose = $request->expense_purpose;
            $expense->amount = $request->amount;
            $expense->payment_type = $request->payment_type;
            if ($expense->payment_type == 1){
                $expense->account_id = $request->account_id;
                $expense->cheque_number = $request->cheque_number;
            }else{
                $expense->account_id = 0;
                $expense->cheque_number = NULL;
            }
            $expense->note = $request->note;
            $expense->created_by = Auth::id();
            $expense->save();

            $transaction = new Transaction();
            $transaction->date = Carbon::now();
            $transaction->transaction_type = 2;
            $transaction->expense_id = $expense->id;
            $transaction->amount = $request->amount;
            $transaction->payment_type = $request->payment_type;
            if ($transaction->payment_type == 1){
                $transaction->account_id = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }else{
                $transaction->account_id = 0;
                $transaction->cheque_number = NULL;
            }
            $transaction->note = $request->note;
            $transaction->created_by = Auth::id();
            $transaction->save();
            DB::commit();
            return redirect()->route('admin.expense.index')->with('t-success','expense created successfully');
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
        $expense = Expense::findOrFail($id);
        return view('dashboard.expense.show',compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $accounts = Account::all();
        return view('dashboard.expense.edit',compact('expense','accounts'));
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
            'expense_purpose' => 'required|string',
            'amount' => 'required|integer',
            'payment_type' => 'required',
            'account_id' => 'nullable|integer',
            'note' => 'nullable|string',
            'cheque_number' => 'nullable|string'
        ]);

        try{
            DB::beginTransaction();
            $expense = Expense::findOrFail($id);
            $transaction = Transaction::where('expense_id',$request->id)->first();

            $expense->expense_purpose = $request->expense_purpose;
            $expense->amount = $request->amount;
            $expense->payment_type = $request->payment_type;
            if ($request->payment_type == 1){
                $expense->account_id = $request->account_id;
                $expense->cheque_number = $request->cheque_number;
            }else{
                $expense->account_id = 0;
                $expense->cheque_number = NULL;
            }
            $expense->note = $request->note;
            $expense->created_by = Auth::id();
            $expense->update();

            $transaction->date = Carbon::now();
            $transaction->transaction_type = 2;
            $transaction->expense_id = $expense->id;
            $transaction->amount = $request->amount;
            $transaction->payment_type = $request->payment_type;
            if ($transaction->payment_type == 1){
                $transaction->account_id = $request->account_id;
                $transaction->cheque_number = $request->cheque_number;
            }else{
                $transaction->account_id = 0;
                $transaction->cheque_number = NULL;
            }
            $transaction->note = $request->note;
            $transaction->created_by = Auth::id();
            $transaction->update();
            DB::commit();
            return redirect()->route('admin.expense.index')->with('t-success','expense updated successfully');
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
            $expense = Expense::findOrFail($id)->delete();
            $transaction = Transaction::where('expense_id',$id)->delete();
            $expense->deleted_by = Auth::id();
            return response()->json([
                'success' => true,
                'message' => 'Expense deleted successfully',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '$e');
        }
    }
}
