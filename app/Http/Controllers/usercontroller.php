<?php

namespace App\Http\Controllers;

use App\Notifications\generalnotification;
use Carbon\Carbon;
use App\Models\kyc;
use App\Models\otp;
use App\Models\User;
use App\Mail\otpemail;
use App\Mail\emailverify;
use App\Models\uscitizen;
use App\Mail\passwordchange;
use App\Models\kycdocuments;
use Illuminate\Http\Request;
use App\Mail\resetpasswordmail;
use App\Mail\registerationemail;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class usercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->id) {
            $users = User::whereHas('membershipClubs', function ($query) use ($request) {
                $query->where('membershipclub_id', $request->id);
            })->get();
        }
        else
        {$users = user::where('user_type', 'user')->get();}

        return view('admin.users.index',compact('users'));
        // return response()->json($users, 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token', ['*'], now()->addMinutes(3600))->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'email'=>$user->email,
            'username'=>$user->username,
            'user_id'=>$user->id,
            'profile'=>$user->profileNodefault(),
            'discord_user_id' =>$user->discord_userid,
        ]);
    }
    public function Register(Request $request)
    {

        $request->validate([
            // 'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[0-9]/',
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string|regex:/^[A-Za-z\s]+$/',
        ]);


        try {
            $user = User::create([
                // 'username' => $request->username,
                'FirstName' => $request->FirstName,    // Consistent naming
                'LastName' => $request->LastName,      // Consistent naming
                'country' => $request->country,
                'city' => $request->city,
                'is_verified' => 0,
                'user_type' => 'user',                  // Fixed typo: 'user_type'
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token', ['*'], now()->addMinutes(3600))->plainTextToken;
            setemailcredentials();
            Mail::to($user->email)->send(new registerationemail( $user->FirstName,$user->lastname));
        //   $this->sendverifyemail($request,$user->id);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'email'=>$user->email,
                'username'=>$user->username,
                'profile'=>$user->profileNodefault(),
                'discord_user_id' =>$user->discord_userid,
            ]);
        } catch (\Throwable $th) {
            // Log the actual error for debugging
            // \Log::error($th);

            return response()->json([
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }
    public function Registerwithotp(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
            'dob' => 'required|date',

        ]);
        try {
            $user = User::create([
                'username' => $request->username,
                'FirstName' => $request->FirstName,    // Consistent naming
                'LastName' => $request->LastName,      // Consistent naming

                'is_verified' => 0,
                'user_type' => 'user',                  // Fixed typo: 'user_type'
                'email' => $request->email,
                'dob' => $request->dob,

            ]);
            $code = generateotp($user->id);
            setemailcredentials();

            Mail::to($user->email)->send(new otpemail($code));


            return response(['message' => 'Otp Email Sent'], 200);


        } catch (\Throwable $th) {


            return response()->json([
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        try {
            $user->currentAccessToken()->delete();
            return response("Logout", 200);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return response('something went Wrong', 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        try {
            User::where('id',$id)->delete();

            return redirect('admin/users')->with('success', 'User deleted successfully');
        } catch (\Throwable $th) {


            return back()->with('failure', 'An error occurred: ' . $th->getMessage());
        }
    }
    public function checkotp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|exists:otps,code',
        ]);
        $user = user::where('email', $request->email)->first();
        $code = $request->code;
        // return $user;
        $otp = otp::where('code', $code)->where('user_id', $user->id)->first();
        if ($otp) {
            if ($otp->expiry > Carbon::now()) {
                $token = $user->createToken('auth_token', ['*'], now()->addMinutes(3600))->plainTextToken;
                setemailcredentials();
                Mail::to($user->email)->send(new registerationemail( null,null,$user->username));
                // $user->email_verified_at = Carbon::now();
                $dt =Carbon::now();
                DB::update("UPDATE users SET email_verified_at = ? WHERE id = ?", [$dt, $user->id]);
                $user->is_verified = 1;
                $user->save();
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'email'=>$user->email,
                    'username'=>$user->username,
                    'profile'=>$user->profileNodefault(),
                    'discord_user_id' =>$user->discord_userid,
                ]);
            } else {
                return response(' OTP Expired', 422);
            }
        } else {
            return response('Invalid OTP', status: 422);
        }
    }
    public function resendotp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = user::where('email', $request->email)->first();
        if ($user) {
            setemailcredentials();
            $code = generateotp($user->id);
            try {
                Mail::to($user->email)->send(new otpemail($code));
                return response(['message' => 'Otp Email Sent'], 200);
            } catch (\Throwable $th) {
                return response('something went wrong', 400);
            }
        }
    }
    public function save_answers(Request $request)
    {
        $user = $request->user();
        $user->facebook_backers = $request->facebook_backers;
        $user->exclusive_member = $request->exclusive_member;
        $user->Pre_ipo_companies = $request->Pre_ipo_companies;
        $user->Financial_knowedge = $request->Financial_knowedge;
        try {
            $user->save();
            return response()->json('User Data Updated', 200);
        } catch (\Throwable $th) {
            return response()->json('Something Went Wrong', 400);
        }
    }
    public function forgotpassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        // try {
        setemailcredentials();
        $token = hash::make('password');
        try {
            DB::table('password_reset_tokens')->insert([
                "email" => $request->email,
                "token" => $token,
                "expiry" => now()->addHour(),
                "created_at" => now(),
            ]);

            Mail::to($request->email)->send(new resetpasswordmail($request->email, $token));
            return response()->json("Reset Password Email Sent", 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "message" => "Something Went Wrong",
                "error" => $th->getMessage(),
            ], 400);
        }
    }
    public function resetpassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'token' => 'required',
                'password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[0-9]/',
            ]
        );
        $token = DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->first();
        if ($token->expiry > Carbon::now()) {
            $user = user::where('email', $request->email)->first();
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            setemailcredentials();
            $message = "Your Password Was successfully Reseted !";
            // Notification
            $user->notify(new generalnotification($message));
            Mail::to($request->email)->send(new passwordchange($request->email));
            return response()->json("Password Updated", 200);
        } else {
            return response()->json(' Expired Token', 403);
        }
    }
    public function profilesave(Request $request)
    {
        //    dd($request->all());
        $user = $request->user();
        if ($request->password != null) {
            $request->validate([
                'email' => "required|email|unique:users,email,$user->id",
                'username' => "required|unique:users,username,$user->id",
                'FirstName' => 'nullable|string',
                "LastName" => "nullable|string",
                'password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[0-9]/',
                'profile'=>'nullable|file|max:3072',
                'city'=>'nullable|regex:/^[A-Za-z\s]+$/',
            ]);
        } else {
            $request->validate([
                'email' => "required|email|unique:users,email,$user->id",
                'username' => "required|unique:users,username,$user->id",
                'FirstName' => 'nullable|string',
                "LastName" => "nullable|string",
                'profile'=>'nullable|file|max:3072',
                'city'=>'nullable|regex:/^[A-Za-z\s]+$/',


                // 'password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[0-9]/',
            ]);
        }
        try {
            $user->email = $request->email;
            $user->FirstName = $request->FirstName;
            $user->LastName = $request->LastName;
            $user->username = $request->username;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->country = $request->country;
            $user->dob = $request->dob;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            if ($request->profile) {
                if (kycdocuments::where('user_id',$user->id)->where('type','profile')->count() >= 1 ) {
                    kycdocuments::where('user_id',$user->id)->where('type','profile')->delete();

                }
                $path = $request->file('profile')->store("public/kyc");
                $path = str_replace('public', 'storage', $path);

                kycdocuments::create([
                    'path' => $path,
                    'user_id' => $user->id,
                    'type' => 'profile',
                ]);
            }

            if($request->diverlicensefront || $request->diverlicenseback || $request->idcardfront || $request->idcardback || $request->passport){
                $kyc = new kyc();
                $kyc->status_id = 1;
                $kyc->user_id = $user->id;
                $kyc->save();
            //   return response($kyc);
                if ($request->diverlicensefront) {
                    if($user->driver_license_front() != null){
                        kycdocuments::where('user_id',$user->id)->where('type','driver-license')->where('subtype','front')->delete();
                    }
                    $path = $request->file('diverlicensefront')->store("public/kyc");
                    $path = str_replace('public', 'storage', $path);

                    kycdocuments::create([
                        'path' => $path,
                        'user_id' => $user->id,
                        'type' => 'driver-license',
                        'subtype' => 'front',
                        'kyc_id'=>$kyc->id,
                    ]);
                }
                if ($request->diverlicenseback) {
                    if($user->driver_license_back() != null){
                        kycdocuments::where('user_id',$user->id)->where('type','driver-license')->where('subtype','back')->delete();
                    }
                    $path = $request->file('diverlicenseback')->store("public/kyc");
                    $path = str_replace('public', 'storage', $path);

                    kycdocuments::create([
                        'path' => $path,
                        'user_id' => $user->id,
                        'type' => 'driver-license',
                        'subtype' => 'back',
                        'kyc_id'=>$kyc->id,

                    ]);
                }
                if ($request->idcardfront) {
                    if($user->id_front() != null){
                        kycdocuments::where('user_id',$user->id)->where('type','id-card')->where('subtype','front')->delete();
                    }
                    $path = $request->file('idcardfront')->store("public/kyc");
                    $path = str_replace('public', 'storage', $path);

                    kycdocuments::create([
                        'path' => $path,
                        'user_id' => $user->id,
                        'type' => 'id-card',
                        'subtype' => 'front',
                        'kyc_id'=>$kyc->id,

                    ]);
                }
                if ($request->idcardback) {
                    if($user->id_back() != null){
                        kycdocuments::where('user_id',$user->id)->where('type','id-card')->where('subtype','back')->delete();
                    }
                    $path = $request->file('idcardback')->store("public/kyc");
                    $path = str_replace('public', 'storage', $path);

                    kycdocuments::create([
                        'path' => $path,
                        'user_id' => $user->id,
                        'type' => 'id-card',
                        'subtype' => 'back',
                        'kyc_id'=>$kyc->id,

                    ]);
                }
                if ($request->passport) {
                    if($user->passport() != null){
                        kycdocuments::where('user_id',$user->id)->where('type','passport')->delete();
                    }
                    $path = $request->file('passport')->store("public/kyc");
                    $path = str_replace('public', 'storage', $path);

                    kycdocuments::create([
                        'path' => $path,
                        'user_id' => $user->id,
                        'type' => 'passport',
                        // 'subtype'=>'',
                        'kyc_id'=>$kyc->id,

                    ]);
                    return response()->json('Profile Data Updated',200);
                }
            }
            return response()->json([
                'message'=>'Profile Updated Successfull',

            ],200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message'=>'Something Went Wrong',
                'error'=>$th,
            ],400);

        }

    }
    public function profile(Request $request){
        $user = $request->user();
        $user->profile = $user->profileNodefault();
        $user->driverlicense=[
            'front'=>$user->driver_license_front(),
            'back'=>$user->driver_license_back(),

        ];
        $user->idcard=[
            'front'=>$user->id_front(),
            'back'=>$user->id_back(),

        ];
        $user->passport = $user->passport();
        return response()->json($user,200);

    }
    public function view($id){
        $user = user::find($id);
        $previousUrl = url()->previous();
        return view('admin.users.profile',compact('user','previousUrl'));
    }
    public function setpassword(Request $request){
        $user = $request->user()??Auth::user();
        $request->validate(['password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[0-9]/',]);
        $user->password = Hash::make($request->password);
        try {
            $user->save();
            return response()->json('password Saved',200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json('Something went Wrong',400);

        }
    }
    public function updatepassword(Request $request){
        $user = $request->user()??Auth::user()->id;
        // $user = user::where('id',Auth::user()->id)->first();
        $request->validate([
            'currentpassword:required',
            'password' => 'required|confirmed',
        ]);
        if(!Hash::check($request->currentpassword, Auth::user()->password)){
        return response()->json(['message'=>'current Password is incorrect '],422);
        }else{
        $user->password =Hash::make($request->password);
        $user->save();
        return response()->json('Password Updated ',200);
    }

    }
    public function uploadkycdocs(Request $request){
        $user = $request->user()??Auth::user();
        if($request->diverlicensefront || $request->diverlicenseback || $request->idcardfront || $request->idcardback || $request->passport){
            $kyc = new kyc();
            $kyc->status_id = 1;
            $kyc->user_id = $user->id;
            $kyc->save();
        //   return response($kyc);
            if ($request->diverlicensefront) {
                if($user->driver_license_front() != null){
                    kycdocuments::where('user_id',$user->id)->where('type','driver-license')->where('subtype','front')->delete();
                }
                $path = $request->file('diverlicensefront')->store("public/kyc");
                $path = str_replace('public', 'storage', $path);

                kycdocuments::create([
                    'path' => $path,
                    'user_id' => $user->id,
                    'type' => 'driver-license',
                    'subtype' => 'front',
                    'kyc_id'=>$kyc->id,
                ]);
            }
            if ($request->diverlicenseback) {
                if($user->driver_license_back() != null){
                    kycdocuments::where('user_id',$user->id)->where('type','driver-license')->where('subtype','back')->delete();
                }
                $path = $request->file('diverlicenseback')->store("public/kyc");
                $path = str_replace('public', 'storage', $path);

                kycdocuments::create([
                    'path' => $path,
                    'user_id' => $user->id,
                    'type' => 'driver-license',
                    'subtype' => 'back',
                    'kyc_id'=>$kyc->id,

                ]);
            }
            if ($request->idcardfront) {
                if($user->id_front() != null){
                    kycdocuments::where('user_id',$user->id)->where('type','id-card')->where('subtype','front')->delete();
                }
                $path = $request->file('idcardfront')->store("public/kyc");
                $path = str_replace('public', 'storage', $path);

                kycdocuments::create([
                    'path' => $path,
                    'user_id' => $user->id,
                    'type' => 'id-card',
                    'subtype' => 'front',
                    'kyc_id'=>$kyc->id,

                ]);
            }
            if ($request->idcardback) {
                if($user->id_back() != null){
                    kycdocuments::where('user_id',$user->id)->where('type','id-card')->where('subtype','back')->delete();
                }
                $path = $request->file('idcardback')->store("public/kyc");
                $path = str_replace('public', 'storage', $path);

                kycdocuments::create([
                    'path' => $path,
                    'user_id' => $user->id,
                    'type' => 'id-card',
                    'subtype' => 'back',
                    'kyc_id'=>$kyc->id,

                ]);
            }
            if ($request->passport) {
                if($user->passport() != null){
                    kycdocuments::where('user_id',$user->id)->where('type','passport')->delete();
                }
                $path = $request->file('passport')->store("public/kyc");
                $path = str_replace('public', 'storage', $path);

                kycdocuments::create([
                    'path' => $path,
                    'user_id' => $user->id,
                    'type' => 'passport',
                    // 'subtype'=>'',
                    'kyc_id'=>$kyc->id,

                ]);
                return response()->json(' Documents Uploaded ',200);
            }
        }
    }
    public function uscitizen(Request $request){
        $request->validate(['email'=>'required|email|unique:uscitizens,email']);
        $uscitizen = uscitizen::create(['email'=>$request->email,]);
        return response()->json('Email added to Database',200);
    }
    public function viewuscitizen(){
        $uscitzens = uscitizen::all();
        return view('admin.users.usa',compact('uscitzens'));
    }
    public function sendverifyemail(Request $request){
        $user = $request->user();
        try {
            //code...
            setemailcredentials();

            Mail::to($user->email)->send(new emailverify($user));
            return response()->json('Email Sent');
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(),400);

        }

    }
    public function verifyemail($id,Request $request){
        $frontendurl = getfrontendurl();
        if (! $request->hasValidSignature()) {
            return Redirect( "$frontendurl?verification-status=failed");
        }else{
            // dd($id);
            // $user = DB::table('users')::up('id',$id)->first();
            try {
                $frontendurl = getfrontendurl();

                $dt =Carbon::now();
            DB::update("UPDATE users SET email_verified_at = ? WHERE id = ?", [$dt, $id]);
            $message = "Your Email was Successfully Verified  !";
            // Notification
            $user = user::find($id)->first();
            $user->notify(new generalnotification($message));

            return Redirect( "$frontendurl?verification-status=verified");
        // }else{
            // $user->email_verified_at = Carbon::now();
            // $user->is_verified = 1;

                // $user->save();

                //code...
            } catch (\Throwable $th) {
                // throw $th;
                $frontendurl = getfrontendurl();
            return Redirect( "$frontendurl?verification-status=failed");


            }

        // }


        }



}
public function savediscordusername(Request $request){
    $user = $request->user();
    $user->discord_userid = $request->discord_userid;
    try {
        $user->save();
    return response()->json(['message'=>'Discord User Id Saved','discord_userid'=>$request->discord_userid]);
    } catch (\Throwable $th) {
        return response()->json($th->getMessage(),400);
    }
}
public function autologout(Request $request){

    if (Auth::check()) {
        Auth::logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
        return redirect('/')->with('failure', 'You have been logged out Due to Inactivity .');
    }else{
        return redirect('/')->with('failure', 'You have been logged out Due to Inactivity .');

    }
}
public function getnotifications(Request $request){
$user = $request->user();
return response()->json($user->unreadNotifications);
}
public function markasread(Request $request){
    $user = $request->user();
    $user->unreadNotifications->markAsRead();
    return response()->json('marked all as viewed ');
}
}

