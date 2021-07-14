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
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">RGUWB</a></li>
                            <li class="breadcrumb-item active">Coupon Code</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Coupon Information</h4>
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
                                        <form action="{{ URL::to('/coupon-code-save')}}" class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Coupon Name</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Name</label>
                                                    <input type="text" name="coupon_code_name" class="form-control" required="" placeholder="voucher 1">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Coupon Code</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Coupon Code</label>
                                                    <input type="text" name="coupon_code_code" class="form-control" required="" placeholder="Example: COVID">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Coupon Quantity</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Coupon Quantity</label>
                                                    <input type="number" min="1" name="coupon_code_quantity" class="form-control" required="" placeholder="1">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Type Code</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Type Code</label>
                                                    <select name="coupon_code_type" class="form-control">
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
                                                    <input type="number" min="1" name="coupon_code_value" class="form-control" required="" placeholder="1%">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >From Day</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">From Day</label>
                                                    <input type="date" name="coupon_code_from_day" class="form-control" required="">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >To Day</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">To Day</label>
                                                    <input type="date"  name="coupon_code_to_day" class="form-control" required="">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Status</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Status</label>
                                                    <select name="coupon_code_status" class="form-control">
                                                        <option value="1">Show</option>
                                                        <option value="0">Hide</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="text-lg-right mt-3 mt-lg-0">
                                                        <button type="submit" name="coupon_code_add" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Add</button>
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
