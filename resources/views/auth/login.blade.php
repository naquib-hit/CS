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
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href=" {{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />
  <link href=" {{ asset('vendor/tinyfade/tinyfade.min.css') }}" rel="stylesheet" />
   <!-- Scripts -->
   <script src="{{ asset('js/core/bootstrap.bundle.min.js') }}" defer></script>
   <script src="{{ asset('vendor/tinyfade/tinyfade.min.js') }}" defer></script>
   <!-- Styles -->
   <link href="{{ asset('css/material-dashboard.min.css') }}" rel="stylesheet">
   <style>
    .panel-circle {
      width: 5rem;
      height: 5rem;
      border-radius: 50% !important;
      display: flex;
      justify-content: center;
      align-items: center;
    }
   </style>
</head>
<body class="bg-gray-200">
    <main class="main-content  mt-0">
      <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
          <div class="row">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
              <div class="card z-index-0 px-2 fadeIn3 fadeInBottom" style="border-top-left-radius: 35px !important; border-top-right-radius: 35px !important;">
                <div class="card-header p-0 position-relative mt-n4 pt-1 z-index-2 rounded-circle my-2">
                  <div class="bg-gradient-primary shadow-primary border-radius-lg panel-circle p-0 mx-auto">
                    <i class="fas fa-user-tie fa-2xl text-white" style="font-size: calc(1em*3); text-shadow: 0px 1px 2px rgba(0,0,0, 0.2), 0px 1px 2px rgba(0,0,0,0.2);"></i>
                  </div>
                </div>
                <div class="card-body" >
                  <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                    @csrf
                    <div class="input-group input-group-outline mt-3 @error('username') is-invalid @enderror">
                      <label class="form-label">{{ __('Username') }}</label>
                      <input type="text" class="form-control" name="username">
                    </div>
                    @error('username')  
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-group input-group-outline mt-3 @error('password') is-invalid @enderror">
                      <label class="form-label">{{ __('Password') }}</label>
                      <input type="password" class="form-control" name="password">
                    </div>
                    @error('password')  
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="form-check form-switch d-flex align-items-center my-3">
                      <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                      <label class="form-check-label mb-0 ms-3" for="rememberMe">{{ __('Remember me') }}</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                    </div>
                    
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer position-absolute bottom-2 py-2 w-100">
          <div class="container">
            <div class="row align-items-center justify-content-lg-between">
        
            </div>
          </div>
        </footer>
      </div>
    </main>
    <!--   Core JS Files   -->
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
 
  </body>
</html>  