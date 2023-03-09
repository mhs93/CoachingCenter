<?php

namespace App\Http\Controllers\Transaction;

use PDF;
use Carbon\Carbon;
use App\Models\Batch;
use App\Models\Account;
use App\Models\Student;
use App\Models\Teacher;
use App\Helper\Accounts;
use App\Models\Stdpayment;
use App\Models\Tchpayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:payment_manage');
    }

    public function getList()
    {
        try {
            $data = Transaction::with('account')
                ->select('id', 'date', 'account_id', 'amount', 'transaction_type', 'payment_type','cheque_number')
                ->orderBy('id', 'DESC')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('date', function ($data) {
                    return $data->date->format('d-m-Y');
                })

                ->addColumn('account_id', function ($data) {
                    if($data->account_id == 0){
                        return 'Cash';
                    }else{
                        return $data->account->account_no . '-' . $data->account->account_holder;
                    }
                })
                ->addColumn('transaction_type', function ($data) {
                    if ($data->transaction_type == 1) {
                        return '<span class="text-success">Credit</span>';
                    } elseif ($data->transaction_type == 2) {
                        return '<span class="text-danger">Debit</span> ';
                    } elseif ($data->transaction_type == 3) {
                        return '<span class="text-info">Initial Balance</span> ';
                    }
                })
                ->addColumn('payment_type', function ($data) {
                    if ($data->payment_type == 1) {
                        return 'Cheque';
                    } elseif ($data->payment_type == 2) {
                        return 'Cash';
                    } else {
                        return '---';
                    }
                })
                ->addColumn('cheque_number', function ($data) {
                    if ($data->payment_type == 1) {
                        return '<span class="text-green">'.$data->cheque_number.'</span> ';
                    } else {
                        return "---";
                    }
                })
                ->rawColumns(['transaction_type', 'payment_type','cheque_number'])
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
            'date'          =>    'required|date',
            'account_id'    =>    'required|string',
            'amount'        =>    'required|string',
            'payment_type'  =>    'nullable',
            'cheque_number' =>    'nullable',
            'cash_details'  =>    'nullable',
            'purpose'       =>    'required',
            'remarks'       =>    'required|string',
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
            $transaction->amount        =   $request->amount;
            $transaction->payment_type  =   $request->payment_type;
            $transaction->cheque_number =   $request->cheque_number;
            $transaction->purpose       =   $request->purpose;
            $transaction->remarks       =   $request->remarks;
            $transaction->cash_details  =   $request->cash_details;
            $transaction->created_by    =   Auth::user()->id;
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
            'date'          =>    'required|date',
            'account_id'    =>    'required|string',
            'amount'        =>    'required|string',
            'payment_type'  =>    'nullable',
            'cheque_number' =>    'nullable',
            'cash_details'  =>    'nullable',
            'purpose'       =>    'required|string',
            'remarks'       =>    'required|string',
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

    //account statement page
    public function AccountStatement()
    {
        try {
            $accounts = Account::orderBy('id', 'desc')->get();
            return view('dashboard.transactions.account_statement', compact('accounts'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function AccountStatementList(Request $request)
    {
        try {
            if ($request->ajax()) {
                $credit = Transaction::where('account_id', $request->account_id)
                    ->where('transaction_type', 3)
                    ->orWhere('transaction_type', 1)
                    ->where('date', '<=', $request->start_date)
                    ->sum('amount');

                $debit = Transaction::where('account_id', $request->account_id)
                    ->where('transaction_type', 2)
                    ->where('date', '<=', $request->start_date)
                    ->sum('amount');

                $previous_balance = $credit - $debit;

                $data = Transaction::with('account')
                    ->where('account_id', $request->account_id)
                    ->where('date', '>', $request->start_date)
                    ->where('date', '<=', $request->end_date)
                    ->orderBy('date', 'asc');

                return Datatables::of($data)

                    ->addColumn('credit', function (Transaction $data) {
                        if ($data->transaction_type == 1) {
                            $amount = $data->amount;
                        } elseif($data->transaction_type == 3) {
                            $amount = $data->amount;
                        }else {
                            return  '<p> 00.00 </p>';
                        }
                        return $amount;
                    })

                    ->addColumn('debit', function (Transaction $data) {
                        if ($data->transaction_type == 2) {
                            return  $data->amount;
                        } else {
                            return  '<p> 00.00 </p>';
                        }
                    })
                    ->addColumn('transaction_type', function (Transaction $data) {
                        if ($data->transaction_type == 1) {
                            return  'Credit';
                        } elseif($data->transaction_type == 2) {
                            return  'Debit';
                        }else{
                            return 'Initial Balance';
                        }
                    })

                    ->addColumn('current_balance', function ($data) use (&$previous_balance) {
                        if ($data->transaction_type == 3) {
                            return $previous_balance;
                        } elseif ($data->transaction_type == 1) {
                            $previous_balance = $previous_balance + $data->amount;
                            return $previous_balance;
                        } elseif ($data->transaction_type == 2) {
                            $previous_balance = $previous_balance - $data->amount;
                            return $previous_balance;
                        }
                    })

                    ->with('prevBalance', $previous_balance)
                    ->addIndexColumn()
                    ->rawColumns(['credit', 'debit', 'current_balance','transaction_type'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //account statement page
    public function StudentsTransaction()
    {
        try {
            $batches = Batch::orderBy('id', 'desc')->get();
            return view('dashboard.transactions.students_transaction', compact('batches'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StudentsTransactionList(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Stdpayment::with('student')
                    ->where('std_id', $request->student_id)
                    ->whereDate('created_at', '>',$request->start_date)
                    ->whereDate('created_at', '<=',$request->end_date)
                    ->get();

                return Datatables::of($data)

                ->addColumn('date', function ($data) {
                    $value = Carbon::parse($data->created_at)->format('Y-m-d');
                    return $value;
                })

                ->addColumn('reg_no', function ($data) {
                    $value = isset($data->student->reg_no) ? $data->student->reg_no : null;
                    return $value;
                })

                ->addColumn('payment_month', function ($data) {
                    $value = Carbon::parse($data->month)->format('F Y');;
                    return $value;
                })

                ->addColumn('contact_number', function ($data) {
                    $contact = isset($data->student->contact_number) ? $data->student->contact_number : null;
                    return $contact;
                })

                ->addColumn('action', function ($data) {
                    return '<a href="' . route('admin.student.payment.show', $data->id) . '" class="btn btn-sm btn-info" title="details"><i class="bx bxs-show"></i></a>';
                })

                ->addIndexColumn()
                ->rawColumns(['date','payment_month','reg_no','contact_number', 'action'])
                ->toJson();
        }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //account statement page
    public function TeachersTransaction()
    {
        try {
            $teachers = Teacher::orderBy('id', 'desc')->get();
            return view('dashboard.transactions.teachers_transaction', compact('teachers'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function TeachersTransactionList(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Tchpayment::with('teacher')
                    ->where('tch_id', $request->teacher_id)
                    ->whereDate('created_at', '>',$request->start_date)
                    ->whereDate('created_at', '<=',$request->end_date)
                    ->get();

                return Datatables::of($data)

                ->addColumn('date', function ($data) {
                    $value = Carbon::parse($data->created_at)->format('Y-m-d');
                    return $value;
                })

                ->addColumn('reg_no', function ($data) {
                    $value = isset($data->teacher->reg_no) ? $data->teacher->reg_no : null;
                    return $value;
                })

                ->addColumn('payment_month', function ($data) {
                    $value = Carbon::parse($data->month)->format('F Y');;
                    return $value;
                })

                ->addColumn('contact_number', function ($data) {
                    $contact = isset($data->teacher->contact_number) ? $data->teacher->contact_number : null;
                    return $contact;
                })

                ->addColumn('action', function ($data) {
                    return '<a href="' . route('admin.teacher.payment.show', $data->id) . '" class="btn btn-sm btn-info" title="details"><i class="bx bxs-show"></i></a>';
                })

                ->addIndexColumn()
                ->rawColumns(['date','payment_month','reg_no','contact_number', 'action'])
                ->toJson();
        }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function print(){
        $transactions = Transaction::get();
        return view('dashboard.transactions.print', compact('transactions') );
    }

    public function pdf(){
        $transactions = Transaction::get();
        $pdf = PDF::loadView('dashboard.transactions.pdf', compact('transactions') );
        return $pdf->download('Transaction List.pdf');
    }
}
