<div class="footer_area">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer_widget">
                        @if($get_about_us_bottom)
                        <h3>About us</h3>
                        <p>{{ $get_about_us_bottom->cuahang_mo_ta }}</p>
                        <div class="footer_widget_contect">
                            <p><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $get_about_us_bottom->cuahang_dia_chi }}</p>
                            <p><i class="fa fa-mobile" aria-hidden="true"></i> (84+) {{ $get_about_us_bottom->cuahang_so_dien_thoai }}</p>
                            <a href="{{ URL::to('https://mail.google.com/mail')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $get_about_us_bottom->cuahang_email }} </a>
                        </div>
                        @else
                        <h3>About us</h3>
                        <p>RGUWB</p>
                        <div class="footer_widget_contect">
                            <p><i class="fa fa-map-marker" aria-hidden="true"></i></p>
                            <p><i class="fa fa-mobile" aria-hidden="true"></i> (84+)</p>
                            <a href="{{ URL::to('https://mail.google.com/mail')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> </a>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer_widget">
                        <h3>My Account</h3>
                        <ul>
                            @if(Session::get('customer_id')==true)
                            <li><a href="{{ URL::to('/my-account')}}" title="My account">My account</a></li>
                            <li><a href="{{URL::to('/logout-customer')}}" onclick="return confirm('You Sure?')"title="Logout">Logout</a></li>
                            @endif
                            @if(Session::get('customer_id')!=true)
                            <li><a href="{{ URL::to('/login-customer')}}" title="Login">Login</a></li>
                            <li><a href="{{ URL::to('/show-verification-email-customer')}}" title="Login">Register</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer_widget">
                        <h3>Informations</h3>
                        <ul>
                            <li><a href="{{URL::to ('/about-us')}}">About us</a></li>
                            <li><a href="{{URL::to ('/promotion')}}">Promotion</a></li>
                        </ul>
                    </div>
                </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright_area">
                        <p>Copyright &copy; 2018 <a href="#">Pos Coron</a>. All rights reserved. </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer_social text-right">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li></li>
                            <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
