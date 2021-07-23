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
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Title</th>
                                    <th class="font-weight-medium">Number</th>
                                    <th class="font-weight-medium">Time</th>
                                    <th class="font-weight-medium">Status</th>
                                    <th class="font-weight-medium">Action</th>
                                </tr>
                                </thead>

                                <tbody class="font-14">
                                    @foreach ($all_product_discount as $key=>$product_discount)
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
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{URL::to('/product-discount-admin-detail/'.$product_discount->id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Detail</a>
                                                    <a class="dropdown-item" href="{{URL::to('/product-discount-edit/'.$product_discount->id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                    <a class="dropdown-item" href="{{URL::to('/product-discount-delete/'.$product_discount->id)}}" onclick="return confirm('You Sure?')"><i class="mdi mdi-delete mr-2 text-muted font-18 vertical-middle"></i>Delete</a>
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
                    {{ $all_product_discount->links('layout.paginationlinks') }}
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
