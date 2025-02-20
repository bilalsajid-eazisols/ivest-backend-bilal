<?php
use App\Models\otp;
use App\Models\setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;


function setemailcredentials(){
$setting = setting::find(1);
config::set('mail.default', 'smtp');
config::set('mail.mailers.smtp.port', $setting->smtp_port);
config::set('mail.mailers.smtp.host', $setting->smtp_host);
config::set('mail.mailers.smtp.username', $setting->smtp_username);
config::set('mail.mailers.smtp.password', $setting->smtp_password);
if ($setting->smtp_fromname) {
    config::set('mail.from.name', $setting->smtp_fromname);
} else {
    config::set('mail.from.name', $setting->smtp_username);

}
if ($setting->smtp_Fromaddress) {
    config::set('mail.from.address', $setting->smtp_Fromaddress);
} else {

    config::set('mail.from.address', $setting->smtp_username);

}

}
function generateotp($user_id){
    if(otp::where('user_id',$user_id)->count()>= 1){
    otp::where('user_id',$user_id)->delete();}
    $otp = new otp();
    $otp->user_id = $user_id;
    $otp->code =  mt_rand(1000, 9999);
    $otp->expiry = now()->addMinutes(10);
    $otp->save();
    return $otp->code;
}
function getfrontendurl(){
    return  config::get('app.frontendurl');

}
function getFileIcon($filePath)
{
    // dd(1);
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    // dd($extension);
    // Define icons for different file types
    $icons = [
        'pdf' => '<em class="icon ni ni-file-pdf" style="font-size:24px"></em>',
        'doc' => '<em class="icon ni ni-file-doc" style="font-size:24px"></em>',
        'docx' => '<em class="icon ni ni-file-doc " style="font-size:24px"></em>',
        'xls' => '<em class="icon ni ni-file-xls" style="font-size:24px"></em>',
        'xlsx' => '<em class="icon ni ni-file-xls" style="font-size:24px"></em>',
        'png' => '<em class="icon ni ni-file-img" style="font-size:24px"></em>',
        'jpg' => '<em class="icon ni ni-file-img" style="font-size:24px"></em>',
        'jpeg' => '<em class="icon ni ni-file-img" style="font-size:24px"></em>',
        'txt' => '<em class="icon ni ni-file-text" style="font-size:24px"></em>',
        'zip' => '<em class="icon ni ni-file-zip" style="font-size:24px"></em>',
        // 'mp4' => '<em class="fas fa-file-video"></i>',
    ];

    // Default icon if the extension is not defined
    $defaultIcon = '<em class="icon ni ni-file" style="font-size:24px"></em>';

    // Return the appropriate icon or the default one
    // dd($icons[$extension] ?? $defaultIcon);
    return $icons[$extension] ?? $defaultIcon;
}
function createrole($rolename){
    $discordwebhook = env('DISCORD_WEBHOOK_ID');
   $command = "!create_role $rolename";
    $webhookUrl = "https://discord.com/api/webhooks/$discordwebhook";
    $response = Http::post($webhookUrl, [
        'content' => $command,
    ]);
    if($response->status() === 204){
        return 1;

    }else{
        return 0;
    }
}
function restrictrole($rolename){
    $discordwebhook = env('DISCORD_WEBHOOK_ID');
    $command = "!restrict_access $rolename";
     $webhookUrl = "https://discord.com/api/webhooks/$discordwebhook";
     $response = Http::post($webhookUrl, [
         'content' => $command,
     ]);
     if($response->status() === 204){
         return 1;

     }else{
         return 0;
     }
}
function assignrole($discord_user_id,$rolename){
    // dd($rolename);
    $discordwebhook = env('DISCORD_WEBHOOK_ID');
    $command = "!assign_role $discord_user_id $rolename";
    // dd($command);
     $webhookUrl = "https://discord.com/api/webhooks/$discordwebhook";
     $response = Http::post($webhookUrl, [
         'content' => $command,
     ]);
     if($response->status() === 204){
         return 1;

     }else{
         return 0;
     }
}


