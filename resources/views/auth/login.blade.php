<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIA TECH | Login</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/images/logo.jpg') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .login-page {
            background-image: url("{{ asset('images/building.jpg') }}");
            background-color: unset;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }

        .card-primary.card-outline {
            border-top: 3px solid #4c81a4;
        }

        p a {
            display: block;
        }
    </style>
</head>

<body id="main-body" class="hold-transition login-page">
    {{-- Preloader --}}
    {{-- <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
      </div> --}}

    {{-- Login Form --}}
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-body shadow-lg">
                <div class="row">
                    <img src="{{ asset('images/login-logo.png') }}" width="80%" class="mx-auto d-block img-fluid mt-3"
                        alt="">
                </div>
                <p class="login-box-msg mt-4">Sign in to start your session</p>
                <div id="app">
                    <login-form :error-fields="{{ $errors }}"/>
                </div>
                <p class="mb-0">
                    <a href="{{ route('password.request') }}" class="text-center">Forgot your password?</a>
                </p>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>

</html>