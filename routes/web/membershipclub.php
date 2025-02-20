<?php
use App\Http\Middleware\admin_auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipclubController;

route::get('admin/membershipclubs', [MembershipclubController::class, 'index'])->middleware(admin_auth::class)->name('membershipclubs');
route::get('admin/membershipclub/{id}', [MembershipclubController::class, 'club'])->middleware(admin_auth::class)->name('membershipclubs.index');

route::get('admin/membershipclubs/new', [MembershipclubController::class, 'create'])->middleware(admin_auth::class)->name('membershipclubs.create');
route::post('admin/membershipclubs/step1', [MembershipclubController::class, 'step1'])->middleware(admin_auth::class)->name('membershipclubs.step1');
route::post('admin/membershipclubs/step2', [MembershipclubController::class, 'step2'])->middleware(admin_auth::class)->name('membershipclubs.step2');
route::post('admin/membershipclubs/step3', [MembershipclubController::class, 'step3'])->middleware(admin_auth::class)->name('membershipclubs.step3');
route::get('admin/membershipclubs/delete/{id}', [MembershipclubController::class, 'destroy'])->middleware(admin_auth::class)->name('membershipclubs.delete');
route::post('admin/membershipclubs/step5', [MembershipclubController::class, 'step5'])->middleware(admin_auth::class)->name('membershipclubs.step5');

route::get('admin/membershipclub/details/{id}', [MembershipclubController::class, 'view_details'])->middleware(admin_auth::class);

// route::post('admin/membershipclubs/update', [MembershipclubController::class, 'update'])->middleware(admin_auth::class)->name('membershipclubs.update');
route::post('admin/membershipclubs/files-upload/{id}', [MembershipclubController::class, 'filesupload'])->middleware(admin_auth::class)->name('membershipclubs.filesupload');


route::get('admin/membershipclub/file/{id}',[MembershipclubController::class,'deletefile'])->middleware(admin_auth::class);
route::get('admin/memberships/club/members/',[MembershipclubController::class,'getAllClubsWithUserCount']);
?>
