<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ecommerce</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">


</head>

<body class="layout-top-nav">
    <div class="wrapper" id="app">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <span class="brand-text font-weight-light">Ecommerce </span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="" class="nav-link"> Hello {{ Auth::user()->name }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contact</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="fas fa-shopping-cart "></i><span class="text-info">
                                    0</span></a>
                        </li>



                        <li class="nav-item ">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </li>
                    </ul>

                </div>


            </div>
        </nav>
        <div class="section">
            <Mains> </Mains>
            <vue-progress-bar></vue-progress-bar>
        </div>

        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Ecomerce site
            </div>
            <!-- Default to the left -->
            <strong>Copyright © 2020 <a href="#">Hadi Hilal</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- store user -->

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
