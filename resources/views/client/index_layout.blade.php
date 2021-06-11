<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>RGUWB Shop</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/img/favicon.png')}}">

		<!-- all css here -->
        <link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/plugin.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/bundle.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/responsive.css')}}">
        <script src="{{asset('public/frontend/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    </head>
    <body>
            <!-- Add your site or application content here -->

            <!--pos page start-->
            <div class="pos_page">
                <div class="container">
                   <!--pos page inner-->
                    <div class="pos_page_inner">
                       <!--header area -->
                        <div class="header_area">
                               <!--header top-->

                               @include('client.blocks.header')

                                <!--header middel end-->
                           <!-- menu -->

                           @include('client.blocks.menu')

                           <!-- end menu -->
                        </div>
                        <!--header end -->
                        <!-- content -->
                        <!--pos home section-->

                        @yield('content')

                        <!--pos home section end-->
                        <!-- end content -->
                    </div>
                    <!--pos page inner end-->
                </div>
            </div>
            <!--pos page end-->

            <!--footer area start-->
            @include('client.blocks.footer')
            <!--footer area end-->
		<!-- all js here -->
        <script src="{{asset('public/frontend/js/vendor/jquery-1.12.0.min.js')}}"></script>
        <script src="{{asset('public/frontend/js/popper.js')}}"></script>
        <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('public/frontend/js/bootstrap.js')}}"></script>
        <script src="{{asset('public/frontend/js/ajax-mail.js')}}"></script>
        <script src="{{asset('public/frontend/js/plugins.js')}}"></script>
        <script src="{{asset('public/frontend/js/main.js')}}"></script>
    </body>
</html>
