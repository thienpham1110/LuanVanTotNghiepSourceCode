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
                                <a href="{{URL::to('/staff')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">My Account</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box text-center">
                            <img src="{{asset('public/uploads/admin/staff/'.$staff->admin_anh)}}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">{{ $staff->admin_ho }}{{ $staff->admin_ten }}</h4>
                            <p class="text-muted"></p>
                            {{--  <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button>
                            <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button>  --}}
                            <div class="text-left mt-3">
                                <h4 class="font-13 text-uppercase">About Me :</h4>
                                <p class="text-muted font-13 mb-3">
                                    Hi I'm' {{ $staff->admin_ten }}.
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2">{{ $staff->admin_ho }} {{ $staff->admin_ten }}</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Phone Number :</strong><span class="ml-2">{{ $staff->admin_so_dien_thoai }}</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">{{ $staff->admin_email }}</span></p>
                                <p class="text-muted mb-1 font-13"><strong>Gender :</strong>
                                     <span class="ml-2">
                                        @if($staff->admin_gioi_tinh!=true)
                                            Null
                                        @else
                                            {{ $staff->admin_gioi_tinh?'Male':'Famale' }}
                                        @endif
                                    </span>
                                </p>
                                <p class="text-muted mb-1 font-13"><strong>Address :</strong> <span class="ml-2">{{ $staff->admin_dia_chi }}</span></p>
                                <p class="text-muted mb-1 font-13"><strong>ID Number :</strong>
                                    <span class="ml-2">
                                        {{ $staff->admin_id }}
                                    </span>
                                </p>
                                <p class="text-muted mb-1 font-13"><strong>Working Day :</strong> <span class="ml-2"> {{ $staff->admin_ngay_vao_lam }}</span></p>
                            </div>
                        </div> <!-- end card-box -->
                    </div> <!-- end col-->
                    <div class="col-lg-8 col-xl-8">
                        <div class="card-box">
                            <h4 class="header-title">Staff Information</h4>
                            <hr>
                        <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form action="{{URL::to('/staff-update-my-account/'.$staff->id)}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstname">First Name</label>
                                                    <input type="text" name="staff_first_name" class="form-control" value="{{ $staff->admin_ho }}" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" name="staff_last_name" class="form-control" value="{{ $staff->admin_ten }}" required="" >
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Email Address</label>
                                                    <input type="email" class="form-control" value="{{ $staff->admin_email }}" readonly required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="userpassword">Phone Number</label>
                                                    <input type="number" name="staff_phone_number" class="form-control" value="{{ $staff->admin_so_dien_thoai }}" required="" >
                                                </div>
                                            </div>
                                             <!-- end col -->
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Gender </label> <br>
                                                    @if ($staff->admin_gioi_tinh==1 || $staff->admin_gioi_tinh!=true)
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
                                                    <input type="text" name="staff_address" class="form-control" value="{{ $staff->admin_dia_chi}}" required="">
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
                                                        <div class="user-image mb-3 text-center">
                                                            <div class="imgPreview" >

                                                            </div>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="upload custom-file-input" value="{{ $staff->admin_anh }}" name="staff_img" id="images">
                                                            <label class="custom-file-label" for="images">Choose image</label>
                                                        </div>
                                                        <label class="col-form-label mt-3">Old image</label>
                                                        <img class=" mt-3" width="100px" height="100px" id="image" src="{{asset('public/uploads/admin/staff/'.$staff->admin_anh)}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">ID Number</label>
                                                    <input type="text" name="staff_admin_id" class="form-control" value="{{ $staff->admin_id}}" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <label class="col-form-label">Status</label>
                                                    <select name="staff_status" class="form-control">
                                                        @if($staff->admin_trang_thai==1)
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
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                        </div>
                                    </form>
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
