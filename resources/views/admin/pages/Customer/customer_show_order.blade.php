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
                                <a href="{{URL::to('/customer')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Customer Order</li>
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
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label for="inputPassword2" class="sr-only">Search</label>
                                            <input type="search" class="form-control" id="inputPassword2" placeholder="Search...">
                                        </div>
                                        <div class="form-group mx-sm-3">
                                            <label for="status-select" class="mr-2">Brand</label>
                                            <select class="custom-select" id="status-select">
                                                <option selected="">All</option>
                                                <option value="1">Date</option>
                                                <option value="2">Name</option>
                                                <option value="3">Revenue</option>
                                                <option value="4">Employees</option>
                                            </select>
                                        </div>
                                        <div class="form-group mx-sm-3">
                                            <a href="index_save_add.php" class="btn btn-success waves-effect waves-light">Search</a>
                                        </div>
                                    </form>
                                </div>
                               <!-- end col-->
                            </div> <!-- end row -->
                        </div> <!-- end card-box -->
                    </div><!-- end col-->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                                <h4 class="mt-3 mb-3"><span>Customer: </span></h4>
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Gender</th>
                                    <th class="font-weight-medium">Email</th>
                                    <th class="font-weight-medium">Phone Number</th>
                                    <th class="font-weight-medium">Address</th>
                                    <th class="font-weight-medium">Status</th>
                                </tr>
                                </thead>
                                <tbody class="font-14">
                                    <tr>
                                        <td>
                                            <a href="javascript: void(0);">
                                                <img src="{{asset('public/uploads/client/customer/'.$customer->khachhang_anh)}}" alt="contact-img" title="contact-img" class="rounded-circle avatar-lg img-thumbnail">
                                            </a>
                                        </td>
                                        <td>
                                            {{ $customer->khachhang_ho}}  {{ $customer->khachhang_ten}}
                                        </td>
                                        <td>
                                            {{ $customer->khachhang_gioi_tinh?'Male':'Famale' }}
                                        </td>
                                        <td>
                                            {{ $customer->khachhang_email}}
                                        </td>
                                        <td>
                                            {{ $customer->khachhang_so_dien_thoai }}
                                        </td>
                                        <td>
                                            {{ $customer->khachhang_dia_chi }}
                                        </td>
                                        <td>
                                            {{ $customer->khachhang_trang_thai?'Online':'Offline' }}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                                <h4 class="mt-3 mb-3"><span>Order: </span></h4>
                                <thead class="bg-light">
                                    <tr>
                                        <th class="font-weight-medium">Orders Code</th>
                                        <th class="font-weight-medium">Total</th>
                                        <th class="font-weight-medium">Note</th>
                                        <th class="font-weight-medium">Status Delivery</th>
                                        <th class="font-weight-medium">Status Pay</th>
                                        <th class="font-weight-medium">Status</th>
                                        <th class="font-weight-medium">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="font-14">
                                        @foreach ($all_order_customer as $key=>$order)
                                        <tr>
                                            <td>
                                                {{ $order->dondathang_ma_don_dat_hang }}
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
                    {{--  {{ $all_customer->links('layout.paginationlinks') }}  --}}
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
