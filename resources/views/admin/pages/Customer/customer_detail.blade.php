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
                            <div class="text-lg-right mt-3 mt-lg-0">
                                <a href="{{URL::to('/customer')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Customer</li>
                        </ol>
                    </div>

                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box text-center">
                            <img src="{{asset('public/uploads/client/customer/'.$customer->khachhang_anh)}}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">{{ $customer->khachhang_ho }}{{ $customer->khachhang_ten }}</h4>
                            <p class="text-muted"></p>
                            {{--  <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button>
                            <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button>  --}}
                            <div class="text-left mt-3">
                                <h4 class="font-13 text-uppercase">About Customer :</h4>
                                <p class="text-muted font-13 mb-3">
                                    Name: {{ $customer->khachhang_ten }}
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2">{{ $customer->khachhang_ho }} {{ $customer->khachhang_ten }}</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Phone Number :</strong><span class="ml-2">{{ $customer->khachhang_so_dien_thoai }}</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">{{ $customer->khachhang_email }}</span></p>
                                <p class="text-muted mb-1 font-13"><strong>Gender :</strong>
                                     <span class="ml-2">
                                        @if($customer->admin_gioi_tinh!=true)
                                            Null
                                        @else
                                            {{ $customer->admin_gioi_tinh?'Male':'Famale' }}
                                        @endif
                                    </span>
                                </p>
                                <p class="text-muted mb-1 font-13"><strong>Address :</strong> <span class="ml-2">{{ $customer->khachhang_dia_chi }}</span></p>
                            </div>
                        </div> <!-- end card-box -->
                    </div> <!-- end col-->
                    <div class="col-lg-8 col-xl-8">
                        <div class="card-box">
                            <h4 class="header-title">customer Information</h4>
                            <hr>
                        <div class="tab-content">
                                <div class="tab-pane show active" id="settings">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstname">First Name</label>
                                                    <input type="text" readonly class="form-control" value="{{ $customer->khachhang_ho }}" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" readonly class="form-control" value="{{ $customer->khachhang_ten }}" required="" >
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Email Address</label>
                                                    <input type="email" class="form-control" value="{{ $customer->khachhang_email }}" readonly required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="userpassword">Phone Number</label>
                                                    <input type="number" readonly class="form-control" value="{{ $customer->khachhang_so_dien_thoai }}" required="" >
                                                </div>
                                            </div>
                                             <!-- end col -->
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Gender </label> <br>
                                                    @if ($customer->khachhang_gioi_tinh==1 || $customer->khachhang_gioi_tinh!=true)
                                                        <div class="custom-control custom-radio">
                                                            <input class=" custom-control-input" type="radio" name="staff_gender" value="1" id="male" checked>
                                                            <label class=" custom-control-label" for="male">Male</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class=" custom-control-input" type="radio" name="staff_gender" value="0" id="female" >
                                                            <label class="custom-control-label" for="female">Female</label>
                                                        </div>
                                                    @else
                                                        <div class="custom-control custom-radio">
                                                            <input class=" custom-control-input" type="radio" name="staff_gender" value="1" id="male" >
                                                            <label class=" custom-control-label" for="male">Male</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class=" custom-control-input" type="radio" name="staff_gender" value="0" id="female" checked>
                                                            <label class="custom-control-label" for="female">Female</label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Address</label>
                                                    <input type="text" readonly class="form-control" value="{{ $customer->khachhang_dia_chi}}" required="">
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{--  <div class="col-sm-10">
                                                        <div class="fileupload btn btn-primary waves-effect mt-1">
                                                            <span><i class="mdi mdi-cloud-upload mr-1"></i>Upload</span>
                                                            <input type="file" class="upload" name="staff_img" multiple="" id="files">
                                                        </div>
                                                        <img width="100px" height="100px" id="image" src="{{asset('public/uploads/admin/staff/'.$staff->admin_anh)}}"/>
                                                    </div>  --}}
                                                    <div class="col-sm-10">
                                                        <label class="col-form-label mt-3 mr-3" >Image</label>
                                                        <img class=" mt-3" width="100px" height="100px" id="image" src="{{asset('public/uploads/client/customer/'.$customer->khachhang_anh)}}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <label class="col-form-label">Status</label>
                                                    <select name="staff_status" class="form-control">
                                                        @if($customer->khachhang_trang_thai==1)
                                                            <option selected value="1">Show</option>
                                                            <option value="0">Hide</option>
                                                        @else
                                                            <option value="1">Show</option>
                                                            <option selected value="0">Hide</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <!-- end settings content-->
                            </div> <!-- end tab-content -->
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->
                </div>
                <!-- end row-->
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
