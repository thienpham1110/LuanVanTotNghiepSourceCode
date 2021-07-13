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
                                <form class="form-inline" action="{{URL::to('/admin-search-delivery')}}" method="GET">
                                    <div class="form-group">
                                        <label for="inputPassword2" class="sr-only">Search</label>
                                        <input type="search" class="form-control" required="" name="search_delivery_keyword"
                                        @if(isset($search_keyword))
                                        value="{{ $search_keyword }}"
                                        @endif
                                        placeholder="Search Keyword...">
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Search</button>
                                    </div>
                                    <div class="form-group ">
                                        <a href="{{URL::to('/delivery')}}" class="btn btn-success waves-effect waves-light">All</a>
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
                                    <th class="font-weight-medium">Money To Be Paid</th>
                                    <th class="font-weight-medium">Customer</th>
                                    <th class="font-weight-medium">Email</th>
                                    <th class="font-weight-medium">Phone Number</th>
                                    <th class="font-weight-medium">Address</th>
                                    <th class="font-weight-medium">Pay Method</th>
                                    <th class="font-weight-medium">Status</th>
                                    <th class="font-weight-medium">Action</th>
                                </tr>
                                </thead>
                                <tbody class="font-14">
                                    @foreach ($all_delivery as $key=>$delivery)
                                    <tr>
                                        <td>
                                            {{ $delivery->giaohang_ma_don_dat_hang }}
                                        </td>
                                        <td>
                                            {{number_format($delivery->giaohang_tong_tien_thanh_toan,0,',','.').' VNĐ' }}
                                        </td>
                                        <td>
                                            {{ $delivery->giaohang_nguoi_nhan }}
                                        </td>
                                        <td>
                                            {{ $delivery->giaohang_nguoi_nhan_email }}
                                        </td>
                                        <td>
                                            {{ $delivery->giaohang_nguoi_nhan_so_dien_thoai }}
                                        </td>
                                        <td>
                                            {{ $delivery->giaohang_nguoi_nhan_dia_chi}}
                                        </td>
                                        <td>
                                            {{ $delivery->giaohang_phuong_thuc_thanh_toan?'Bank Transfer':'COD'}}
                                        </td>
                                        <td>
                                            {{ $delivery->giaohang_trang_thai?'Delivered':'Not Delivered'}}
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{URL::to('/order-show-detail/'.$delivery->dondathang_id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Detail</a>
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
                        {{$all_delivery->links('layout.paginationlinks') }}
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
