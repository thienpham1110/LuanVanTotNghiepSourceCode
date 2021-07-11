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
                            <li class="breadcrumb-item active">Statistical Product In Stock</li>
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
                                        <label for="status-select" class="mr-2">Product Name</label>
                                        <input type="search" id="search_name_statistics_product_in_stock" class="form-control search_name_statistics_product_in_stock">
                                    </div>
                                    <div class="form-group">
                                        <label for="status-select" class="mr-2">Size</label>
                                        <select class="custom-select search_size_statistics_product_in_stock" id="search_size_statistics_product_in_stock">
                                            <option selected="" value="0"> All</option>
                                            @foreach ($all_size as $key=>$size)
                                                <option value="{{ $size->id }}">{{ $size->size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <a type="button" class="btn btn-success waves-effect waves-light clear-search-statistics-product-in-stock">Clear</a>
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
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Size</th>
                                    <th class="font-weight-medium">Quantity In Stock</th>
                                    <th class="font-weight-medium">Quantity Sold</th>
                                </tr>
                                </thead>
                                <tbody class="font-14 show_in_stock_search" >
                                    @foreach ($all_product_in_stock_statistics as $key=>$product_in_stock)
                                    <tr>
                                        <td>
                                            <a href="javascript: void(0);">
                                                <img src="{{asset('public/uploads/admin/product/'.$product_in_stock->Product->sanpham_anh)}}" alt="contact-img" title="contact-img" class="avatar-lg rounded-circle img-thumbnail">
                                            </a>
                                        </td>
                                        <td>
                                            {{ $product_in_stock->Product->sanpham_ten }}
                                        </td>
                                        <td>
                                            {{ $product_in_stock->Size->size }}
                                        </td>
                                        <td>
                                            {{number_format( $product_in_stock->sanphamtonkho_so_luong_ton ,0,',','.' ) }}
                                        </td>
                                        <td>
                                            {{number_format( $product_in_stock->sanphamtonkho_so_luong_da_ban ,0,',','.' ) }}
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
