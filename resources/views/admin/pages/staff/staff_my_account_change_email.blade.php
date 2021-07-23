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
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">RGUWB</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title">Change Password</h4>
                            <p class="sub-header">
                            <hr>
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {!! session()->get('message') !!}
                                    {!! session()->forget('message') !!}
                                </div>
                            @elseif(session()->has('error'))
                                <div class="alert alert-danger">
                                    {!! session()->get('error') !!}
                                    {!! session()->forget('error') !!}
                                </div>
                            @endif
                            </p>
                            <form action="{{URL::to('/staff-my-account-change-email-save')}}" class="parsley-form" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="pass1">Email<span class="text-danger">*</span></label>
                                    <input id="pass1" name="staff_email" type="email" placeholder="Email" required="" class="form-control">
                                    @error('staff_email')
                                    <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pass1">New Email<span class="text-danger">*</span></label>
                                    <input id="pass1" name="staff_new_email" type="email" placeholder="Password" required="" class="form-control">
                                    @error('staff_new_email')
                                    <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pass1">Password<span class="text-danger">*</span></label>
                                    <input id="pass1" name="staff_password" type="password" placeholder="Password" required="" class="form-control">
                                    @error('staff_password')
                                    <p class="alert alert-danger"> {{ $message }}</p>
                                    @enderror
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
    @include('admin.blocks.footer_admin')
    <!-- end Footer -->
</div>
@endsection
