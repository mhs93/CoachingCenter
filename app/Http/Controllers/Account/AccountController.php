<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('bank')->orderBy('id')->get();
//        dd($accounts);
        $banks = Bank::all();
        return view('dashboard.account.accountindex',compact('accounts','banks'));
    }

    public function create()
    {
        $banks = Bank::all();
        return view('dashboard.account.accountcreate',compact('banks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'account_no' => 'required|string',
            'account_holder' => 'required|string',
            'bank_id' => 'required',
            'branch_name' => 'required|string',
            'initial_balance' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            // Account Store
            $account = new Account();
            $account->account_no = $request->account_no;
            $account->account_holder = $request->account_holder;
            $account->bank_id = $request->bank_id;
            $account->branch_name = $request->branch_name;
            $account->description = $request->description;
            $account->created_by = Auth::user()->id;
            $account->save();

            // Initial Balance Store in Transaction
            $transaction = new Transaction();
            $transaction->date = Carbon::now();
            $transaction->account_id = $account->id;
            $transaction->transaction_type = 2;
            $transaction->amount = $request->initial_balance;;
            $transaction->payment_type = $request->payment_type;
            $transaction->cheque_number = $request->cheque_number;
            $transaction->cash_details = $request->cash_details;
            $transaction->purpose = 5;
            $transaction->remarks = 'No';
            $transaction->save();

            DB::commit();
            return redirect()->route('admin.account.index')->with('t-success','account created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $banks = Bank::all();
        return view('dashboard.account.accountedit',compact('account','banks'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'account_no' => 'required|string',
            'account_holder' => 'required|string',
            'bank_id' => 'required|string',
            'branch_name' => 'required|string',
        ]);

        try {
            $account =  Account::findOrFail($request->id);
            $account->account_no = $request->account_no;
            $account->account_holder = $request->account_holder;
            $account->bank_id = $request->bank_id;
            $account->branch_name = $request->branch_name;
            $account->description = $request->description;
            $account->updated_by = Auth::user()->id;
            $account->save();
            return redirect()->route('admin.account.index')->with('t-success','account updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Account $account)
    {
        DB::beginTransaction();
        try {
            Transaction::where('account_id',$account->id)->delete();
            Account::where('id',$account->id)->delete();
            DB::commit();
            return redirect()->back()->with('t-success','account deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}
