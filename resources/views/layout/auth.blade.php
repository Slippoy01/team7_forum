<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Css File -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('include.auth-css')
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper" style="background: #f4f6f9;">
        <!-- Navbar -->
        @include('include.main-navbar')
        <!-- /.navbar -->

        <main class="py-4 mt-2">
            <!-- /.login-box -->
            @yield('content')
        </main>

        <!-- Javascript File -->
        @include('include.auth-js')
    </div>
</body>

</html>
