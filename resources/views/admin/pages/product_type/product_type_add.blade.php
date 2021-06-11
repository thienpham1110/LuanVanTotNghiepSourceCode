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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">RGUWB</a></li>
                            <li class="breadcrumb-item active">Product Type</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title">Product Type Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="p-2">
                                    <form action="{{ URL::to('product-type-save') }}" class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" >Product Type Information</label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Name</label>
                                                <input type="text" name="product_type_name" id="simpleinput" class="form-control" placeholder="Example: AF1,..">

                                                <label class="col-form-label">Description</label>
                                                <textarea name="product_type_description" class="form-control" placeholder="Des.."></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="example-fileinput">Images</label>
                                            <div class="col-sm-10 dropzone">
                                                <div class="fallback">
                                                    <input name="product_type_img" type="file" multiple="">
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
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="example-email">Status</label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Status</label>
                                                <select name="product_type_status" class="form-control">
                                                    <option value="0">Ẩn</option>
                                                    <option value="1">Sử Dụng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="text-lg-right mt-3 mt-lg-0">
                                                    <button type="submit" name="product_type_add" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Add Type</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card-box -->
            </div><!-- end row -->
        </div><!-- end col -->

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
<script src="{{asset('public/backend/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('public/backend/js/pages/form-fileuploads.init.js')}}"></script>
@endsection
