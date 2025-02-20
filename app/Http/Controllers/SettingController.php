<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\setting;
use Illuminate\Http\Request;
use App\Notifications\generalnotification;
use Illuminate\Support\Facades\Notification;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $setting = setting::find(1);
        return response()->json($setting);
    }
    public function store(Request $request){



        $setting = setting::find(1);

        if(!$setting){
            $setting = new setting();
        }
        $setting->smtp_encryption =$request->smtp_encryption;
        $setting->smtp_fromaddress= $request->smtp_fromaddress;
        $setting->smtp_fromname=$request->smtp_fromname;
        $setting->smtp_host=$request->smtp_host;
        // $setting->smtp_password = $request->smptp_password;
        $setting->smtp_port=$request->smtp_port;
        $setting->smtp_username=$request->smtp_username;
        $setting->smtp_password=$request->smtp_password;
        $setting->reciver = $request->reciver;
try {
    $setting->save();
    $users = User::permission('setting_view')->get();
    $datetime =date('Y-m-d H:i:s');
    $message = "Setting Updated  on $datetime";
    Notification::send($users,new generalnotification($message));
    return back()->with('success','Setting saved');
} catch (\Throwable $th) {
    // throw $th;
    // return response($th,400);
    return back()->with( 'failure', 'Something went wrong ');

}
    }
public function viewsetting(){
    // return 1;
    return view('admin.setting');
}

}
