<?php

use App\Http\Middleware\admin_auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kycontroller;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\usercontroller;

Route::get('/', [authcontroller::class, 'loginpage']);

Route::get('login', function () {
    return response()->json('User Authenication Failed,Expired or Missing Token', 403);
})->name('login');
Route::post('admin/login', [authcontroller::class, 'login'])->name('admin.login');

Route::post('/logout', [AuthController::class, 'logout'])->name('adminlogout')->middleware(admin_auth::class);
route::get('admin/profile', function () {
    return view('admin.profile.profile');
})->middleware(admin_auth::class)->name('profile');
route::post('admin/profile/store', [authcontroller::class,'profile_update'])->middleware(admin_auth::class)->name('profile.save');
route::get('admin/password-change', function () {
    return view('admin.profile.password');
})->middleware(admin_auth::class)->name('changepassword');
route::post(
    'admin/update-pasword',
    [authcontroller::class, 'updatepassword']
)->middleware(admin_auth::class)->name('updatepassword');
route::post('admin/kyc/{id}/update',[kycontroller::class,'statusupdate']);
Route::post('auto-logout',[usercontroller::class,'autologout']);
route::get('/check-session',function(){
    if(Auth::check()){
        return response()->json(1);
    }else{
        return response()->json(0);
    }
});
