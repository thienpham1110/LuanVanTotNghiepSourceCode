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
                            <li class="breadcrumb-item active">Product Order</li>
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
                <!-- end row -->
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
                                    <th class="font-weight-medium">#</th>
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Price</th>
                                    <th class="font-weight-medium">Size</th>
                                </tr>
                                </thead>
                                <tbody class="font-14">
                                    <form >
                                        @csrf
                                        @foreach ($all_product as $key=>$product)
                                            @foreach ($all_product_in_stock as $k=>$in_stock)
                                                @if($product->id==$in_stock->sanpham_id)
                                                <tr>
                                                    <input type="hidden" value="{{ $product->id }}" class="product_id_{{ $product->id }}">
                                                    <input type="hidden" value="{{ $product->sanpham_ten }}" class="product_name_{{ $product->id }}">
                                                    <input type="hidden" value="{{number_format( $product->sanpham_gia_ban ,0,',','') }}" class="product_price_{{ $product->id }}">
                                                    <input type="hidden" value="{{ $in_stock->size_id }}" class="product_size_id_{{ $product->id }}">
                                                    <input type="hidden" value="{{ $in_stock->Size->size }}" class="product_size_name_{{ $product->id }}">
                                                    <input type="hidden" value="{{ $in_stock->sanphamtonkho_so_luong_ton }}" class="product_in_stock_{{ $product->id }}">
                                                    <td>
                                                        <button type="button" data-id_product="{{ $product->id}}" name="add-order-admin" class="btn btn-success waves-effect waves-light btn-sm add-order-admin">
                                                        <i class="mdi mdi-plus-circle mr-1"></i>Add</button>
                                                    </td>
                                                    <td>
                                                        <a href="javascript: void(0);">
                                                            <img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt="contact-img" title="contact-img" class="rounded-circle avatar-lg img-thumbnail">
                                                        </a>
                                                    </td>
                                                    <td>{{$product->sanpham_ten }}</td>
                                                    <td>{{number_format( $product->sanpham_gia_ban,0,',','.' )." VND" }}</td>
                                                    <td>{{$in_stock->Size->size }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </form>

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
