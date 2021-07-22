<!doctype html>
<html lang="en">
   <head>
      <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

      <!--     Fonts and icons     -->
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

      <script src="https://kit.fontawesome.com/7ce00bbc69.js" crossorigin="anonymous"></script>
      <!-- Material Kit CSS -->
      <link href="{{ asset("assets/css/material-dashboard.css?v=2.1.2") }}" rel="stylesheet" />

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
       <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

      <link href="{{ asset("css/app.css") }}?{{ date("YmdHis") }}" rel="stylesheet" />

      @yield('css')

   </head>
   <body>

    {{--  Modal to loader  --}}
    <div class="backLoader">
        <div class="loader">
            <img src="{{ asset('images/loader.gif') }}" alt="">
            <div class="percentage"></div>
        </div>
    </div>


    <div class="wrapper ">

        @include('layouts.admin._sidebar')


        <div class="main-panel">

        @include('layouts.admin._navbar')
        <div class="content">
            @yield('content')
        </div>
        </div>

    </div>


      <!--   Core JS Files   -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>

      <script src="{{ asset("assets/js/core/popper.min.js") }}"></script>
      <script src="{{ asset("assets/js/core/bootstrap-material-design.min.js") }}"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>


      <script src="{{ asset("assets/js/plugins/perfect-scrollbar.jquery.min.js") }}"></script>

      <!-- Plugin for the momentJs  -->
      {{-- <script src="{{ asset("assets/js/plugins/moment.min.js") }}"></script> --}}

      <!--  Plugin for Sweet Alert -->
      {{-- <script src="{{ asset("assets/js/plugins/sweetalert2.js") }}"></script> --}}

      <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
      {{-- <script src="{{ asset("assets/js/plugins/bootstrap-selectpicker.js") }}"></script> --}}

      <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
      {{-- <script src="{{ asset("assets/js/plugins/bootstrap-datetimepicker.min.js") }}"></script> --}}

      <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
      {{-- <script src="{{ asset("assets/js/plugins/jquery.dataTables.min.js") }}"></script> --}}

      <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
      {{-- <script src="{{ asset("assets/js/plugins/bootstrap-tagsinput.js") }}"></script> --}}

      <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
      {{-- <script src="{{ asset("assets/js/plugins/jasny-bootstrap.min.js") }}"></script> --}}

      <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
      {{-- <script src="{{ asset("assets/js/plugins/fullcalendar.min.js") }}"></script> --}}

      <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
      {{-- <script src="{{ asset("assets/js/plugins/jquery-jvectormap.js") }}"></script> --}}

      <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
      {{-- <script src="{{ asset("assets/js/plugins/nouislider.min.js") }}"></script> --}}

      <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
      {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> --}}

      <!-- Library for adding dinamically elements -->
      {{-- <script src="{{ asset("assets/js/plugins/arrive.min.js") }}"></script> --}}

      <!--  Google Maps Plugin    -->
      {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}

      <!-- Chartist JS -->
      {{-- <script src="{{ asset("assets/js/plugins/chartist.min.js") }}"></script> --}}

      <!--  Notifications Plugin    -->
      {{-- <script src="{{ asset("assets/js/plugins/bootstrap-notify.js") }}"></script> --}}

      <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
      <script src="{{ asset("assets/js/material-dashboard.js?v=2.1.2") }}" type="text/javascript"></script>

      <!-- Material Dashboard DEMO methods, don't include it in your project! -->
      {{-- <script src="{{ asset("assets/demo/demo.js") }}"></script> --}}

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

      @yield('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
   </body>
</html>
