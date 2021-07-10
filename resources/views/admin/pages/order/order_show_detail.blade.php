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
                                <a href="{{URL::to('/order')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                                <a href="{{URL::to('/order-add-show-product')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
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
                                                                @if(isset($order_customer))
                                                                    <tr>
                                                                        <td >{{ $order_customer->UserAccount->user_ten}} </td>
                                                                        <td>{{ $order_customer->khachhang_ho.''.$order_customer->khachhang_ten}}</td>
                                                                        <td>{{$order_customer->khachhang_so_dien_thoai }}</td>
                                                                        <td>{{ $order_customer->khachhang_email}}</td>
                                                                        <td>{{$order_customer->khachhang_dia_chi }}</td>
                                                                    </tr>
                                                                @else
                                                                <tr>
                                                                    <td></td>
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
                                                        <td>Status Payment</td>
                                                        <td>Discount</td>
                                                        <td>Transport Fee</td>
                                                        <td>Total</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody >
                                                        <tr>
                                                            <td>{{ $order->dondathang_ma_don_dat_hang}}</td>
                                                            <td >{{ $order->dondathang_ngay_dat_hang }} </td>
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
                                                                @if($order->dondathang_giam_gia )
                                                                {{number_format($order->dondathang_giam_gia ,0,',','.').' VNĐ' }}
                                                                @else
                                                                    {{number_format(0 ,0,',','.').' VNĐ' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{number_format($order->dondathang_phi_van_chuyen,0,',','.').' VNĐ' }}
                                                            </td>
                                                            <td>
                                                                {{number_format($order->dondathang_tong_tien,0,',','.').' VNĐ' }}
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
                                                                    <td>Money To Be Paid</td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>{{ $order_delivery->giaohang_nguoi_nhan}}</td>
                                                                        <td >{{ $order_delivery->giaohang_nguoi_nhan_email }} </td>
                                                                        <td>{{$order_delivery->giaohang_nguoi_nhan_so_dien_thoai }}</td>
                                                                        <td>{{ $order_delivery->giaohang_nguoi_nhan_dia_chi }}</td>
                                                                        <td>{{$order_delivery->giaohang_phuong_thuc_thanh_toan?'Bank Transfer':'COD' }}</td>
                                                                        <td>
                                                                            {{number_format($order_delivery->giaohang_tong_tien_thanh_toan,0,',','.').' VNĐ' }}
                                                                        </td>
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
                                                    <label class="col-form-label">Product</label>
                                                    <div class="table-responsive" id="ajax-queue">
                                                        <table class="table table-hover  mb-0">
                                                            <thead>
                                                            <tr>
                                                                <td>images</td>
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
                                                                        <td><img src="{{asset('public/uploads/admin/product/'.$product->Product->sanpham_anh)}}" width="70px" height="75px" alt=""></td>
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
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-form-label"><h4>Delivery Infomation</h4></label>
                                            <div class="card">
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label class="col-form-label">Order Status</label>
                                                            @if($order->dondathang_tinh_trang_thanh_toan==0 && $order->dondathang_trang_thai==0)
                                                                <input type="text" readonly value="Unconfirmed" class="form-control"></input>
                                                            @elseif($order->dondathang_tinh_trang_thanh_toan==0 && $order->dondathang_trang_thai==1)
                                                                <input type="text" readonly value="Confirmed and unpaid" class="form-control"></input>
                                                            @elseif($order->dondathang_tinh_trang_thanh_toan==1 && $order->dondathang_trang_thai==1)
                                                                <input type="text" readonly value="Confirmed and paid" class="form-control"></input>
                                                            @elseif($order->dondathang_trang_thai==2)
                                                                <input type="text" readonly value="In Transit" class="form-control"></input>
                                                            @elseif($order->dondathang_trang_thai==3)
                                                                <input type="text" readonly value="Delivered" class="form-control"></input>
                                                            @elseif($order->dondathang_trang_thai==4 && $order->dondathang_tinh_trang_thanh_toan==2)
                                                                <input type="text" readonly value="Order Has Been Canceled - Paid" class="form-control"></input>
                                                            @elseif($order->dondathang_trang_thai==4 && $order->dondathang_tinh_trang_thanh_toan==3)
                                                                <input type="text" readonly value="Order Has Been Canceled - Unpaid" class="form-control"></input>
                                                            @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="text-lg-left mt-3 mt-lg-0">
                                                            @if($order->dondathang_trang_thai==0)
                                                                <a href="{{URL::to('/order-confirm/'.$order->id)}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save mr-1"></i>Confirm</a>
                                                            @endif
                                                            @if($order->dondathang_tinh_trang_thanh_toan==0 && $order_delivery->giaohang_phuong_thuc_thanh_toan==1)
                                                                <a href="{{URL::to('/order-confirm-payment/'.$order->id)}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save mr-1"></i>Payment Confirmation</a>
                                                            @endif
                                                            @if($order->dondathang_trang_thai!=3 && $order->dondathang_trang_thai!=2 && $order->dondathang_trang_thai!=4)
                                                                <a href="{{URL::to('/order-canceled/'.$order->id)}}"  class="btn btn-success waves-effect" onclick="return confirm('You Sure?')"><i class="mdi mdi-delete mr-2"></i>Cancel Order</a>
                                                            @endif
                                                            @if($order->dondathang_trang_thai!=2 && $order->dondathang_trang_thai!=3 && $order->dondathang_trang_thai!=4)
                                                            <a href="{{URL::to('/order-in-transit/'.$order->id)}}"  class="btn btn-success waves-effect" onclick="return confirm('You Sure?')"><i class="mdi mdi-content-save mr-2"></i>Confirm Pickup</a>
                                                            @endif
                                                            @if($order->dondathang_trang_thai!=3 && $order->dondathang_trang_thai!=4)
                                                            <a href="{{URL::to('/order-confirm-delivery/'.$order->id)}}"  class="btn btn-success waves-effect" onclick="return confirm('You Sure?')"><i class="mdi mdi-content-save mr-2"></i>Confirm Delivery</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="text-lg-left mt-3 mt-lg-0">
                                                <div class="float-left">
                                                    <p>
                                                        <b>SubTotal :</b>&nbsp;&nbsp;&nbsp;
                                                            @if($order_coupon)
                                                                @if($order_coupon->makhuyenmai_loai_ma==1)
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
                                                                @if($order_coupon->makhuyenmai_loai_ma==1)
                                                                {{number_format($order->Coupon->makhuyenmai_gia_tri).' VNĐ' }}
                                                                @else
                                                                {{number_format($order->Coupon->makhuyenmai_gia_tri).' %' }}
                                                                @endif
                                                            @else
                                                                {{number_format($order->dondathang_giam_gia).' VNĐ' }}
                                                            @endif
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <b>Total: </b>&nbsp;&nbsp;&nbsp;
                                                        <span class="float-right">{{number_format($order->dondathang_tong_tien ).' VNĐ' }} </span>
                                                    </p>
                                                    <p>
                                                        <b>Money to be paid: </b>&nbsp;&nbsp;&nbsp;
                                                        <span class="float-right">
                                                            {{number_format($order_delivery->giaohang_tong_tien_thanh_toan ).' VNĐ' }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            @if($order->dondathang_trang_thai != 0 && $order->dondathang_trang_thai != 4)
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
