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
                                <a href="index_save_add.php" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save mr-1"></i>Save</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div>

                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="card-box text-center">
                            <img src="assets\images\users\avatar-1.jpg" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                            <h4 class="mb-0">Phạm Hồng Thiên</h4>
                            <p class="text-muted">@webdesigner</p>
                            <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Follow</button>
                            <button type="button" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Message</button>
                            <div class="text-left mt-3">
                                <h4 class="font-13 text-uppercase">About Me :</h4>
                                <p class="text-muted font-13 mb-3">
                                    Hi I'm' Thiên.
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2">Phạm Hồng Thiên</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Phone Number :</strong><span class="ml-2">(123)
                                        123 1234</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">user@email.domain</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Gender :</strong> <span class="ml-2">Nam</span></p>
                                <p class="text-muted mb-1 font-13"><strong>Address :</strong> <span class="ml-2">H027</span></p>
                                <p class="text-muted mb-1 font-13"><strong>ID Number :</strong> <span class="ml-2">301713838</span></p>
                                <p class="text-muted mb-1 font-13"><strong>Working Day :</strong> <span class="ml-2">1/1/2021</span></p>
                            </div>
                        </div> <!-- end card-box -->


                    </div> <!-- end col-->

                    <div class="col-lg-8 col-xl-8">
                        <div class="card-box">
                            <h4 class="header-title">Customer Information</h4>
                            <hr>
                        <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form action="/" class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="firstname">First Name</label>
                                                    <input type="text" class="form-control" id="firstname" placeholder="Enter first name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last Name</label>
                                                    <input type="text" class="form-control" id="lastname" placeholder="Enter last name">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Email Address</label>
                                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="userpassword">Phone Number</label>
                                                    <input type="number" class="form-control" id="userpassword" placeholder="Enter phone number">
                                                </div>
                                            </div>
                                             <!-- end col -->
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Gender </label> <br>
                                                    <div class="custom-control custom-radio">
                                                        <input class=" custom-control-input" type="radio" name="gender" id="male" checked>
                                                        <label class=" custom-control-label" for="male">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class=" custom-control-input" type="radio" name="gender" id="female" >
                                                        <label class="custom-control-label" for="female">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useremail">Address</label>
                                                    <input type="text" class="form-control" id="useremail" placeholder="HCM...">
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group dropzone">
                                                <div class="fallback">
                                                        <input name="file" type="file" multiple="">
                                                    </div>

                                                    <div class="dz-message needsclick">
                                                        <p class="h1 text-muted"><i class="mdi mdi-cloud-upload"></i></p>
                                                        <h3>Drop files here or click to upload.</h3>
                                                    </div>
                                                    <div class="dropzone-previews mt-3" id="file-previews"></div>
                                                    <div class="d-none" id="uploadPreviewTemplate">
                                                        <div class="card mt-1 mb-0 shadow-none border">
                                                            <div class="p-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <img data-dz-thumbnail="" class="avatar-sm rounded bg-light" alt="">
                                                                    </div>
                                                                    <div class="col pl-0">
                                                                        <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name=""></a>
                                                                        <p class="mb-0" data-dz-size=""></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <!-- Button -->
                                                                        <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove="">
                                                                            <i class="mdi mdi-close-circle"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <!-- end col -->
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <label class="col-form-label">Status</label>
                                                    <select name="Sex" class="form-control">
                                                        <option>---#---</option>
                                                        <option>A</option>
                                                        <option>B</option>
                                                        <option>C</option>
                                                        <option>D</option>
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
