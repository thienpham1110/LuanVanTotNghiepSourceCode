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
                                <a href="{{URL::to('/order-add-show-product')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
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
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label for="inputPassword2" class="sr-only">Search</label>
                                        <input type="search" class="form-control" id="inputPassword2" placeholder="Search...">
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
                                <?php
                                    $message=Session::get('message');
                                    if($message){
                                        echo '<p class="text-muted">'.$message.'</p>';
                                        Session::put('message',null);
                                    }
                                ?>
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
                                    @foreach ($all_order as $key=>$order)
                                    <tr>
                                        <td>
                                            {{ $order->dondathang_ma_don_dat_hang }}
                                        </td>
                                        <td>
                                            {{ $order->dondathang_tong_tien }}
                                        </td>
                                        <td>
                                            {{ $order->dondathang_ghi_chu }}
                                        </td>
                                        <td>
                                            {{ $order->dondathang_tinh_trang_giao_hang?'Delivered':'Not Delivered' }}
                                        </td>
                                        <td>
                                            {{ $order->dondathang_tinh_trang_thanh_toan?'Paid':'Unpaid' }}
                                        </td>

                                        <td>
                                            @if($order->dondathang_trang_thai == 0)
                                            Unprocess
                                            @elseif($order->dondathang_trang_thai == 1)
                                            Payment Not Yet Delivered
                                            @elseif($order->dondathang_trang_thai == 2)
                                            Processed
                                            @elseif($order->dondathang_trang_thai == 3)
                                            Order Has Been Canceled
                                            @endif
                                        </td>

                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{URL::to('/order-show-detail/'.$order->id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Detail</a>
                                                    @if($order->dondathang_trang_thai!=3)
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
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
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
