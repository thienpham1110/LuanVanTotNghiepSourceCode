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
                                <a href="{{URL::to('/product-import')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                                <a href="{{URL::to('/product-import-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Order ShowDetail</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title">Product Import</h4>
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
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <label class="col-form-label"> <h4> Customer Information</h4></label>
                                                    <div class="table-responsive" id="ajax-queue">
                                                        <table class="table table-hover  mb-0">
                                                            <thead>
                                                            <tr>
                                                                <td>User Name</td>
                                                                <td>Name</td>
                                                                <td>Phone Number</td>
                                                                <td>Email</td>
                                                                <td>Address</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if($order_customer)
                                                                    <tr>
                                                                        <td >{{ $order_customer->UserAccount->user_ten}} </td>
                                                                        <td>{{ $order_customer->khachhang_ho.''.$order_customer->khachhang_ten}}</td>
                                                                        <td>{{$order_customer->khachang_so_dien_thoai }}</td>
                                                                        <td>{{ $order_customer->khachhang_email}}</td>
                                                                        <td>{{$order_customer->khachhang_dia_chi }}</td>
                                                                    </tr>
                                                                @else
                                                                <tr>
                                                                    <td ></td>
                                                                    <td></td>
                                                                    <td><h4>No Infomation</h4></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                            <label class="col-form-label"> <h4> Order Information</h4></label>
                                            <div class="table-responsive" id="ajax-queue">
                                                <table class="table table-hover  mb-0">
                                                    <thead>
                                                    <tr>
                                                        <td>Order No.</td>
                                                        <td>Order Day</td>
                                                        <td>Status Delivery</td>
                                                        <td>Status Payment</td>
                                                        <td>Discount</td>
                                                        <td>Transport</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody >
                                                        <tr>
                                                            <td>{{ $order->dondathang_ma_don_dat_hang}}</td>
                                                            <td >{{ $order->dondathang_ngay_dat_hang }} </td>
                                                            <td>
                                                                @if($order->dondathang_tinh_trang_giao_hang==0)
                                                                Not Delivered
                                                                @elseif ($order->dondathang_tinh_trang_giao_hang==1)
                                                                    Delivered
                                                                @elseif ($order->dondathang_tinh_trang_giao_hang==2)
                                                                    Order Has Been Canceled
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($order->dondathang_tinh_trang_thanh_toan==0)
                                                                    Unpaid
                                                                @elseif ($order->dondathang_tinh_trang_thanh_toan==1)
                                                                    Paid
                                                                @elseif ($order->dondathang_tinh_trang_thanh_toan==2)
                                                                    Order Has Been Canceled
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($order_coupon)
                                                                    @if($order_coupon->makhuyenmai_loai_ma==1)//theo $
                                                                    {{number_format($order->Coupon->makhuyenmai_gia_tri  ).' VNĐ' }}
                                                                    @else
                                                                    {{number_format($order->Coupon->makhuyenmai_gia_tri  ).' %' }}
                                                                    @endif
                                                                @else
                                                                    {{number_format($order->dondathang_giam_gia  ).' VNĐ' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{number_format($order->dondathang_phi_van_chuyen ).' VNĐ' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <label class="col-form-label"> <h4> Delivery Information</h4></label>
                                                        <div class="table-responsive" id="ajax-queue">
                                                            <table class="table table-hover  mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <td>Customer</td>
                                                                    <td>Email</td>
                                                                    <td>Phone Number</td>
                                                                    <td>Address</td>
                                                                    <td>Pay Method</td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>{{ $order_delivery->giaohang_nguoi_nhan}}</td>
                                                                        <td >{{ $order_delivery->giaohang_nguoi_nhan_email }} </td>
                                                                        <td>{{$order_delivery->giaohang_nguoi_nhan_so_dien_thoai }}</td>
                                                                        <td>{{ $order_delivery->giaohang_nguoi_nhan_dia_chi }}</td>
                                                                        <td>{{$order_delivery->giaohang_phuong_thuc_thanh_toan?'Bank Transfer':'COD' }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <label class="col-form-label">Product Import</label>
                                                    <div class="table-responsive" id="ajax-queue">
                                                        <table class="table table-hover  mb-0">
                                                            <thead>
                                                            <tr>
                                                                <td>Product</td>
                                                                <td>Quantity</td>
                                                                <td>Price</td>
                                                                <td>Size</td>
                                                                <td>Total</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $sub_total=0;
                                                                @endphp
                                                                @foreach ($order_detail as $key=> $product )
                                                                    <tr>
                                                                        <td>{{ $product->Product->sanpham_ten}}</td>
                                                                        <td >{{ $product->chitietdondathang_so_luong }} </td>
                                                                        <td>{{number_format($product->chitietdondathang_don_gia ).' VNĐ' }}</td>
                                                                        <td>{{ $product->Size->size }}</td>
                                                                        <td>{{number_format($product->chitietdondathang_so_luong * $product->chitietdondathang_don_gia ).' VNĐ' }}</td>
                                                                    </tr>
                                                                    @php
                                                                    $sub_total+=($product->chitietdondathang_so_luong * $product->chitietdondathang_don_gia );
                                                                    @endphp

                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{URL::to('/order-edit-save/'.$order->id)}}" class="form-horizontal">
                                        {{ csrf_field() }}
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-form-label"><h4>Delivery Infomation</h4></label>
                                            <div class="card">
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label class="col-form-label">Order Status</label>
                                                        <select name="order_status" required="" class="form-control order_status">
                                                            @if($order->dondathang_tinh_trang_thanh_toan==0)
                                                                <option selected=true value="0">Unprocess</option>
                                                                <option value="1">Payment Not Yet Delivered</option>
                                                                <option value="2">Processed</option>
                                                            @elseif($order->dondathang_tinh_trang_thanh_toan==1 && $order->dondathang_tinh_trang_giao_hang==0)
                                                                <option value="0">Unprocess</option>
                                                                <option selected=true value="1">Payment Not Yet Delivered</option>
                                                                <option value="2">Processed</option>
                                                            @elseif($order->dondathang_tinh_trang_giao_hang==1)
                                                                <option value="0">Unprocess</option>
                                                                <option value="1">Payment Not Yet Delivered</option>
                                                                <option selected=true value="2">Processed</option>
                                                            @elseif($order->dondathang_trang_thai==3)
                                                                <option>Order Has Been Canceled</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="text-lg-right mt-3 mt-lg-0">
                                                            <button type="submit" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save mr-1"></i>Save</button>
                                                        </div>
                                                    </div>
                                                </div
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </form>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-12">

                                            <div class="text-lg-left mt-3 mt-lg-0">
                                                <div class="float-left">
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
                                            </div>
                                            @if($order->dondathang_trang_thai==2)
                                                <div class="text-lg-right mt-3 mt-lg-0">
                                                    <a href="{{URL::to('/order-print-pdf/'.$order->id)}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i>Print Invoice</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div
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
