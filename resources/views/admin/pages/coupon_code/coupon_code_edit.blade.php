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
                                <a href="{{URL::to('/coupon-code')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                                <a href="{{URL::to('/coupon-code-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">RGUWB</a></li>
                            <li class="breadcrumb-item active">Coupon Code Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Coupon Code Information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        @foreach ($edit_coupon_code as $key => $coupon_code)
                                        <form action="{{URL::to ('/coupon-code-save-edit/'.$coupon_code->id)}}" class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Coupon Name</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Name</label>
                                                    <input type="text" value="{{ $coupon_code->makhuyenmai_ten_ma }}" name="coupon_code_name" class="form-control" required="" placeholder="voucher 1">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Coupon Code</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Coupon Code</label>
                                                    <input type="text" name="coupon_code_code" value="{{ $coupon_code->makhuyenmai_ma }}" class="form-control" required="" placeholder="Example: COVID">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Coupon Quantity</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Coupon Quantity</label>
                                                    <input type="number" value="{{ $coupon_code->makhuyenmai_so_luong }}" min="1" name="coupon_code_quantity" class="form-control" required="" placeholder="1">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Type Code</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Type Code</label>
                                                    <select name="coupon_code_type" class="form-control">
                                                        <option value="{{ $coupon_code->makhuyenmai_loai_ma }}">{{ $coupon_code->makhuyenmai_loai_ma?'$':'%' }}</option>
                                                        <option value="0">%</option>
                                                        <option value="1">$</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Coupon Number <br> (% / đ)</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Coupon Number</label>
                                                    <input type="number" value="{{ $coupon_code->makhuyenmai_gia_tri }}" min="1" name="coupon_code_value" class="form-control" required="" placeholder="1%">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Status</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Status</label>
                                                    <select name="coupon_code_status" class="form-control">
                                                        <option value="{{ $coupon_code->makhuyenmai_trang_thai }}">{{ $coupon_code->makhuyenmai_trang_thai?'Show':'Hide' }}</option>
                                                        <option value="1">Show</option>
                                                        <option value="0">Hide</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Staff</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Staff</label>
                                                    @foreach ($staff as $key => $st )
                                                        <input type="hidden" value="{{ $st->id }}" name="staff_id" class="form-control" required="">
                                                        <label class="form-control">{{ $st->nhanvien_ho }} {{ $st->nhanvien_ten }}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="text-lg-right mt-3 mt-lg-0">
                                                        <button type="submit"  class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- end col-->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card-box -->
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