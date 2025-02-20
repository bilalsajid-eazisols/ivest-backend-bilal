<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password|IVest Club</title>
    <style>
        p{color: white !important}
        a{
            color: white !important;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;  color: white; background-image: url('https://ivest-club.vercel.app/assets/landingbg2-D0pof4qd.png'); background-size: cover;border-radius:5px">
    @php
        $frontendurl = getfrontendurl();
    @endphp
   <div style="max-width: 600px; margin: 0 auto; padding: 20px;  ">
    <div style="text-align: center; padding: 10px;">
        <h1 style="color: white;">Reset Password Request</h1>
    </div>
   <div style="padding: 20px;">
    <p style="margin: 10px 0px">
        Hi {{$email}},

    </p>
<p style="margin: 10px 0px">


    We have sent you this email in response to your request to reset your password on IvestClub.
To reset your password, please follow the link below:</p>
<br>
<a href="{{$frontendurl}}/resetpassword?email={{$email}}&token={{$token}}" style="    background-color: #15c;
    color: white;
    text-decoration: none;
    padding: 2%;
    border-radius: 5px;
    margin: 10px 0px ;display:inline-block   ">Click Here to open</a>
<p style="margin: 10px 0px">
or Follow this Link
</p>
<a href="{{$frontendurl}}/resetpassword?email={{$email}}&token={{$token}}" style="margin: 10px 0px">
    {{$frontendurl}}/resetpassword?email={{$email}}&token={{$token}}
</a>
<p style="margin: 10px 0px">
    <em>In case you did not send the reset Password Request please Ignore this Message</em>
</p>
   </div>
   </div>
</body>
</html>

