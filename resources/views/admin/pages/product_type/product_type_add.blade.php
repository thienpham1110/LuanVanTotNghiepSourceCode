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
                                <a href="{{URL::to('/product-type')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="p-2">
                                    <form action="{{ URL::to('product-type-save') }}" enctype="multipart/form-data" class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" >Product Type Information</label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Name</label>
                                                <input type="text" name="product_type_name" required="" class="form-control" placeholder="Example: AF1,..">
                                                @error('product_type_name')
                                                <p class="alert alert-danger"> {{ $message }}</p>
                                                @enderror
                                                <label class="col-form-label">Description</label>
                                                <textarea name="product_type_description" required="" class="form-control" placeholder="Des.."></textarea>
                                                @error('product_type_description')
                                                <p class="alert alert-danger"> {{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Images</label>
                                            {{--  <div class="col-sm-10">
                                                <div class="fileupload btn btn-primary waves-effect mt-1">
                                                    <span><i class="mdi mdi-cloud-upload mr-1"></i>Upload</span>
                                                    <input type="file" class="upload" name="product_type_img" multiple="" id="files">
                                                </div>
                                                <img width="100px" height="100px" id="image" />
                                            </div>  --}}
                                            <div class="col-sm-10">
                                                <div class="user-image mb-3 text-center">
                                                    <div class="imgPreview" >

                                                    </div>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="upload custom-file-input" required="" accept=".jpeg,.png,.gif,.jpg" name="product_type_img" id="images">
                                                    <label class="custom-file-label" for="images">Choose image</label>
                                                    @error('product_type_img')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="example-email">Status</label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Status</label>
                                                <select name="product_type_status" class="form-control">
                                                    <option value="1">Show</option>
                                                    <option value="0">Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="text-lg-right mt-3 mt-lg-0">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Add</button>
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
