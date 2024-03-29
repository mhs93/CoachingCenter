<?php

namespace App\Http\Controllers\Transaction;

use PDF;
use App\Helper\Accounts;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BalanceSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:payment_manage');
    }

    // BalanceSheet
    public function balanceSheet(Request $request){
        try {
            if ($request->ajax()) {

                $debit = 0;
                $credit = 0;
                $transaction = Transaction::latest()->with('account')->groupBy('account_id')->get();

                return DataTables::of($transaction)
                    ->addIndexColumn()
                    ->addColumn('bankinfo', function ($transaction) {
//                        return $transaction->account->account_no . ' | ' . $transaction->account->account_holder;
                        if ($transaction->account_id == 1){
                            return 'Cash';
                        }else{
                            return $transaction->account->account_no . ' | ' . $transaction->account->account_holder;
                        }
                    })
                    ->addColumn('debit', function ($transaction) use (&$debit) {
                        $debit = Accounts::debitBalance($transaction->account_id);
                        return $debit;
                    })
                    ->addColumn('credit', function ($transaction) use (&$credit) {
                        $credit = Accounts::creditBalance($transaction->account_id);
                        return $credit;
                    })
                    ->addColumn('balance', function ($transaction) use (&$debit, &$credit) {
                        return $credit - $debit;
                    })
                    ->rawColumns(['balance', 'bankinfo','debit','credit'])
                    ->make(true);
            }
            return view('dashboard.balance_sheet.balance_sheet');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // public function allPrint(){
    //     $transaction = Transaction::latest()->with('account')->groupBy('account_id')->get();
    //     return view('dashboard.income.all-print', compact('incomes') );
    // }

    // public function pdf(){
    //     $incomes = Income::get();
    //     $pdf = PDF::loadView('dashboard.income.pdf', compact('incomes') );
    //     return $pdf->download('Income List.pdf');
    // }
}
