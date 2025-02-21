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


    public function store(Request $request)
{
    // print_r($request);
    // exit();
    // $request->validate([
    //     'name' => 'required|string|max:255',
    //     'membershipclub_id' => 'nullable|integer',
    //     'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    //     'symbol' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    //     'token_conversion_rate' => 'nullable|numeric',
    //     'transaction_fee' => 'nullable|numeric',
    //     'metamask_wallet_address' => 'nullable|string',
    //     'metamask_wallet_private_key' => 'nullable|string',
    //     'token_contract_address' => 'nullable|string',
    //     'initialsupply' => 'nullable|numeric',
    //     'circulation' => 'nullable|numeric',
    //     'totalsupply' => 'nullable|numeric'
    // ]);

    // Handle file uploads
    $logoPath = $request->file('logo') ? $request->file('logo')->store('logos', 'public') : null;
    $symbolPath = $request->file('symbol') ? $request->file('symbol')->store('symbols', 'public') : null;

    // Create Token
    Token::create([
        'name' => $request->name,
        'membershipclub_id' => $request->membershipclub_id,
        'logo' => $logoPath,
        'symbol' => $symbolPath,
        'token_conversion_rate' => $request->token_conversion_rate,
        'transaction_fee' => $request->transaction_fee,
        'metamask_wallet_address' => $request->metamask_wallet_address,
        'metamask_wallet_private_key' => $request->metamask_wallet_private_key,
        'token_contract_address' => $request->token_contract_address,
        'initialsupply' => $request->initialsupply,
        'circulation' => $request->circulation,
        'totalsupply' => $request->totalsupply,
    ]);

    return response()->json(['success' => 'Token saved successfully!']);
}

public function destroy($id)
{
    $token = Token::find($id);
    if ($token) {
        $token->delete();
        return response()->json(['success' => 'Token deleted successfully']);
    } else {
        return response()->json(['error' => 'Token not found'], 404);
    }
}



}


