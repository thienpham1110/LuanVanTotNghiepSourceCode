@extends('admin.pages.auth.index_auth')
@section('content')
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <a href="index.html">
                                <span><img src="{{asset('public/backend/images/logo-dark.png')}}" alt="" height="22"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                        <?php
                        $message=Session::get('message');
                        if($message){
                            echo '<p class="text-muted">'.$message.'</p>';
                            Session::put('message',null);
                        }
                        ?>
                        </div>
                        <form action="{{ URL::to('admin-dashboard') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group mb-3">
                                <label for="emailaddress">Email address</label>
                                <input name="admin_email" class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input name="admin_password" class="form-control" type="password" required="" id="password" placeholder="Enter your password">
                            </div>
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked="">
                                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button name="login" class="btn btn-primary btn-block" type="submit"> Login </button>
                            </div>

                        </form>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p> <a href="{{URL::to('/resetpass')}}" class="text-primary font-weight-medium ml-1">Forgot your password?</a></p>
                        <p class="text-muted">Login Admin<a href="{{URL::to('/loginadmin')}}" class="text-primary font-weight-medium ml-1">Login</a></p>

                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->
@endsection