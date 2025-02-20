<?php

namespace App\Http\Controllers;

use App\Models\kyc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\generalnotification;

class kycontroller extends Controller
{
    //
    public function index(){
        $kycs = kyc::all();
        return view('admin.kyc.index',compact('kycs'));
    }
    public function statusupdate(Request $request , $id){
        $user  = User::find($id);
        $kyc =  $user->latestKyc;
        $kyc->status_id = $request->statusid;
        $kyc->reason = $request->reason;
        $kyc->updated_by = Auth::user()->id;
        $message = "Your Kyc was updated to ". $kyc->status->name." !";
        // Notification
        $user->notify(new generalnotification($message));
        $kyc->save();
        return back();
    }
}
