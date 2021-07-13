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
                                <a href="{{URL::to('/order-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Order</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <form class="form-inline" action="{{URL::to('/admin-search-order')}}" method="GET">
                                    <div class="form-group mr-3">
                                        <label for="status-select" class="mr-2">From Day</label>
                                        <input type="date" name="search_admin_from_day_order"  class="form-control ">
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="status-select" class="mr-2">To Day</label>
                                        <input type="date" name="search_admin_to_day_order"  class="form-control ">
                                    </div>
                                    <div class="form-group mr-3">
                                        <input type="number" min="1"
                                        @if(isset($search_filter_admin))
                                        value="{{ $search_filter_admin[0]['search_admin_from_total_order'] }}"
                                        @endif
                                        name="search_admin_from_total_order" class="form-control" placeholder="From Total">
                                    </div>
                                    <div class="form-group mr-3">
                                        <input type="number" min="1"
                                        @if(isset($search_filter_admin))
                                        value="{{ $search_filter_admin[0]['search_admin_to_total_order'] }}"
                                        @endif
                                        name="search_admin_to_total_order" class="form-control" placeholder="To total">
                                    </div>
                                    <div class="form-group mr-3 mt-3">
                                        <label for="inputPassword2" class="sr-only">Search</label>
                                        <input type="search" class="form-control" name="search_order_keyword"
                                        @if(isset($search_filter_admin))
                                        value="{{ $search_filter_admin[0]['search_order_keyword'] }}"
                                        @endif
                                        placeholder="Search Keyword...">
                                    </div>
                                    <div class="form-group mx-sm-3 mt-3">
                                        <button type="submit" class="btn btn-success waves-effect waves-light search-admin-order">Search</button>
                                    </div>
                                    <div class="form-group mt-3">
                                        <a href="{{URL::to('/order')}}" class="btn btn-success waves-effect waves-light">All</a>
                                    </div>
                                </form>
                            </div>
                           <!-- end col-->
                        </div> <!-- end row -->
                    </div> <!-- end card-box -->
                </div><!-- end col-->
            </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
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
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">Orders Code</th>
                                    <th class="font-weight-medium">Day</th>
                                    <th class="font-weight-medium">Total</th>
                                    <th class="font-weight-medium">Note</th>
                                    <th class="font-weight-medium">Status Delivery</th>
                                    <th class="font-weight-medium">Status Pay</th>
                                    <th class="font-weight-medium">Status</th>
                                    <th class="font-weight-medium">Action</th>
                                </tr>
                                </thead>
                                <tbody class="font-14">
                                    @foreach ($all_order as $key=>$order)
                                    <tr>
                                        <td>
                                            {{ $order->dondathang_ma_don_dat_hang }}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime( $order->dondathang_ngay_dat_hang)) }}
                                        </td>
                                        <td>

                                            {{number_format($order->dondathang_tong_tien,0,',','.' )." VND" }}
                                        </td>
                                        <td>
                                            {{ $order->dondathang_ghi_chu }}
                                        </td>
                                        <td>
                                            @if($order->dondathang_trang_thai==2)
                                                In Transit
                                            @elseif($order->dondathang_trang_thai==3)
                                                Delivered
                                            @elseif($order->dondathang_trang_thai==4)
                                                Order Has Been Canceled
                                            @else
                                                Not Delivered
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->dondathang_tinh_trang_thanh_toan?'Paid':'Unpaid' }}
                                        </td>

                                        <td>
                                            @if($order->dondathang_trang_thai == 0)
                                            Unconfirmed
                                            @elseif($order->dondathang_trang_thai == 1)
                                            Confirmed
                                            @elseif($order->dondathang_trang_thai == 2)
                                            In Transit
                                            @elseif($order->dondathang_trang_thai == 3)
                                            Delivered - Processed
                                            @elseif($order->dondathang_trang_thai == 4)
                                            Order Has Been Canceled
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{URL::to('/order-show-detail/'.$order->id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Detail</a>
                                                    @if($order->dondathang_trang_thai!=3 && $order->dondathang_trang_thai!=2 && $order->dondathang_trang_thai!=4)
                                                    <a class="dropdown-item" href="{{URL::to('/order-canceled/'.$order->id)}}"onclick="return confirm('You Sure?')"><i class="mdi mdi-delete mr-2 text-muted font-18 vertical-middle"></i>Cancel Order</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                <nav>
                    <ul class="pagination pagination-rounded mb-3">
                        {{ $all_order->links('layout.paginationlinks') }}
                    </ul>
                </nav>
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
