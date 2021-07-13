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
                        <div class="page-title-right mr-3">
                            <div class="text-lg-right mt-3 mt-lg-0">
                                <a href="{{URL::to('/product-import-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Product Import</li>
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
                                    <form class="form-inline" action="{{URL::to('/admin-search-import')}}" method="GET">
                                        <div class="form-group mr-3">
                                            <label for="status-select" class="mr-2">From Day</label>
                                            <input type="date" name="search_admin_from_day_import"  class="form-control">
                                        </div>
                                        <div class="form-group mr-3">
                                            <label for="status-select" class="mr-2">To Day</label>
                                            <input type="date" name="search_admin_to_day_import"  class="form-control">
                                        </div>
                                        <div class="form-group mr-3">
                                            <input type="number" min="1"
                                            @if(isset($search_filter_admin))
                                            value="{{ $search_filter_admin[0]['search_admin_from_total_import'] }}"
                                            @endif
                                            name="search_admin_from_total_import" class="form-control" placeholder="From Total">
                                        </div>
                                        <div class="form-group mr-3">
                                            <input type="number" min="1"
                                            @if(isset($search_filter_admin))
                                            value="{{ $search_filter_admin[0]['search_admin_to_total_import'] }}"
                                            @endif
                                            name="search_admin_to_total_import" class="form-control" placeholder="To total">
                                        </div>
                                        <div class="form-group mr-3 mt-3">
                                            <label for="inputPassword2" class="sr-only">Search</label>
                                            <input type="search" class="form-control" name="search_import_keyword"
                                            @if(isset($search_filter_admin))
                                            value="{{ $search_filter_admin[0]['search_import_keyword'] }}"
                                            @endif
                                            placeholder="Search Keyword...">
                                        </div>
                                        <div class="form-group mx-sm-3 mt-3">
                                            <button type="submit" class="btn btn-success waves-effect waves-light ">Search</button>
                                        </div>
                                        <div class="form-group mt-3">
                                            <a href="{{URL::to('/product-import')}}" class="btn btn-success waves-effect waves-light">All</a>
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
                                    <th class="font-weight-medium">ID</th>
                                    <th class="font-weight-medium">Date</th>
                                    <th class="font-weight-medium">Total</th>
                                    <th class="font-weight-medium">Supplier</th>
                                    <th class="font-weight-medium">Status</th>
                                    <th class="font-weight-medium">Action</th>
                                </tr>
                                </thead>

                                <tbody class="font-14">
                                    @foreach ($all_product_import as $key=>$product_import)
                                    <tr>
                                        <td>
                                            {{ $product_import->donnhaphang_ma_don_nhap_hang}}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime( $product_import->donnhaphang_ngay_nhap)) }}
                                        </td>
                                        <td>
                                            {{number_format($product_import->donnhaphang_tong_tien ).' VNĐ' }}
                                        </td>
                                        <td>
                                            {{ $product_import->Supplier->nhacungcap_ten}}
                                        </td>
                                        <td>
                                            <span class="badge">
                                                <?php
                                                if($product_import->donnhaphang_trang_thai==1)
                                                { ?>
                                                <a href="#"> <i class="fa fa-thumbs-styling fa-thumbs-up"></i></a>
                                                <?php
                                                }else
                                                { ?>
                                                    <a href="#"> <i class="fa fa-thumbs-styling fa-thumbs-down"></i></a>
                                                <?php
                                                }
                                                ?>
                                               </span>
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{URL::to('/product-import-show-detail/'.$product_import->id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Detail</a>
                                                    <a class="dropdown-item" href="{{URL::to('/product-import-edit/'.$product_import->id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                    <a class="dropdown-item" href="index_order_detail.php"><i class="mdi mdi-delete mr-2 text-muted font-18 vertical-middle"></i>Delete</a>
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
                    {{ $all_product_import->links('layout.paginationlinks') }}
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
