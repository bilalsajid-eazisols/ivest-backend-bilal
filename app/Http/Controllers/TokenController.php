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

    public function getTokenData(Request $request)
    {
        $tokenName = $request->query('token');

        if (!$tokenName) {
            return response()->json([
                'success' => false,
                'message' => 'Token name is required',
            ], 400);
        }

        $token = token::where('name', $tokenName)
            ->select(
                'id as tokenId',
                'membershipclub_id',
                'name',
                'logo',
                'symbol',
                'token_conversion_rate',
                'initialsupply',
                'totalsupply'
            )
            ->first();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $token,
        ]);
    }
}
