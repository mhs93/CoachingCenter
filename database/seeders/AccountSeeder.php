<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create([
            'account_no' => 'cash',
            'account_holder' => 'cash',
            'bank_name' => 'cash',
            'branch_name' => 'cash'
        ]);
        $transaction = Transaction::create([
            'date' => Carbon::now(),
            'stdpayment_id' => 'NULL',
            'tchpayment_id' => 'NULL',
            'income_id' => 'NULL',
            'expense_id' => 'NULL',
            'account_id' => 1,
            'transaction_type' => '3',
            'amount' => '0',
            'payment_type' => '2',
            'cheque_number' => 'NULL',
            'note' => 'initial amount',
            'created_by' => '0'
        ]);
    }
}
