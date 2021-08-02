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
                                <a href="{{URL::to('/about-store')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Quay Lại Cửa Hàng</a>
                                <a href="{{URL::to('/about-store-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i>Thêm Mới</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">RGUWB</a></li>
                            <li class="breadcrumb-item active">Cập Nhật Thông Tin Cửa Hàng</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Thông Tin Cửa Hàng</h4>
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
                                        <form action="{{ URL::to('/about-store-save-edit/'.$about_store->id)}}" enctype="multipart/form-data" class="form-horizontal" role="form"  method="post">
                                           {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Thông Tin Cửa Hàng</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Cửa Hàng</label>
                                                    <input type="text" value="{{ $about_store->cuahang_tieu_de }}" name="about_store_title" required="" class="form-control" placeholder="Tên cửa hàng">
                                                    @error('about_store_title')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">Mô Tả</label>
                                                    <input type="text" value="{{ $about_store->cuahang_mo_ta }}" name="about_store_description" required="" class="form-control" placeholder="Mô tả">
                                                    @error('about_store_description')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">Địa Chỉ</label>
                                                    <input type="text" value="{{ $about_store->cuahang_dia_chi }}" name="about_store_address" required="" class="form-control" placeholder="Địa chỉ">
                                                    @error('about_store_address')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">Số Điện Thoại</label>
                                                    <input type="number" value="{{ $about_store->cuahang_so_dien_thoai }}" name="about_store_phone_number" required="" class="form-control" placeholder="Số điện thoại">
                                                    @error('about_store_phone_number')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">Email</label>
                                                    <input type="text" name="about_store_email" value="{{ $about_store->cuahang_email }}"  required="" class="form-control" placeholder="Email">
                                                    @error('about_store_email')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                    <label class="col-form-label">Thứ Tự</label>
                                                    <input type="number" min="1" name="about_store_number" value="{{ $about_store->cuahang_thu_tu }}"  required="" class="form-control" placeholder="Thứ tự hiển thị">
                                                    @error('about_store_number')
                                                    <p class="alert alert-danger"> {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Trạng Thái</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Trạng Thái</label>
                                                    <select name="about_store_status" class="form-control">
                                                        @if($about_store->cuahang_trang_thai==1)
                                                            <option selected value="1">Hiển Thị</option>
                                                            <option value="0">Ẩn</option>
                                                        @else
                                                            <option value="1">Hiển Thị</option>
                                                            <option selected value="0">Ẩn</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Ảnh</label>
                                                {{--  <div class="col-sm-10">
                                                    <div class="fileupload btn btn-primary waves-effect mt-1">
                                                        <span><i class="mdi mdi-cloud-upload mr-1"></i>Upload</span>
                                                        <input type="file" value="{{ $about_store->cuahang_anh }}" class="upload" name="about_store_img" multiple="" id="files">
                                                    </div>
                                                    <img width="100px" height="100px" id="image" src="{{asset('public/uploads/admin/aboutstore/'.$about_store->cuahang_anh)}}" />
                                                </div>  --}}
                                                <div class="col-sm-10">
                                                    <div class="user-image mb-3 text-center">
                                                        <div class="imgPreview" >

                                                        </div>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="upload custom-file-input" accept=".jpeg,.png,.gif,.jpg" value="{{ $about_store->cuahang_anh }}" name="about_store_img" id="images">
                                                        <label class="custom-file-label" for="images">Chọn Ảnh</label>
                                                    </div>
                                                    <label class="col-form-label mt-3">Ảnh</label>
                                                    <img class=" mt-3" width="100px" height="100px" id="image" src="{{asset('public/uploads/admin/aboutstore/'.$about_store->cuahang_anh)}}" />
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
