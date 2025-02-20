<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Email Verify|IVest Club</title>
    <style>
        p{color: white !important}
        a{
            color: white !important;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;  color: white; background-image: url('https://ivest-club.vercel.app/assets/landingbg2-D0pof4qd.png'); background-size: cover;border-radius:5px">

   <div style="max-width: 600px; margin: 0 auto; padding: 20px;  ">
    <div style="text-align: center; padding: 10px;">
        <h1 style="color: white;">Please Verify Your Email </h1>
    </div>
   <div style="padding: 20px;">
    <p style="margin: 10px 0px">
        Hi {{$user->email}},

    </p>
<p style="margin: 10px 0px">
    Thank you for signing up with IVesTClub! We’re excited to have you on board. To complete your registration and access your account, please verify your email address.
</p>
<p style="margin: 10px 0px">
    Click the button  to verify:
    <a href="{{$verificationUrl}}" style="    background-color: #15c;
    color: white;
    text-decoration: none;
    padding: 2%;
    border-radius: 5px;
    margin: 10px 0px ;display:inline-block   ">Click Here to open</a>

</p>

<p>
    Or, you can copy and paste the following link into your browser:

</p>
<br>
<a href="{{$verificationUrl}}">{{$verificationUrl}}</a>

<p>
    If you didn’t sign up for this account, please ignore this email.

    <br>
Best regards,
IVest Club Support Team,

</p>
   </div>
   </div>
</body>
</html>

