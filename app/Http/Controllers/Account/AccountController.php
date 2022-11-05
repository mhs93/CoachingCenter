<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function getlist(Request $request){
        try {
            if($request->ajax()){
                $data = Account::select('account_no','account_holder','bank_name','branch_name','status')->orderBy('id', 'DESC')->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('balance',function ($data){
                            $balance = \App\Helper\Accounts::postBalance($data->id);
                            return $balance;
                    })
                    ->addColumn('status', function ($data) {
                        if (Auth::user()->can('account_edit')) {
                            $button = ' <div class="form-check form-switch">';
                            $button .= ' <input onclick="statusConfirm(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                            if ($data->status == 1) {
                                $button .= "checked";
                            }
                            $button .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';
                            return $button;
                        } else {
                            if ($data->status == 1) {
                                return '<div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" onclick="return false;"  checked />
                                        </div>';
                            } else {
                                return '<div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" readonly />
                                        </div>';
                            }
                        }
                    })
                    ->addColumn('action', function ($data) {
                        if (Auth::user()->can('account_edit')) {
                            $accountEdit = '<a href="'. route('admin.account.edit', $data->id) .'" class="btn btn-sm btn-info" title="Edit"><i class=\'bx bx-edit\'></i></a>';
                        } else {
                            $accountEdit = '';
                        }
                        if (Auth::user()->can('account_delete')) {
                            $deleteButton = '<a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>';
                        } else {
                            $deleteButton = '';
                        }
                        return '<div class = "btn-group">' . $accountEdit . $deleteButton . '</div>';
                    })
                    ->rawColumns(['balance', 'status', 'action'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        $accounts = Account::orderBy('id')->get();
        return view('dashboard.account.accountindex',compact('accounts'));
    }

    public function create()
    {
        return view('dashboard.account.accountcreate');
    }


    public function store(Request $request)
    {
        $request->validate([
            'account_no' => 'required|string',
            'account_holder' => 'required|string',
            'bank_name' => 'required|string',
            'branch_name' => 'required|string',
            'initial_balance' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
//            dd($request->all());
            $account = new Account();
            $account->account_no = $request->account_no;
            $account->account_holder = $request->account_holder;
            $account->bank_name = $request->bank_name;
            $account->branch_name = $request->branch_name;
            $account->description = $request->description;
            $account->created_by = Auth::user()->id;
            $account->save();

            $transaction = new Transaction();
            $transaction->date = Carbon::now();
            $transaction->account_id = $account->id;
            $transaction->transaction_type = 3;
            $transaction->amount = $request->initial_balance;
            $transaction->updated_by = Auth::user()->id;
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
        return view('dashboard.account.accountedit',compact('account'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'account_no' => 'required|string',
            'account_holder' => 'required|string',
            'bank_name' => 'required|string',
            'branch_name' => 'required|string',
        ]);

        try {
            $account =  Account::findOrFail($request->id);
            $account->account_no = $request->account_no;
            $account->account_holder = $request->account_holder;
            $account->bank_name = $request->bank_name;
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

    public function changeStatus(Account $account)
    {
        try {
            if($account->status == 1) {
                $account->status = 0;
                $account->update();

                return response()->json([
                    'success' => true,
                    'message' => 'account inactivated successfully',
                ]);
            }

            $account->status = 1;
            $account->update();

            return response()->json([
                'success' => true,
                'message' => 'account activated successfully',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Transaction::where('account_id',$id)->delete();
            Account::where('id',$id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'account deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '$e');
        }
    }
}
