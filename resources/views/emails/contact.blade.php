<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;  color: white; background-image: url('https://ivest-club.vercel.app/assets/landingbg2-D0pof4qd.png'); background-size: cover;border-radius:5px">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;  ">
        <div style="text-align: center; padding: 10px;">
            <h1 style="color: white;">New Contact Form Submission</h1>
        </div>
        <div style="padding: 20px;">
            <h1 style="font-size: 24px; margin-bottom: 10px;">Dear Admin,</h1>
            <p style="font-size: 16px; line-height: 1.5;">A new contact form submission has been received. Below are the details:</p>
            <div style="padding: 15px; background-color: margin-top: 20px; border-radius: 5px;">
                <p><strong>Name:</strong> {{$firstname}} {{$lastname}}</p>
                <p><strong>Email:</strong> {{$email}}</p>
                <p><strong>Phone:</strong> {{$phoneno}}</p>
                <p><strong>Message:</strong></p>
                <div>   {!!$messsage!!}</div>
            </div>
            <p style="font-size: 16px;">Please respond to the user as soon as possible.</p>
        </div>
        <div style="margin-top: 20px; text-align: center; font-size: 14px; color:">
            <p>Thank you</p>
        </div>
    </div>
</body>
</html>
