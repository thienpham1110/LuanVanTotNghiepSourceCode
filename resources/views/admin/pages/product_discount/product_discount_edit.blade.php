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
                                <a href="{{URL::to('/product-discount')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                                <a href="{{URL::to('/product-discount-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Product Discount Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Product Discount</h4>
                            <hr>
                            <?php
                                $message=Session::get('message');
                                if($message){
                                    echo '<p class="text-muted">'.$message.'</p>';
                                    Session::put('message',null);
                                }
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                            <form action="{{URL::to('/product-discount-edit-save/'.$discount->id)}}" enctype="multipart/form-data" method="POST" class="form-horizontal">
                                                {{ csrf_field() }}
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                    <div class="card-body">
                                                        <label class="col-form-label">Title</label>
                                                        <input type="text" name="product_discount_title" required="" value="{{ $discount->khuyenmai_tieu_de }}" class="form-control product_discount_title" placeholder="12/12">
                                                        <label class="col-form-label">Time</label>
                                                        <input type="number" name="product_discount_time" required="" value="{{ $discount->khuyenmai_so_ngay_khuyen_mai }}" class="form-control product_discount_time" placeholder="10.Day">
                                                        <label class=" col-form-label">Day Discount</label>
                                                        <input type="date" name="product_discount_day" required="" value="{{ $discount->khuyenmai_ngay_khuyen_mai }}" class="form-control " >
                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label class="col-form-label">Type Discount</label>
                                                                <select name="product_discount_type" required=""  class="form-control product_discount_type">
                                                                    @if($discount->khuyenmai_loai==1)
                                                                        <option selected value="1">%</option>
                                                                        <option value="0">$</option>
                                                                    @else
                                                                        <option value="1">%</option>
                                                                        <option selected value="0">$</option>
                                                                    @endif
                                                                </select>
                                                                <label class="col-form-label">Discount</label>
                                                                <input type="number" min="1" name="product_discount_number" value="{{ $discount->khuyenmai_gia_tri }}" required="" class="form-control product_discount_number" placeholder="10%,..">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label class="col-form-label">Content</label>
                                                                <textarea class="form-control product_discount_content" required="" name="product_discount_content"  placeholder="Content..">{{ $discount->khuyenmai_noi_dung }}</textarea>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label class="col-form-label">Images</label>
                                                                <div class="fileupload btn btn-primary waves-effect mt-1">
                                                                    <span><i class="mdi mdi-cloud-upload mr-1"></i>Upload</span>
                                                                    <input type="file" class="upload product_discount_img" value="{{ $discount->khuyenmai_anh }}" name="product_discount_img"  id="files">
                                                                    <input type="hidden" name="product_discount_img_old" value="{{ $discount->khuyenmai_anh }}">
                                                                </div>
                                                                <img width="100px" height="100px" id="image"  src="{{asset('public/uploads/admin/productdiscount/'.$discount->khuyenmai_anh)}}"/>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label class="col-form-label">Status</label>
                                                                <select name="product_discount_status" required="" class="form-control product_discount_status">
                                                                    @if($discount->khuyenmai_trang_thai==1)
                                                                        <option selected value="1">Yes</option>
                                                                        <option value="0">No</option>
                                                                    @else
                                                                        <option value="1">Yes</option>
                                                                        <option selected value="0">No</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="header-title">Product List</h4>
                                                            <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Selective</th>
                                                                        <th>Name</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($product_dis as $key=> $product)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" name="product_discount_product_id[{{$product->id}}]" value="{{ $product->id }}" checked="true">
                                                                            </td>
                                                                            <td>{{$product->sanpham_ten }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    @foreach ($product_no_dis as $key => $product)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" name="product_discount_product_id[{{$product->id}}]" value="{{ $product->id }}" ></input>
                                                                            </td>
                                                                            <td>{{$product->sanpham_ten }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div> <!-- end card body-->
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="text-lg-right mt-3 mt-lg-0">
                                                        <button type="submit" class=" btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
