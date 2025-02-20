<?php

namespace App\Http\Controllers;

use App\Models\setting;
use App\Mail\contactmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class contactcontroller extends Controller
{
    //
    public function submit(Request $request){
        $request->validate(['FirstName'=>'required|string',
        "LastName"=>'required|string',
        "email"=>'required|email',
        'phoneno'=>'required',
        'subject'=>'required|string',
        'message'=>'required|string',
    ]);
        $reciver = setting::find(1)->reciver;
        // $settin
        setemailcredentials();
        try {
            Mail::to($reciver)->send(new contactmail($request->FirstName,
            $request->LastName,
            $request->subject,
            $request->email,$request->phoneno,
            $request->message));
            return response()->json('Contact Email Sent',200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error'=>$th,'message'=>'something went wrong'],400);
        }
    }
}
