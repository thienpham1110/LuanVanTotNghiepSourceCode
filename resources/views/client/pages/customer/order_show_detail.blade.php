@extends('client.index_layout')
@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="row">
        <div class="col-12">
            <div class="breadcrumb_content">
                <ul>
                    <li><a href="index.html">home</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>Customer Show Order Detail</li>
                </ul>

            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
@if(session()->has('message'))
<div class="alert alert-success">
    {!! session()->get('message') !!}
</div>
@elseif(session()->has('error'))
<div class="alert alert-danger">
    {!! session()->get('error') !!}
</div>
@endif
<!--Checkout page section-->
<div class="Checkout_section">
    <div class="row">
    <div class="checkout_form">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="order_table table-responsive mb-30">
                        <div class="payment_method">
                            <div class="order_button">
                                <a type="button" class="btn btn-warning" href="{{ URL::to('/my-account')}}">Back To My Order</a>
                                <a type="button" class="btn btn-success" href="{{ URL::to('/shop-now')}}" >Keep Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-12 col-md-12">
                        <h3>Order Infomation</h3>
                        <div class="order_table table-responsive mb-30">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Order Day</th>
                                        <th>Status Payment</th>
                                        <th>Status</th>
                                        <th>Discount</th>
                                        <th>Transport Fee</th>
                                        <th>SubTotal</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $feeship=$customer_order->dondathang_phi_van_chuyen;
                                    $discount=$customer_order->dondathang_giam_gia;
                                    $total=$customer_order->dondathang_tong_tien;
                                    @endphp
                                    <tr>
                                        <td>{{ $customer_order->dondathang_ma_don_dat_hang }}</td>
                                        <td>{{ $customer_order->dondathang_ngay_dat_hang }}</td>
                                        <td>
                                            @if($customer_order->dondathang_tinh_trang_thanh_toan==0)
                                            Unpaid
                                            @elseif ($customer_order->dondathang_tinh_trang_thanh_toan==1)
                                                Paid
                                            @elseif ($customer_order->dondathang_tinh_trang_thanh_toan==2)
                                                Order Has Been Canceled - Paid
                                            @elseif ($customer_order->dondathang_tinh_trang_thanh_toan==3)
                                                Order Has Been Canceled - Unpaid
                                            @endif
                                        </td>
                                        <td>
                                            @if($customer_order->dondathang_tinh_trang_thanh_toan==0 && $customer_order->dondathang_trang_thai==0)
                                               Unconfirmed
                                            @elseif($customer_order->dondathang_tinh_trang_thanh_toan==0 && $customer_order->dondathang_trang_thai==1)
                                                Confirmed and unpaid
                                            @elseif($customer_order->dondathang_tinh_trang_thanh_toan==1 && $customer_order->dondathang_trang_thai==1)
                                                Confirmed and paid
                                            @elseif($customer_order->dondathang_trang_thai==2)
                                                In Transit
                                            @elseif($customer_order->dondathang_trang_thai==3)
                                                Delivered
                                            @elseif($customer_order->dondathang_trang_thai==4)
                                               Order Has Been Canceled
                                            @endif
                                        </td>
                                        <td>
                                            @if($customer_order->dondathang_giam_gia )
                                            {{number_format($customer_order->dondathang_giam_gia ,0,',','.').' VNĐ' }}
                                            @else
                                                {{number_format(0 ,0,',','.').' VNĐ' }}
                                            @endif
                                        </td>
                                        <td> {{number_format($customer_order->dondathang_phi_van_chuyen,0,',','.').' VNĐ' }}</td>
                                        <td>
                                            @if($feeship==true)
                                            {{number_format($total-$feeship+$discount,0,',','.').' VNĐ' }}
                                            @else
                                            {{number_format($total-$feeship,0,',','.').' VNĐ' }}
                                            @endif
                                        </td>
                                        <td>{{number_format($total,0,',','.').' VNĐ' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <h3>Delivery order</h3>
                        <div class="order_table table-responsive mb-30">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Pay Method</th>
                                        <th>Status</th>
                                        <th>Money To Be Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $customer_delivery->giaohang_nguoi_nhan}}</td>
                                        <td >{{ $customer_delivery->giaohang_nguoi_nhan_email }} </td>
                                        <td>{{$customer_delivery->giaohang_nguoi_nhan_so_dien_thoai }}</td>
                                        <td>{{ $customer_delivery->giaohang_nguoi_nhan_dia_chi }}</td>
                                        <td>{{$customer_delivery->giaohang_phuong_thuc_thanh_toan?'Bank Transfer':'COD' }}</td>
                                        <td>
                                            @if($customer_delivery->giaohang_trang_thai==0)
                                            Not Delivered
                                            @elseif ($customer_delivery->giaohang_trang_thai==1)
                                            In Transit
                                            @elseif ($customer_delivery->giaohang_trang_thai==2)
                                            Delivered
                                            @else
                                            Order Has Been Canceled
                                            @endif
                                        </td>
                                        <td>
                                            {{number_format($customer_delivery->giaohang_tong_tien_thanh_toan,0,',','.').' VNĐ' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <h3>Your order</h3>
                        <div class="order_table table-responsive mb-30">
                            <table>
                                <thead>
                                    <tr>
                                        <th>images</th>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($all_order_detail==true)
                                        @foreach ($all_order_detail as $key =>$product)
                                            <tr>
                                                <td><img src="{{asset('public/uploads/admin/product/'.$product->Product->sanpham_anh)}}" width="70px" height="75px" alt=""></td>
                                                <td> {{ $product->Product->sanpham_ten }}</td>
                                                <td>{{ $product->Size->size }}</td>
                                                <td>{{ $product->Product->sanpham_gia_ban }}</td>
                                                <td>{{ $product->chitietdondathang_so_luong }}</td>
                                                <td>{{number_format( $product->chitietdondathang_don_gia* $product->chitietdondathang_so_luong ,0,',','.').' VNĐ' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Subtotal</th>

                                        <td>
                                            @if($discount==true)
                                                {{number_format($total-$feeship+$discount,0,',','.').' VNĐ' }}
                                            @else
                                            {{number_format($total-$feeship,0,',','.').' VNĐ' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td>
                                            <strong>
                                                {{number_format($feeship,0,',','.').' VNĐ' }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discount Coupon</th>
                                        <td>
                                            <strong>
                                                @if($discount)
                                                   - {{number_format($discount,0,',','.').' VNĐ' }}
                                                @else
                                                - {{number_format(0,0,',','.').' VNĐ' }}
                                                @endif
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Order Total</th>
                                        <td><strong>
                                        {{number_format($total,0,',','.').' VNĐ' }}
                                        </strong></td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Money To Be Paid</th>
                                        <td><strong>
                                            {{number_format($customer_delivery->giaohang_tong_tien_thanh_toan,0,',','.').' VNĐ' }}
                                        </strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @if ($customer_order->dondathang_trang_thai==0 ||$customer_order->dondathang_trang_thai==1)
                    <div class="col-lg-12 col-md-12">
                        <h3>Update Billing Details</h3>
                        <form action="{{ URL::to('/customer-order-delivery-update-save/'.$customer_order->id)}}" method="POST">
                            @csrf
                                <div class="col-lg-12 mb-30">
                                    <label>Name <span>*</span></label>
                                    <input name="delivery_update_name" value="{{ $customer_delivery->giaohang_nguoi_nhan }}" required="" type="text">
                                </div>
                                <div class="col-lg-12 mb-30">
                                    <label> Email   <span>*</span></label>
                                      <input name="delivery_update_email" value="{{ $customer_delivery->giaohang_nguoi_nhan_email }}" required="" type="text">
                                </div>
                                <div class="col-lg-12 mb-30">
                                    <label>Phone<span>*</span></label>
                                    <input name="delivery_update_phone_number" value="{{ $customer_delivery->giaohang_nguoi_nhan_so_dien_thoai }}" required="" type="number">
                                </div>

                                <div class="col-12 mb-30">
                                    <label>address  <span>*</span></label>
                                    <input name="delivery_update_address" value="{{ $customer_delivery->giaohang_nguoi_nhan_dia_chi }}" required="" type="text">
                                </div>
                                <div class="user-actions mb-30">
                                    <div class="col-12 mb-30">
                                        <button type="button" class="Returning btn btn-danger" href="#" data-toggle="collapse" data-target="#checkout_login" aria-expanded="true">Click Here To Choose Address</button>
                                    </div>
                                     <div id="checkout_login" class="collapse" data-parent="#accordion">
                                        <div class="col-12 mb-30">
                                            <label for="country">City <span>*</span></label>
                                            <select name="order_city" id="order_city" required="" class="choose-address order_city form-control ">
                                                <option value="-1">Choose City</option>
                                                @foreach ($city as $key=>$cty)
                                                    <option value="{{$cty->id}}">{{ $cty->tinhthanhpho_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 mb-30">
                                            <label for="country">Province <span>*</span></label>
                                            <select name="order_province" required="" id="order_province" class="choose-address select-province form-control">
                                                <option value="-1">Province</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-30">
                                            <label for="country">Wards <span>*</span></label>
                                            <select name="order_wards" required="" id="order_wards" class="select-wards form-control">
                                                <option value="-1">Wards</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-30">
                                    <div class="order-notes">
                                        <label for="order_note">Order Notes</label>
                                       <textarea id="order_note" name="delivery_update_note" placeholder="Notes about your order">{{ $customer_order->dondathang_ghi_chu }}</textarea>
                                   </div>
                                </div>
                                <div class="col-12 mb-30">
                                    <div class="order_button">
                                        <button type="submit">Order Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
    </div>
    <!--Checkout page section end-->
@endsection
