<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Otp</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: Arial, sans-serif;  color: white; background-image: url('https://IVest-club.vercel.app/assets/landingbg2-D0pof4qd.png'); background-size: cover;border-radius:5px">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;  ">
        <div style="text-align: center; padding: 10px;">
            <h1 style="color: white;">Welcome to IVest Club</h1>
        </div>
        <div style="padding: 10px;">
            <p style="margin:10px 0px">
                Hi, @if ($username == null)
                    {{ $firstname }} {{ $lastname }}
                @else
                    {{ $username }}
                @endif

            </p>
            <p style="margin:10px 0px">
                Welcome to IVest Club - we are thrilled to have you on board!

            </p>
            <p style="margin:10px 0px">
                At IVest Club, we believe that everyone deserves equal access to the incredible opportunities in the
                world of Pre-IPO companies. By joining our community, you are stepping into an exciting journey where
                you
                can explore late-stage companies, engage with peers, and gain access to exclusive insights in a fun and
                rewarding environment.
            </p>
            <p>
                Here’s what you can expect as a member of IVest Club:
            </p>
            <ul>
                <li><strong>Exclusive Access:</strong> Discover investment opportunities in privately-owned companies
                    before they go public.</li>
                <li><strong>Peer Networking:</strong> Connect with like-minded individuals, share information, and learn
                    from the community.</li>
                <li><strong>Democratizing Access:</strong> We aim to level the playing field, making these opportunities
                    available to all.</li>
            </ul>
            <p>
                We’re committed to supporting you every step of the way as you explore the landscape ahead of an IPO
            </p>
            <p>
                Stay tuned for updates, new opportunities, and exciting insights from our community. We can’t wait to
                see how you leverage the resources at your fingertips!
            </p>
            <p>
                Once again, welcome to the club. Let’s make the journey to the public market a thrilling one!


            </p>
            <h5 style="margin: 10px 0px">
                Best regards,
            </h5>
            <p>
                The IVest Club Team
            </p>
            <p>
                @php
                    $frontendurl = getfrontendurl();
                @endphp
                <a href="{{ $frontendurl }}"> {{ $frontendurl }}</a>
            </p>
        </div>

    </div>
</body>

</html>
