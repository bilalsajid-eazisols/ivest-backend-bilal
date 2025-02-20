<!DOCTYPE html>
<html lang="zxx" class="js">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta name="author" content="eazisols">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description"
        content="Ivest Admin Panel | Access the Backend of IVEST ">
    <link rel="shortcut icon" href="{{asset('images/HeaderLogo.png')}}">
    <title>Sign In |  Admin  Panel Ivest </title>
    <link rel="stylesheet" href="{{asset('assets/css/dashlitee5ca.css')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/themee5ca.css')}}">

</head>

<body class="nk-body bg-white npc-general pg-auth  nk-body npc-crypto bg-white has-sidebar no-touch nk-nio-theme ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center"><a href="#" class="logo-link"><img
                                    class="logo-light logo-img logo-img-lg" src="{{asset('images/HeaderLogo.png')}}"
                                   alt="logo"><img
                                    class="logo-dark logo-img logo-img-lg" src="{{asset('images/HeaderLogo.png')}}"
                                     alt="logo-dark"></a></div>
                        <div class="card card-bordered">
                            <div class="card-inner ">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title text-center" >Sign In</h4>
                                        <div class="nk-block-des">
                                            <p>Access the Ivest Admin Panel using your email and password.</p>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{url('admin/login')}}">
                                    @csrf
                                    @if (session('failure'))
                                    <p class="text-danger">
                                        {{session('failure')}}
                                    </p>
                                    @endif
                                    @if (session('success'))
                                    <p class="text-success">
                                        {{session('success')}}
                                    </p>
                                    @endif
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label" for="default-01">Email
                                              </label></div>
                                        <div class="form-control-wrap"><input type="email"
                                                class="form-control form-control-lg" id="default-01" name="email"
                                                placeholder="Enter your email address "
                                                value="{{old('email')}}"
                                                >
                                                @if ($errors->any())
                                                @foreach ($errors->all() as $error)
                                                <p class="text-danger mb-0">
                                                    {{$error}}
                                                </p>
                                                @endforeach

                                                @endif
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group"><label class="form-label"
                                                for="password">Password</label>

                                            </div>
                                        <div class="form-control-wrap"><a href="#"
                                                class="form-icon form-icon-right passcode-switch lg"
                                                data-target="password"><em
                                                    class="passcode-icon icon-show icon ni ni-eye"></em><em
                                                    class="passcode-icon icon-hide icon ni ni-eye-off"></em></a><input
                                                type="password" class="form-control form-control-lg" id="password"
                                                placeholder="Enter your password" name="password">
                                                @if (session('failedpassword'))
                                                <p class="text-danger">
                                                    {{session('failedpassword')}}
                                                </p>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="form-group"><button class="btn  btn-warning btn-block my-3">Sign
                                            in</button></div>
                                </form>



                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">

                                </div>
                                <div class="col-lg-12">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; @php
                                            echo date('Y')
                                        @endphp Eazisols. All Rights Reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
     function  submitform(){
        email = document.getElementById('default-01').value;
        password = document.getElementById('password').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{url('api/login')}}', {

            method: 'POST', // Specify the request method
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken  // Set the content type
                // Add any other headers here, like Authorization if needed
            },
            body: JSON.stringify({
                // Your data here
                email: email,
                password: password,
            })
        }) .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Parse the JSON from the response
        })


     }
     const myHeaders = new Headers();
myHeaders.append("x-umami-api-key", "GRKLC6RqUDkmOPzPHCihVNpuol9vPnHi");

const requestOptions = {
  method: "GET",
  headers: myHeaders,
  redirect: "follow"
};

fetch("https://api.umami.is/v1/websites/391462e9-04dc-4221-940c-a00beb236c6c/stats/?startAt=1705171200000&endAt=1705171200000", requestOptions)
  .then((response) => response.text())
  .then((result) => console.log(result))
  .catch((error) => console.error(error));
    </script>
    <script src="{{asset('assets/js/bundlee5ca.js')}}"></script>
    <script src="{{asset('assets/js/scriptse5ca.js')}}"></script>
    <script src="{{asset('assets/js/demo-settingse5ca.js')}}"></script>
</body>

</html>
