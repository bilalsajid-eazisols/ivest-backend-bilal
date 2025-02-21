<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::all()->toarray();
        

        return view('admin.transactions.index', compact('transactions'));

    }
}
