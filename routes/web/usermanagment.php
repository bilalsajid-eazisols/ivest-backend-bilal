<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\kycontroller;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\staffcontroller;
use App\Http\Middleware\admin_auth;

#Users/Customers
Route::get('admin/users', [usercontroller::class, 'index'])->name('users')->middleware(admin_auth::class);
Route::get('admin/user/delete/{id}', [usercontroller::class, 'destroy'])->middleware(admin_auth::class);
Route::get('admin/user/{id}',[usercontroller::class,'view'])->middleware(admin_auth::class);
route::get('admin/kycs',[kycontroller::class,'index'])->middleware(admin_auth::class)->name('kyc');
Route::get('admin/us-citizen', [usercontroller::class, 'viewuscitizen'])->name('uscitizen')->middleware(admin_auth::class);



#Staff
Route::get('admin/staff', [staffcontroller::class, 'index'])->name('staff')->middleware(admin_auth::class);
Route::post('admin/staff/save', [staffcontroller::class, 'store'])->name('staff.store')->middleware(admin_auth::class);
Route::post('admin/staff/update', [staffcontroller::class, 'update'])->name('staff.update')->middleware(admin_auth::class);
Route::post('admin/staff/password/update', [staffcontroller::class, 'password_update'])->name('staff.password.update')->middleware(admin_auth::class);
Route::get('admin/staff/delete/{id}', [staffcontroller::class, 'destroy'])->middleware(admin_auth::class);
#Roles and Permissions
Route::get('admin/roles',[authcontroller::class,'roleslist'])->middleware(admin_auth::class);
Route::get('admin/roles/form',[authcontroller::class,'rolesform'])->middleware(admin_auth::class);
Route::post('admin/roles/submit',[authcontroller::class,'submit']);
Route::get('admin/role/{id}',[authcontroller::class,'role'])->middleware(admin_auth::class);
