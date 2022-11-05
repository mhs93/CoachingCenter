<?php

namespace App\Helper;

use App\Models\Transaction;

class Accounts
{
    public static function creditBalance($account_id)
    {
        return Transaction::where('account_id', $account_id)
            ->where('transaction_type', 1)
            ->sum('amount');
    }

    public static function debitBalance($account_id)
    {
        return Transaction::where('account_id', $account_id)
            ->where('transaction_type', 2)
            ->sum('amount');
    }

    public static function postBalance($account_id)
    {
        $credit = self::creditBalance($account_id);
        $debit = self::debitBalance($account_id);

        return ($credit - $debit);
    }
}