<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class staffcontroller extends Controller
{
    //
    public function index()
    {
        $staffs = User::where('user_type', '!=', 'user')->get();
        foreach ($staffs as $user) {
            # code...
            $user->role =  $user->roles->first(); ;
        }
        $roles = Role::all();
        return view('admin.staff.index', compact('staffs','roles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'password' => 'required',
        ]);
        $previousUrl = url()->previous();
        $user = new User();
        if($previousUrl == route('staff'))
{        $user->user_type='staff';
    $user->is_verified =1;
}else{
    $user->user_type='user  ';
    $user->is_verified =0;
}
        $user->FirstName=$request->firstname;
        $user->LastName=$request->lastname;
        $user->email=$request->email;
        $user->address=$request->address;
        $user->username=$request->username;

        if ($request->role) {
            # code...
            $user->assignRole($request->role);
        }
        $user->password = Hash::make($request->password);

        try {
            $user->save();
            return back()->with('success',' Created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failure', $th->getMessage());

        }
    }
    public function update(Request $request) {
    $request->validate([
            'username' => "required|unique:users,username,$request->id",
            'email' => "required|unique:users,email,$request->id",
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
        ]);
        $user = user::where('id',$request->id)->first();
        // $user->user_type='admn=';
        if($request->role)
{
        $user->syncRoles([]);
        $user->assignRole($request->role);
}
        $user->username = $request->username;
        $user->FirstName=$request->firstname;
        $user->LastName=$request->lastname;
        $user->email=$request->email;
        $user->address=$request->address;
        try {
            $user->save();
            return back()->with('success',' updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failure', $th->getMessage());

        }
    }
        public function password_update(Request $request){
            $request->validate([
                'password'=>'required|confirmed',
            ]);
            $user = user::where('id',$request->id)->first();
            $user->password= Hash::make($request->password);
            try {
                $user->save();
                return back()->with('success',value: ' Password updated successfully');
            } catch (\Throwable $th) {
                //throw $th;
                return back()->with('failure', $th->getMessage());

            }

        }
        public function destroy($id) {
            if (Auth::user()->id == $id) {
                return back()->with('failure', 'You cannot delete Your Own Account');
            }



            try {
                User::where('id',$id)->delete();

                return redirect('admin/staff')->with('success', 'Staff deleted successfully');
            } catch (\Throwable $th) {


                return back()->with('failure', 'An error occurred: ' . $th->getMessage());
            }
        }

}
