    <?php

    use App\Http\Controllers\contactcontroller;
    use App\Http\Controllers\MembershipclubController;
    use App\Http\Controllers\usercontroller;
    use App\Http\Controllers\TokenController;
    use Illuminate\Support\Facades\Route;

    // route::get('settings',[SettingController::class,'index'])->middleware('auth:sanctum');
    route::get('users',[usercontroller::class,'index'])->middleware('auth:sanctum');
    route::get('staff',[usercontroller::class,'staff'])->middleware('auth:sanctum');
    // route::post('settings/save',[SettingController::class,'store'])->middleware('auth:sanctum');
    route::post('/contact',[contactcontroller::class,'submit']);
    route::get('membershipclub/guest/listing',[MembershipclubController::class,'guestlisting']);

    route::get('membershipclub/list',[MembershipclubController::class,'listing'])->middleware('auth:sanctum');
    route::get('membershipclub/public-view/{id}',[MembershipclubController::class,'publicview']);
    route::get('membershipclub/details/{id}',[MembershipclubController::class,'detailsview'])->middleware('auth:sanctum');
    route::get('token/data',[TokenController::class,'getTokenData']);
    route::get('token/getAllTokenData',[TokenController::class,'getAllTokensData']);


    route::get('membershipclub/joining/{id}',[MembershipclubController::class,'joinmembershipclub'])->middleware('auth:sanctum');;
route::post('membershipclub/comment/save/{id}',[MembershipclubController::class,'savecomment'  ])->middleware('auth:sanctum');

include 'api/auth.php';
include 'api/blog.php';
include 'api/coinpayments.php'; 


