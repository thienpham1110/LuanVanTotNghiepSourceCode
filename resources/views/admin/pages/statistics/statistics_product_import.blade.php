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
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Statistics Product Import</li>
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
                                    @csrf
                                    <div class="form-group mr-3">
                                        <label for="status-select" class="mr-2">From Day</label>
                                        <input type="date" id="search_from_day_statistical_product_import" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="status-select" class="mr-2">To Day</label>
                                        <input type="date" id="search_to_day_statistical_product_import" class="form-control">
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <a type="button" class="btn btn-success waves-effect waves-light clear-search-statistical-product-import">Clear</a>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <label class="mr-2">Type</label>
                                        <select class="custom-select search-type-statistical-product-import">
                                            <option selected="" value="0"> All</option>
                                            <option value="1">Day</option>
                                            <option value="2">Week-7-Day</option>
                                            <option value="3">Month-30-Day</option>
                                            <option value="4">Quarter Of The Year - 120 - Day</option>
                                            <option value="5">Year - 365 - Day</option>
                                        </select>
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
                        <div class="card-box show_search_import_product_statistics">
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 " cellspacing="0" id="tickets-table">
                                <h4 class="mt-3 mb-3"><span>Total: </span><span>{{number_format( $sum_total_import ,0,',','.' ).' VNĐ' }}</span></h4>
                                <h4 class="mt-3 mb-3"><span>Product: </span><span>{{ number_format( $count_detail ,0,',','.' ) }} </span></h4>
                                <h4 class="mt-3 mb-3"><span>Import Quantity: </span><span>{{ number_format( $sum_detail ,0,',','.' ) }}</span></h4>
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">No.</th>
                                    <th class="font-weight-medium">Day</th>
                                    <th class="font-weight-medium">Supplier</th>
                                    <th class="font-weight-medium">Total</th>
                                </tr>
                                </thead>
                                <tbody class="font-14 show_views_type_search" >
                                    @foreach ($all_product_import_statistics as $key=>$product_import)
                                    <tr>
                                        <td>
                                            {{ $product_import->donnhaphang_ma_don_nhap_hang }}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime( $product_import->donnhaphang_ngay_nhap)) }}
                                        </td>
                                        <td>
                                           {{ $product_import->Supplier->nhacungcap_ten }}
                                        </td>
                                        <td>
                                            {{number_format( $product_import->donnhaphang_tong_tien ,0,',','.' ).' VNĐ' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 " cellspacing="0" id="tickets-table">
                                <h4 class="mt-3 mb-3"><span>Product: </span></h4>
                                <thead class="bg-light">
                                    <tr>
                                        <th class="font-weight-medium">No.</th>
                                        <th class="font-weight-medium">Day</th>
                                        <th class="font-weight-medium">Product Name</th>
                                        <th class="font-weight-medium">Size</th>
                                        <th class="font-weight-medium">Import Price</th>
                                        <th class="font-weight-medium">Quantity</th>
                                        <th class="font-weight-medium">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="font-14 show_views_type_search" >
                                    @foreach ($all_import_detail as $key=>$product_import_detail)
                                    <tr>
                                        <td>
                                            {{$product_import_detail->chitietnhap_ma_don_nhap_hang  }}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime( $product_import_detail->ProductImport->donnhaphang_ngay_nhap))}}
                                        </td>
                                        <td>
                                            {{ $product_import_detail->Product->sanpham_ten }}
                                        </td>
                                        <td>
                                            {{$product_import_detail->Size->size}}
                                        </td>
                                        <td>
                                            {{ number_format( $product_import_detail->chitietnhap_gia_nhap ,0,',','.' ).' VNĐ' }}
                                        </td>
                                        <td>
                                            {{ $product_import_detail->chitietnhap_so_luong_nhap }}
                                        </td>
                                        <td>
                                            {{ number_format( $product_import_detail->chitietnhap_so_luong_nhap* $product_import_detail->chitietnhap_gia_nhap,0,',','.' ).' VNĐ' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
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
