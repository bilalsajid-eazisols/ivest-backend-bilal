<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Password Changed|IVest Club</title>
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
        <h1 style="color: white;">Password Successfully Updated </h1>
    </div>
   <div style="padding: 20px;">
    <p style="margin: 10px 0px">
        Hi {{$email}},

    </p>
<p style="margin: 10px 0px">

    We wanted to let you know that your password was successfully changed on {{date('y-md-d')}}.</p>
<p style="margin: 10px 0px">
    If you made this change, no further action is required. However, if you did not initiate this password change, please contact our support team immediately by replying to this email or reaching out via Support
</p>
<h5>For security tips:</h5>
<ul>
    <li>Avoid using the same password across multiple websites.</li>
    <li>Use a combination of upper and lower case letters, numbers, and symbols for a stronger password. </li>
    <li>Consider using a password manager to securely store your passwords</li>

</ul>
<p>
    If you have any questions or concerns, feel free to reach out.

</p>
<p>
Thank you for being a valued member of our community!
<br>
Best regards,
IVest Club Support Team,

</p>
   </div>
   </div>
</body>
</html>

