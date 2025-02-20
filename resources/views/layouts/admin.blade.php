<!DOCTYPE html>
<html lang="zxx" class="js">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <link rel="shortcut icon" href="{{ asset('images/HeaderLogo.png') }}">
    <title>IVest Club| Backend Panel</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashlitee5ca.css') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/themee5ca.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>


    </style>
</head>

<body class="nk-body npc-crypto bg-white has-sidebar no-touch nk-nio-theme ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed is-dark" data-content="sidebarMenu">
                @include('includes.sidebar')
            </div>
            <div class="nk-wrap ">
                @include('includes.header')
                <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @yield('content')
                        </div>
                    </div>
                </div>
                @yield('models')
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; @php
                                echo date('Y');
                            @endphp . Developed by <a
                                    href="https://eazisols.com" target="_blank">Eazisols</a></div>
                            <div class="nk-footer-links">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ url('auto-logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <script src="{{ asset('assets/js/bundlee5ca.js') }}"></script>
    <script src="{{ asset('assets/js/scriptse5ca.js') }}"></script>
    <script src="{{ asset('assets/js/demo-settingse5ca.js') }}"></script>
    <script src="{{ asset('assets/js/charts/gd-defaulte5ca.js') }}"></script>

    <script>
        @if (session('success'))
            Swal.fire(
                'Success !',
                "{{ session('success') }}",
                'success'
            )
        @endif

        @if (session('failure'))

            Swal.fire(
                'error !',
                "{{ session('failure') }}",
                'error'
            )
        @endif
        $(document).ready(function() {
    const timeout = 1800  *1000; // 30 minutes in milliseconds
    let idleTimer = null;

    $('*').on(
        'mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick',
        function() {
            clearTimeout(idleTimer);

            idleTimer = setTimeout(function() {
                fetch('{{ url('/check-session') }}') // Replace with your API endpoint
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json(); // Parses the response as JSON
                    })
                    .then(data => {
                        console.log(data); // Process the data
                        if (data == 1) {
                            document.getElementById('logout-form').submit();
                        } else {
                            window.location.href = "/"; // Redirect client-side
                            alert('You have been logged out due to inactivity.');
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });

            }, timeout);
        }
    );

    $("body").trigger("mousemove"); // Initialize
});

    </script>
    @yield('extra-script')
</body>


</html>
