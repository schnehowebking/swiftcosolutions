@php
//    $logo = asset(Storage::url('uploads/logo/'));
$logo=\App\Models\Utility::get_file('uploads/logo/');

$company_favicon = Utility::getValByName('company_favicon');
// $setting = App\Models\Utility::settings();
$company_logo = App\Models\Utility::get_superadmin_logo();
$SITE_RTL=env('SITE_RTL');
// dd($SITE_RTL);
$setting = App\Models\Utility::colorset();

$color = (!empty($setting['theme_color'])) ? $setting['theme_color'] : 'theme-3';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$SITE_RTL == 'on'?'rtl':''}}">

<head>
    <title>
        {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'HRMGo') }}
        - @yield('page-title')</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{$logo.'/'.(isset($favicon) && !empty($favicon)?$favicon:'favicon.png')}}" type="image/x-icon" />
     @stack('head')
      <!-- for calender-->
      <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

      <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
      <!-- font css -->
      <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

      @if($SITE_RTL=='on') 
      <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
      @else
       <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" id="main-style-link">
    @endif

</head>
<body class={{$color}}>
  <!-- [ Pre-loader ] start -->
  <!-- [ Mobile header ] End -->



<!-- [ Main Content ] start -->
<div class="container">
    <div class="dash-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
              <div class="page-block">
                  <div class="row align-items-center">
                      <div class="col-md-12 mt-5 mb-4">
                          <div class="d-block d-sm-flex align-items-center justify-content-between">
                              <div>
                                

                                 <!--  <ul class="breadcrumb">
                                      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                      <li class="breadcrumb-item">General Statistics</li>
                                  </ul> -->
                              </div>
                              <div>
                                @yield('action-button')
                              </div>
                              
                          </div>
                      </div>
                  </div>
              </div>
          </div>

        <!-- <div class="row"> -->
               @yield('content')
        
        <!-- </div> -->

    </div>
</div>

<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>

<script src="{{ asset('js/letter.avatar.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/custom.js') }}"></script>

<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

<!-- <script>
  if ($(".pc-dt-simple").length) {
    const dataTable = new simpleDatatables.DataTable(".pc-dt-simple");
  }
</script> -->

@stack('script-page')

</body>

<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body">
                </div>
            </div>
        </div>
    </div>

</html>