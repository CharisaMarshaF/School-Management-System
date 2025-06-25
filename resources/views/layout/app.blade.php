<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ !empty($header_title) ? $header_title : '' }} - School</title>
    <link rel="shortcut icon" href="{{ url('public/assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/icons/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/datatables/datatables.min.css') }}">
    @yield('style')
</head>


<body>

    <div class="main-wrapper">

        @include('layout.header')


        <div class="page-wrapper">
            
            @yield('content')
            @include('layout.footer')
        </div>
    </div>

    <script src="{{ url('public/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('public/assets/js/feather.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ url('public/assets/js/script.js') }}"></script>
    <script src="{{ url('public/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('script')

</body>

</html>