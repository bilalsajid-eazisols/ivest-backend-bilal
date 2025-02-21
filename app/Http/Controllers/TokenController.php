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

    public function getAllTokenData(Request $request)
    {
        $tokens = Token::select(
            'id as tokenId',
            'membershipclub_id',
            'name',
            'logo',
            'symbol',
            'token_conversion_rate',
            'initialsupply',
            'totalsupply'
        )->get();

        if ($tokens->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No tokens found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tokens,
        ]);
    }

}
