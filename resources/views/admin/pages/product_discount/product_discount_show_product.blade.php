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
                            <li class="breadcrumb-item active">Product Discount</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                                <h4 class="mt-3 mb-3"><span>Discount: </span></h4>
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Title</th>
                                    <th class="font-weight-medium">Number</th>
                                    <th class="font-weight-medium">Time</th>
                                    <th class="font-weight-medium">Status</th>
                                </tr>
                                </thead>
                                <tbody class="font-14">
                                    <tr>
                                        <td>
                                            <a href="javascript: void(0);">
                                                <img src="{{asset('public/uploads/admin/productdiscount/'.$product_discount->khuyenmai_anh)}}" alt="contact-img" title="contact-img" class="rounded-circle avatar-lg img-thumbnail">
                                            </a>
                                        </td>
                                        <td>
                                            {{ $product_discount->khuyenmai_tieu_de}}
                                        </td>
                                        <td>
                                            @if($product_discount->khuyenmai_loai==1)
                                            {{number_format($product_discount->khuyenmai_gia_tri ).' %' }}
                                            @else
                                                {{number_format($product_discount->khuyenmai_gia_tri ).' $' }}
                                            @endif
                                        </td>
                                        <td>
                                            {{number_format( $product_discount->khuyenmai_so_ngay_khuyen_mai ).' Day' }}
                                        </td>
                                        <td>
                                            {{$product_discount->khuyenmai_trang_thai?' On Promotion':' Promotion Ends'}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                                <h4 class="mt-3 mb-3"><span>Product: </span></h4>
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Number Discount</th>
                                    <th class="font-weight-medium">Price</th>
                                    <th class="font-weight-medium">Price Discount</th>
                                    <th class="font-weight-medium">Title</th>
                                    <th class="font-weight-medium">Status</th>
                                    <th class="font-weight-medium">Product Status</th>
                                </tr>
                                </thead>

                                <tbody class="font-14">
                                        @foreach ($all_product as $k =>$value)
                                                <tr>
                                                    <td>
                                                        <a href="javascript: void(0);">
                                                            <img src="{{asset('public/uploads/admin/product/'.$value->sanpham_anh)}}" alt="contact-img" title="contact-img" class="rounded-circle avatar-lg img-thumbnail">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $value->sanpham_ten}}
                                                    </td>
                                                    <td>
                                                        @if($product_discount->khuyenmai_loai==1)
                                                        {{number_format($product_discount->khuyenmai_gia_tri ).' %' }}
                                                        @else
                                                            {{number_format($product_discount->khuyenmai_gia_tri ).' $' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{number_format( $value->sanpham_gia_ban ).' VND' }}
                                                    </td>
                                                    <td>
                                                        @if($product_discount->khuyenmai_loai==1)
                                                        {{number_format( $value->sanpham_gia_ban -(($value->sanpham_gia_ban * $product_discount->khuyenmai_gia_tri)/100) ).' VND' }}
                                                        @else
                                                        {{number_format( $value->sanpham_gia_ban - $product_discount->khuyenmai_gia_tri ).' VND' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $product_discount->khuyenmai_tieu_de }}
                                                    </td>
                                                    <td>
                                                        {{$product_discount->khuyenmai_trang_thai?' On Promotion':' Promotion Ends'}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $quantity=0;
                                                        @endphp
                                                        @foreach ($product_import_in_stock as $in=>$in_stock)
                                                            @if($in_stock->sanpham_id == $value->id)
                                                                @php
                                                                    $quantity+=$in_stock->sanphamtonkho_so_luong_ton;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($quantity>0)
                                                            In Stock
                                                        @else
                                                            Out of stock
                                                        @endif
                                                    </td>
                                                </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
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
