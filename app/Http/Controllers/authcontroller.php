<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\membershipclub;
use App\Models\news;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authcontroller extends Controller
{
    //
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
            $user = User::where('email',$request->email)->first();
            if($user->user_type == "admin" || $user->user_type == 'staff'){
                if (!Auth::attempt($request->only('email', 'password'))) {
                    // dd('failure');
                    return back()->with('failedpassword','Invalid  Password');

                }else{
                    return redirect()->route('dashboard');
                    // return Auth::user();
                }

            }
            else{
                return back()->with('failure','Something went Wrong');
            }


        // $user = Auth::user();

    }
    public function loginpage(){
        if(!Auth::user()){
            return view('auth.login');
        }
        else{
            return back();
        }
    }
    public function logout()
    {
        // Log out the authenticated user
        Auth::logout();

        // Invalidate the session and regenerate the token (for security)
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Redirect the user to the login page or home page
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
    public function dashboard(){
        $latestusers = user::latest()->where('user_type','user')->limit(5)->get();
        $usercount = user::where('user_type','user')->count();
        $blogcount = blog::count();
        $newscount = news::count();
        $clubcout = membershipclub::count();
        $topClubs = MembershipClub::withCount('users')  // Adds a `users_count` attribute to each club
        ->orderBy('users_count', 'desc')            // Sorts by `users_count` in descending order
        ->take(5)                                   // Limits the results to the top 5 clubs
        ->get();
        // dd($topClubs);
    return view('admin.dashboard',compact('latestusers','usercount','blogcount','newscount','clubcout','topClubs'));

}
public function updatepassword(Request $request){
    $user = user::where('id',Auth::user()->id)->first();
    $request->validate([
        'currentpassword' => 'required',
        'password' => [
            'required',
            'confirmed',
            'string',
            'regex:/[a-z]+/',          // At least one lowercase letter
            'regex:/[A-Z]+/',          // At least one uppercase letter
            'regex:/\d+/',             // At least one number
            'regex:/[@$!%*?&#]+/',     // At least one special character
        ],
    ], [
        'password.regex' => 'Password must be at least 8 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ]);
    if(!Hash::check($request->currentpassword, Auth::user()->password)){
    return back()->withErrors(['currentpassword'=>'current Password is incorrect ']);
    }
    elseif($request->password == $request->currentpassword){
        return back()->withErrors(['password'=>'New  Password cannot be same as Current Password']);

    }
    else{
    $user->password =Hash::make($request->password);
    $user->save();
    return back()->with('success','Password Updated ');
}

}
public function profile_update(Request $request){
    $user = user::where('id',auth::user()->id)->first();
    $user->FirstName = $request->FirstName;
    $user->LastName=$request->LastName;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->address= $request->address;
    $user->dob = $request->dob;
    try {
        $user->save();
        return back()->with('success','Profile Updated');

    } catch (\Throwable $th) {
        //throw $th;
        return back()->with('error', $th);

    }
}
public function roleslist(){
    $roles = Role::all();
    return view('roles.index',compact('roles'));
}
public function rolesform( ){
    return view('roles.form');
}
public function submit(Request $request){
    // dd($request->permission);
   if($request->id == 0){

    $request->validate(['name'=>'required|string|unique:roles,name']);
    $role = Role::create(['name'=>$request->name]);
    foreach ($request->permission as $permission) {
        $role->givePermissionTo($permission);
    }
    return back()->with('success','Role Created  Successfully');

}

    if($request->id > 0){
        $role = Role::where('id', $request->id)->first();

if($role->id ==1){
    return back()->with('failure','Action Not Allowed');
}

    $role->name=$request->name;
    $role->syncPermissions($request->permission);
    }
    if ($role->save()) {
        return back()->with('success','Role Updated Successfully');

    }else{
        return back()->with('failure','Something Went Wrong');

    }
}
public function role($id){
    $role = role::find($id);
    // $role->permissions = DB::table('role_has_permission')->where('role_id',$role->id);
    $permissions = $role->permissions;
    // dd($role->permissions);
    return response()->json($role);
}
public function roledelete($id){
    $role=  role::findById($id);

}
public function markasread(){
    $user = Auth::user();
    $user->unreadNotifications->markAsRead(); // Mark all unread notifications as read
    return back();
}
}
