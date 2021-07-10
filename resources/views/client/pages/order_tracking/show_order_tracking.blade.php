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
                    <li>order tracking</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
<!-- Start Maincontent  -->
<section class="main_content_area">
        <div class="account_dashboard">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content">
                        <div>
                            <h3>Orders</h3>
                            <div class="coron_table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Detail</th>
                                            <th>Cancel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--  @if($get_order !=null)  --}}
                                            @foreach ($get_order as $key=>$order)
                                                <tr>
                                                    <td>{{ $order->dondathang_ma_don_dat_hang }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($order->dondathang_ngay_dat_hang)) }}</td>
                                                    <td>
                                                        <span class="success">
                                                            @if($order->dondathang_trang_thai==0)
                                                            Unconfirmed
                                                            @elseif($order->dondathang_trang_thai==1)
                                                            Confirmed
                                                            @elseif($order->dondathang_trang_thai==2)
                                                            In Transit
                                                            @elseif($order->dondathang_trang_thai==3)
                                                            Delivered
                                                            @else
                                                            Order Has Been Canceled
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>{{number_format($order->dondathang_tong_tien  ,0,',','.').' VNĐ' }}</td>
                                                    <td><a href="{{URL::to('/show-order-tracking-detai/'.$order->id)}}" class="view">Detail</a></td>
                                                </tr>
                                            @endforeach
                                        {{--  @endif  --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- End Maincontent  -->
@endsection
