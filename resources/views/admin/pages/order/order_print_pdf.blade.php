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
                                <a href="{{URL::to('/order-show-detail/'.$order->id)}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                                <a href="{{URL::to('/order-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New Order</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                            <li class="breadcrumb-item active">Order Detail</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <!-- Logo & title -->
                            <div class="clearfix">
                                <div class="float-left">
                                    <img src="assets\images\logo-dark.png" alt="" height="20">
                                </div>
                                <div class="float-right">
                                    <h4 class="m-0 d-print-none">Invoice</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <p><b>Hello,
                                            @if($order_customer)
                                                {{ $order_customer->Customer->khachhang_ten}}

                                            @else
                                                {{ $order_delivery->giaohang_nguoi_nhan}}
                                            @endif
                                        </b></p>
                                        <p class="text-muted">Thanks a lot because you keep purchasing our products. Our company
                                            promises to provide high quality products for you as well as outstanding
                                            customer service for every transaction. </p>
                                    </div>

                                </div><!-- end col -->
                                <div class="col-md-4 offset-md-2">
                                    <div class="mt-3 float-right">
                                        <p class="m-b-10"><strong>Order Date : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;{{ $order->dondathang_ngay_dat_hang }}</span></p>
                                        <p class="m-b-10"><strong>Order Status :&nbsp; </strong> <span class="float-right">
                                            @if($order->dondathang_trang_thai==0)
                                                Unprocess
                                            @elseif($order->dondathang_trang_thai==1)
                                            Payment Not Yet Delivered
                                            @elseif($order->dondathang_trang_thai==2)
                                            Processed
                                            @endif
                                        </span></p>
                                        <p class="m-b-10"><strong>Order No. : </strong> <span class="float-right">{{ $order->dondathang_ma_don_dat_hang }}</span></p>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <h5>Billing Address</h5>
                                    <address>
                                            @if($order_customer)
                                                {{ $order_customer->Customer->khachhang_ten}}
                                                <br>
                                                {{ $order_customer->Customer->khachhang_dia_chi}}<br>
                                                <abbr title="Phone">P:</abbr> {{ $order_customer->Customer->khachhang_so_dien_thoai}}
                                                @else
                                                {{ $order_delivery->giaohang_nguoi_nhan}}
                                                <br>
                                                {{ $order_delivery->giaohang_nguoi_nhan_dia_chi}}
                                                <br>
                                                <abbr title="Phone">(84):</abbr> {{ $order_delivery->giaohang_nguoi_nhan_so_dien_thoai}}
                                            @endif
                                    </address>
                                </div> <!-- end col -->

                                <div class="col-sm-6">
                                    <h5>Shipping Address</h5>
                                    <address>
                                        @if(!$order_delivery)
                                            {{ $order_customer->Customer->khachhang_ten}}
                                            <br>
                                            {{ $order_customer->Customer->khachhang_dia_chi}}<br>
                                            <abbr title="Phone">(84):</abbr> {{ $order_customer->Customer->khachhang_so_dien_thoai}}
                                        @else
                                            {{ $order_delivery->giaohang_nguoi_nhan}}
                                            <br>
                                            {{ $order_delivery->giaohang_nguoi_nhan_dia_chi}}
                                            <br>
                                            <abbr title="Phone">(84):</abbr> {{ $order_delivery->giaohang_nguoi_nhan_so_dien_thoai}}
                                    @endif
                                    </address>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-4 table-centered">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th style="width: 20%">Price</th>
                                                <th style="width: 20%">Quantity</th>
                                                <th style="width: 20%" class="text-right">Total</th>
                                            </tr></thead>
                                            <tbody>
                                                @foreach ($order_detail as $key =>$value )
                                                    @foreach ($product as $k =>$pro)
                                                        <tr>
                                                            <td>
                                                                <b>{{ $value->Product->sanpham_ten}}</b> <br>
                                                                {{ $pro->sanpham_mo_ta}},&nbsp;Size: {{ $value->chitietdondathang_size}}
                                                            </td>
                                                            <td>{{number_format($value->chitietdondathang_don_gia ).' VNĐ' }}</td>
                                                            <td>{{ $value->chitietdondathang_so_luong}}</td>
                                                            <td class="text-right">{{number_format($value->chitietdondathang_don_gia * $value->chitietdondathang_so_luong).' VNĐ' }}</td>
                                                        </tr>
                                                        @break
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="clearfix pt-5">
                                        <h6 class="text-muted">Notes:</h6>

                                        <small class="text-muted">
                                           {{ $order->dondathang_ghi_chu }}
                                        </small>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-sm-6">
                                    <div class="float-right">
                                        <p>
                                            <b>Total :</b>&nbsp;&nbsp;&nbsp;
                                                @if($order_coupon)
                                                    @if($order_coupon->makhuyenmai_loai_ma==1)//theo $
                                                    {{number_format($order->dondathang_tong_tien - $order->dondathang_phi_van_chuyen + $order->Coupon->makhuyenmai_gia_tri ).' VNĐ' }}
                                                    @else
                                                        @php
                                                        $old_total=$order->dondathang_tong_tien - $order->dondathang_phi_van_chuyen;
                                                        $percent=100-$order->Coupon->makhuyenmai_gia_tri ;
                                                        @endphp
                                                    {{number_format($old_total +(($old_total*$order->Coupon->makhuyenmai_gia_tri)/$percent)).' VNĐ' }}
                                                    @endif
                                                @else
                                                {{number_format($order->dondathang_tong_tien - $order->dondathang_phi_van_chuyen + $order->dondathang_giam_gia).' VNĐ' }}
                                                @endif

                                        </p>
                                        <p><b>Transport:</b> <span class="float-right">&nbsp;&nbsp;&nbsp;{{number_format($order->dondathang_phi_van_chuyen ).' VNĐ' }}</span></p>
                                        <p>
                                            <b>Discount:</b>
                                            <span class="float-right">
                                                @if($order_coupon)
                                                    @if($order_coupon->makhuyenmai_loai_ma==1)//theo $
                                                    {{number_format($order->Coupon->makhuyenmai_gia_tri).' VNĐ' }}
                                                    @else
                                                    {{number_format($order->Coupon->makhuyenmai_gia_tri).' %' }}
                                                    @endif
                                                @else
                                                    {{number_format($order->dondathang_giam_gia).' VNĐ' }}
                                                @endif
                                            </span>
                                        </p>
                                        <h3 class="total">{{number_format($order->dondathang_tong_tien ).' VNĐ' }} </h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="mt-4 mb-1">
                                <div class="text-right d-print-none">
                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i> Print</a>
                                </div>
                            </div>
                        </div> <!-- end card-box -->
                    </div> <!-- end col -->
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
