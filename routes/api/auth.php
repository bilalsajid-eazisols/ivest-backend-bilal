<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

use App\Http\Controllers\usercontroller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/user', function (Request $request) {
    $user = $request->user();
    return  $user->profileImage();
    })->middleware('auth:sanctum');
    Route::post('/register',[usercontroller::class,'Register']);
    Route::post('login',[usercontroller::class,'login']);
    Route::post('logout',[usercontroller::class,'logout'])->middleware('auth:sanctum');
    route::post('check-otp',[usercontroller::class,'checkotp']);
    route::post('resend-otp',[usercontroller::class,'resendotp']);
    Route::post('save-answers', [usercontroller::class,'save_answers'])->middleware('auth:sanctum');
    Route::post('forgot-password',[usercontroller::class,'forgotpassword']);
    Route::post('/reset-password',[usercontroller::class,'resetpassword'])->name('password.reset');
    Route::post('profile/save',[usercontroller::class,'profilesave'])->middleware('auth:sanctum');
    Route::get('profile',[usercontroller::class,'profile'])->middleware('auth:sanctum');
    Route::post('/register-with-otp',[usercontroller::class,'Registerwithotp']);
  
    route::post('set-password',[usercontroller::class,'setpassword'])->middleware('auth:sanctum');
    route::post('profile/update-password',[usercontroller::class,'updatepassword'])->middleware('auth:sanctum');
    route::post('upload-docs',[usercontroller::class,'uploadkycdocs'])->middleware('auth:sanctum');
    route::post('us-citizen',[usercontroller::class,'uscitizen']);
    route::post('send-verify-email',[usercontroller::class,'sendverifyemail'])->middleware('auth:sanctum');
    route::get('user/verify-email/{id}',[usercontroller::class,'verifyemail'])->name('verification.verify');
    route::post('/user/save-discord-username',[usercontroller::class,'savediscordusername'])->middleware('auth:sanctum');
route::get('unread-notifications',[usercontroller::class,'getnotifications'])->middleware('auth:sanctum');
route::post('mark-all-notifications',[usercontroller::class,'markasread'])->middleware('auth:sanctum');

