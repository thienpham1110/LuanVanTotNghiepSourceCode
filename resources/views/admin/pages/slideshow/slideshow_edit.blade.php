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
                                <a href="{{URL::to('/slideshow')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                                <a href="{{URL::to('/slideshow-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i>Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">RGUWB</a></li>
                            <li class="breadcrumb-item active">Slideshow News Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Slideshow News Information</h4>
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
                                        <form action="{{ URL::to('/slideshow-save-edit/'.$slideshow->id)}}" enctype="multipart/form-data" class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                           {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Slideshow News Information</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Title</label>
                                                    <input type="text" value="{{ $slideshow->slidequangcao_tieu_de }}" name="slideshow_title" required="" class="form-control" placeholder="KM">
                                                    @error('slideshow_title')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">Content</label>
                                                    <input type="text" value="{{ $slideshow->slidequangcao_noi_dung }}" name="slideshow_content" required="" class="form-control" placeholder="KM ND">
                                                    @error('slideshow_content')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">Link</label>
                                                    <input type="text" value="{{ $slideshow->slidequangcao_lien_ket }}"  name="slideshow_link" required="" class="form-control" placeholder="http://...">
                                                    @error('slideshow_link')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">No.</label>
                                                    <input type="number" value="{{ $slideshow->slidequangcao_thu_tu }}"  min="1" name="slideshow_no" required="" class="form-control" placeholder="1">
                                                    @error('slideshow_no')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Status</label>
                                                    <select name="slideshow_status" class="form-control">

                                                        @if( $slideshow->slidequangcao_trang_thai ==1)
                                                            <option selected value="1">Show</option>
                                                            <option value="0">Hide</option>
                                                        @else
                                                            <option value="1">Show</option>
                                                            <option selected value="0">Hide</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Images</label>
                                                {{--  <div class="col-sm-10">
                                                    <div class="fileupload btn btn-primary waves-effect mt-1">
                                                        <span><i class="mdi mdi-cloud-upload mr-1"></i>Upload</span>
                                                        <input type="file" value="{{ $slideshow->slidequangcao_anh }}"  name="slideshow_img" class="upload" multiple="" id="files">
                                                    </div>
                                                    <img width="100px" height="100px" id="image" src="{{asset('public/uploads/admin/slideshow/'.$slideshow->slidequangcao_anh)}}" />
                                                </div>  --}}
                                                <div class="col-sm-10">
                                                    <div class="user-image mb-3 text-center">
                                                        <div class="imgPreview" >

                                                        </div>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="upload custom-file-input" accept=".jpeg,.png,.gif,.jpg" value="{{ $slideshow->slidequangcao_anh }}"  name="slideshow_img" id="images">
                                                        <label class="custom-file-label" for="images">Choose image</label>
                                                        @error('slideshow_img')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    </div>
                                                    <label class="col-form-label mt-3">Old image</label>
                                                    <img class=" mt-3" width="100px" height="100px" id="image" src="{{asset('public/uploads/admin/slideshow/'.$slideshow->slidequangcao_anh)}}" />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="text-lg-right mt-3 mt-lg-0">
                                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Save</button>
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
                    </div> <!-- end card-box -->
                </div><!-- end col -->
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
