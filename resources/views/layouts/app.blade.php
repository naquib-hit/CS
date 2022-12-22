<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href=" {{ asset('img/favicon.png') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'CustomerInvoice') }}</title>
  <!--     Fonts and icons     -->
  <style>
    @font-face {
      font-family: 'Roboto';
      src: url("{{ asset('fonts/Roboto/Roboto-Light.ttf') }}"S) format('truetype');
      font-style: normal;
      font-weight: normal;
    }

  </style>
  {{-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" /> --}}
  <!-- Nucleo Icons -->
  <link href=" {{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />
   <!-- Scripts -->

   <!-- Styles -->
   <link href="{{ asset('css/material-dashboard.min.css') }}" rel="stylesheet">

  <style>
    .btn-circle {
        height: 2.8em;
        width: 2.8em;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }
  </style>

   @yield('css')
</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('layouts.sidebar')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @include('layouts.topbar', ['title' => $title])
   
    <div class="container-fluid py-4">
      <div class="row min-vh-80 h-100">
        <div class="col-12">
          
            @yield('content')

        </div>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="{{ asset('js/core/bootstrap.bundle.min.js') }}" ></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    </script>

  <script src="{{ asset('js/material-dashboard.min.js?v=3.0.0') }}"></script>

  @yield('js')
</body>

</html>