<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();
        Return view('dashboard.bank.bankindex',compact('banks'));
    }

    public function create(){
        return view('dashboard.bank.bankcreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'=>'required|string',
//            'branch'=>'required|string',
        ]);
        $bank = new Bank();
        $bank->bank_name = $request->bank_name;
        $bank->save();
        return redirect()->route('admin.bank.index')->with('success','Bank created successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('dashboard.bank.bankedit',compact('bank'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name'=>'required|string',
//            'branch'=>'required|string',
        ]);
        Bank::where('id',$request->id)->update([
            'bank_name' => $request->bank_name,
//            'branch' => $request->branch,
        ]);
        return redirect()->route('admin.bank.index')->with('success','updated successfully');
    }


    public function destroy(Bank $bank)
    {
        $bank= Bank::where('id',$bank->id)->delete();
        return redirect()->back()->with('success','Bank deleted successfully');
    }
}
