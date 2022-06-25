<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('template/dist/img/logo.jpg') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    @yield('headerscript')
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <title>@yield('title')</title>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('components.common.navbar')
        @include('components.common.sidebar')
        @include('layouts.contentheader')
