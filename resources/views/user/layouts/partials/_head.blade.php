<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="keywords" content="erp">
    <meta name="author" content="Retinasoft">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} - {{ __(config('app.name')) }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://6amtech.com/wp-content/uploads/2024/07/6amtech-favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/line-awesome.min.css">

    @yield('css_plugins')
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    @yield('css')
</head>
