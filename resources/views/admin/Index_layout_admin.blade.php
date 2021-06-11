<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>RGUWB Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('public/backend/images\favicon.png')}}">
    <!-- App css -->
    <link href="{{asset('public/backend/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/css/icons.min.css')}}"rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/css/app.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/multiselect/multi-select.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/clockpicker/bootstrap-clockpicker.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/libs/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <link href="{{asset('public/backend/libs/footable/footable.core.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/custombox/custombox.min.css')}}" rel="stylesheet">

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        @include('admin.blocks.header_admin')
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.blocks.menu_admin')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <script src="{{asset('public/backend/js/vendor.min.js')}}"></script>
	<script src="{{asset('public/backend/js/app.min.js')}}"></script>

    <script src="{{asset('public/backend/js/pages/form-fileuploads.init.js')}}"></script>
	<script src="{{asset('public/backend/js/pages/form-advanced.init.js')}}"></script>
	<script src="{{asset('public/backend/js/pages/form-pickers.init.js')}}"></script>

	<script src="{{asset('public/backend/libs/jquery-quicksearch/jquery.quicksearch.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/clockpicker/bootstrap-clockpicker.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/moment/moment.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <script src="{{asset('public/backend/libs/dropzone/dropzone.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/multiselect/jquery.multi-select.js')}}"></script>
    <script src="{{asset('public/backend/libs/select2/select2.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/custombox/custombox.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/footable/footable.all.min.js')}}"></script>
	<script src="{{asset('public/backend/js/pages/foo-tables.init.js')}}"></script>

</body>

</html>
