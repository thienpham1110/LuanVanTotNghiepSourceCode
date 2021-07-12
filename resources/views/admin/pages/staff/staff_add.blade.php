@extends('admin.index_layout_admin')
@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <li class="d-none d-sm-block">
                                <form class="app-search">
                                    <div class="app-search-box">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fe-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- content -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title">Create Account</h4>
                            <?php
                                $message=Session::get('message');
                                if($message){
                                    echo '<p class="text-muted">'.$message.'</p>';
                                    Session::put('message',null);
                                }
                            ?>
                            <hr>
                            <form action="{{URL::to('/staff-add-save')}}" class="parsley-form" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="pass1">Name<span class="text-danger">*</span></label>
                                    <input name="staff_name" type="text" placeholder="Name" required="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="pass1">Email<span class="text-danger">*</span></label>
                                    <input name="staff_email" type="text" placeholder="Email" required="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="pass1">Password<span class="text-danger">*</span></label>
                                    <input name="staff_password" type="password" placeholder="Password" required="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="passWord2">Confirm Password <span class="text-danger">*</span></label>
                                    <input name="staff_password_confirm" type="password" required="" placeholder="Password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Role</label>
                                    <select name="admin_role" class="form-control">
                                        <option value="1">Admin</option>
                                        <option value="2">Staff</option>
                                        <option value="3">Shipper</option>
                                    </select>
                                </div>

                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div> <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            <!-- end content -->

            <!-- end page title -->
        </div>
        <!-- container -->

    </div>
    <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    2016 - 2019 &copy; Minton theme by <a href="#">Thien</a>
                </div>
                <div class="col-md-6">
                    <div class="text-md-right footer-links d-none d-sm-block">
                        <a href="#">About Us</a>
                        <a href="#">Help</a>
                        <a href="#">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

</div>
@endsection