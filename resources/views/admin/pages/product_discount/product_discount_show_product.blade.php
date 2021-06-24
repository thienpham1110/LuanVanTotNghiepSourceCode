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
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Number Discount</th>
                                    <th class="font-weight-medium">Price</th>
                                    <th class="font-weight-medium">Price Discount</th>
                                    <th class="font-weight-medium">Title</th>
                                    <th class="font-weight-medium">Status</th>
                                    <th class="font-weight-medium">Product Status</th>
                                </tr>
                                </thead>

                                <tbody class="font-14">
                                    @foreach ($all_product_discount as $key=>$product_discount)
                                        @foreach ($all_product as $k =>$value)
                                            @if($value->id==$product_discount->sanpham_id)
                                                <tr>
                                                    <td>
                                                        <a href="javascript: void(0);">
                                                            <img src="{{asset('public/uploads/admin/product/'.$product_discount->Product->sanpham_anh)}}" alt="contact-img" title="contact-img" class="rounded-circle avatar-lg img-thumbnail">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $product_discount->Product->sanpham_ten}}
                                                    </td>
                                                    <td>
                                                        @if($product_discount->Discount->khuyenmai_loai==1)
                                                        {{number_format($product_discount->Discount->khuyenmai_gia_tri ).' %' }}
                                                        @else
                                                            {{number_format($product_discount->Discount->khuyenmai_gia_tri ).' $' }}
                                                        @endif
                                                    </td>

                                                    <td>
                                                        {{number_format( $value->sanpham_gia_ban ).' VND' }}
                                                    </td>
                                                    <td>
                                                        @if($product_discount->Discount->khuyenmai_loai==1)
                                                        {{number_format( $value->sanpham_gia_ban -(($value->sanpham_gia_ban * $product_discount->Discount->khuyenmai_gia_tri)/100) ).' VND' }}
                                                        @else
                                                        {{number_format( $value->sanpham_gia_ban - $product_discount->khuyenmai_gia_tri ).' VND' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $product_discount->Discount->khuyenmai_tieu_de }}
                                                    </td>
                                                    <td>
                                                        {{$product_discount->Discount->khuyenmai_trang_thai?' On Promotion':' Promotion Ends'}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $quantity=0;
                                                        @endphp
                                                        @foreach ($product_import_in_stock as $in=>$in_stock)
                                                            @if($in_stock->sanpham_id == $value->id)
                                                                @php
                                                                    $quantity+=$in_stock->sanphamtonkho_so_luong_ton;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($quantity>0)
                                                            In Stock
                                                        @else
                                                            Out of stock
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
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
