<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\token;

class TokenController extends Controller
{
    public function index(){
        $tokens = token::all()->toarray(); // Get all users from the database

        $category = '';
        return view('admin.tokensetting', compact('category','tokens'));
    }
}
