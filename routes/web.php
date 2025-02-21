<?php

use App\Http\Middleware\permissioncheck;
use App\Mail\registerationemail;
use App\Http\Middleware\admin_auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TokenController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


Route::get('dashboard', [authcontroller::class, 'dashboard'])->middleware(admin_auth::class)->name('dashboard');

Route::get('setting', [SettingController::class, 'index'])->middleware([admin_auth::class]);
Route::post('setting/store', [SettingController::class, 'store'])->middleware(admin_auth::class);
Route::get('admin/setting', [SettingController::class, 'viewsetting'])->middleware([admin_auth::class])->name('adminsetting');

// token setting route
Route::get('admin/tokensetting', [TokenController::class, 'index'])->middleware(admin_auth::class)->name('tokensetting');
Route::post('/token/store', [TokenController::class, 'store'])->name('token.store');
Route::delete('/token/{id}', [TokenController::class, 'destroy'])->name('token.destroy');



// route::get('/test/{days}',function($daysago){

//     $today = Carbon::now();
//     $pastDate = Carbon::today()->subDays($daysago);
//     $startdate = $pastDate->timestamp;
//     $enddate = $today->timestamp;

//     $response = Http::withHeaders([
//         'x-umami-api-key' => 'GRKLC6RqUDkmOPzPHCihVNpuol9vPnHi',
//     ])->get("https://api.umami.is/v1/websites/391462e9-04dc-4221-940c-a00beb236c6c/metrics/", [
//         'startAt' => $startdate,
//         'endAt' => $enddate,
//         'type'=>'browser'
//     ]);

//     // Return JSON response
//     return response()->json($response->json());

// });

Route::get('notification-read-all;', [authcontroller::class, 'markasread'])->middleware(admin_auth::class)->name('markasread');

include 'web/auth.php';
include 'web/usermanagment.php';
include 'web/news_blog.php';
include 'web/membershipclub.php';
