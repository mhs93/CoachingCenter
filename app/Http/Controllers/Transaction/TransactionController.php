<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\Accounts;

class TransactionController extends Controller
{
    public function getList()
    {
        try {
            $data = Transaction::with('account')
                ->select('id', 'date', 'account_id', 'amount', 'purpose', 'remarks')
                ->orderBy('id', 'DESC')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('accountinfo', function ($data) {
                    return $data->account->account_no . '-' . $data->account->account_holder;
                })
                ->addColumn('purpose', function ($data) {
                    if ($data->purpose == 1) {
                        return '<span class="text-danger">Withdrow</span> ';
                    } elseif ($data->purpose == 2) {
                        return '<span class="text-green">Deposit</span> ';
                    } elseif ($data->purpose == 3) {
                        return '<span class="text-success">Received Payment</span> ';
                    } elseif ($data->purpose == 4) {
                        return '<span class="text-danger">Given Payment</span> ';
                    } elseif ($data->purpose == 5) {
                        return '<span class="text-green">Initial Balance</span> ';
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<div class = "btn-group">
                            <a href="' . route('admin.transaction.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class="bx bxs-edit-alt"></i></a>                           
                            <a class="btn btn-sm btn-danger text-white" onclick="showDeleteConfirm(' . $data->id . ')" title="Delete"><i class="bx bxs-trash"></i></a>
                        </div>';
                })
                ->rawColumns(['action', 'accountinfo', 'purpose'])
                ->make(true);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        try {
            return view('dashboard.transactions.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $accounts = Account::all();
            return view('dashboard.transactions.create', compact('accounts'));
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'account_id' => 'required|string',
            'amount' => 'required|string',
            'payment_type' => 'nullable',
            'cheque_number' => 'nullable',
            'cash_details' => 'nullable',
            'purpose' => 'required',
            'remarks' => 'required|string',
        ]);
        try {
            $transaction = new Transaction();
            $transaction->date = $request->date;
            $transaction->account_id = $request->account_id;

            if ($request->purpose == 1 || $request->purpose == 4) {
                $transaction->transaction_type = 1;
            } else {
                $transaction->transaction_type = 2;
            }
            $transaction->amount = $request->amount;
            $transaction->payment_type = $request->payment_type;
            $transaction->cheque_number = $request->cheque_number;
            $transaction->purpose = $request->purpose;
            $transaction->remarks = $request->remarks;
            $transaction->cash_details = $request->cash_details;
            $transaction->created_by = Auth::user()->id;
            $transaction->save();
            return redirect()->route('admin.transaction.index')->with('t-success', 'transaction created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            if($transaction->transaction_type == 1){
                $balance = Accounts::postBalance($transaction->account_id);
                $balance = $balance + $transaction->amount;
            }

            $accounts = Account::select('id', 'account_no')->get();
            return view('dashboard.transactions.edit', compact('transaction', 'accounts','balance'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'account_id' => 'required|string',
            'amount' => 'required|string',
            'payment_type' => 'nullable',
            'cheque_number' => 'nullable',
            'cash_details' => 'nullable',
            'purpose' => 'required|string',
            'remarks' => 'required|string',
        ]);

        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->date = $request->date;
            $transaction->account_id = $request->account_id;

            if ($request->purpose == 1 || $request->purpose == 4) {
                $transaction->transaction_type = 1;
            } else {
                $transaction->transaction_type = 2;
            }
            $transaction->amount = $request->amount;
            $transaction->payment_type = $request->payment_type;
            $transaction->cheque_number = $request->cheque_number;
            $transaction->purpose = $request->purpose;
            $transaction->remarks = $request->remarks;
            $transaction->cash_details = $request->cash_details;
            $transaction->created_by = Auth::user()->id;
            $transaction->save();

            return redirect()->route('admin.transaction.index')->with('t-success', 'transaction updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        Transaction::where('id', $transaction->id)->delete();
        return redirect()->back()->with('t-error', 'Transaction deleted successfully');
    }


    // Get Account Balance
    public function getAccountBalance(Request $request, $id)
    {
        if ($request->ajax()) {
            $balance = Accounts::postBalance($id);
            return response()->json($balance);
        }
    }
}