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
                                <a href="{{URL::to('/product-import-edit/'.$product_import_detail->donnhaphang_id)}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">RGUWB</a></li>
                            <li class="breadcrumb-item active">Product Import Detail Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
             <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title">Product Import Detail</h4>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="p-2">
                                    <form action="{{ URL::to('product-import-edit-detail-save/'.$product_import_detail->id) }}" enctype="multipart/form-data" class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" >Product Import Detail None Edit</label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Product Import Code</label>
                                                <input type="text" name="product_import_no" value="{{ $product_import_detail->chitietnhap_ma_don_nhap_hang }}" required="" readonly class="form-control" >
                                                <input type="hidden" name="product_import_id" value="{{ $product_import_detail->donnhaphang_id }}" required="" class="form-control" >
                                            </div>
                                            <label class="col-sm-2 col-form-label" ></label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Product</label>
                                                <input type="text" value="{{ $product_import_detail->Product->sanpham_ten }}" required="" readonly class="form-control">
                                                <input type="hidden" name="product_import_detail_product_id" value="{{ $product_import_detail->sanpham_id }}" required="" readonly class="form-control">
                                            </div>
                                            <label class="col-sm-2 col-form-label" ></label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Quantity Sold</label>
                                                <input type="text" value="{{ $product_in_stock->sanphamtonkho_so_luong_da_ban }}" required="" readonly class="form-control">
                                            </div>
                                            <label class="col-sm-2 col-form-label" ></label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Quantity In Stock</label>
                                                <input type="text" name="product_quantity_sold_old" value="{{ $product_in_stock->sanphamtonkho_so_luong_ton }}" required="" readonly class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" >Product Import Detail Edit</label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Quantity</label>
                                                <input type="text" min="1" name="product_import_detail_quantity" value="{{ $product_import_detail->chitietnhap_so_luong_nhap }}" required="" class="form-control">
                                                <input type="hidden" min="1" name="product_import_detail_quantity_old" value="{{ $product_import_detail->chitietnhap_so_luong_nhap }}" required="" class="form-control">
                                            </div>
                                            <label class="col-sm-2 col-form-label" ></label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Price</label>
                                                <input type="text" min="1" name="product_import_detail_price" value="{{ $product_import_detail->chitietnhap_gia_nhap }}" required="" class="form-control" >
                                                <input type="hidden" min="1" name="product_import_detail_price_old" value="{{ $product_import_detail->chitietnhap_gia_nhap }}" required="" class="form-control" >
                                            </div>
                                            <label class="col-sm-2 col-form-label" ></label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Price Retail</label>
                                                <input type="text" name="product_import_detail_price_retail" value="{{ $product_in_stock->Product->sanpham_gia_ban }}" required="" class="form-control">
                                            </div>
                                            <label class="col-sm-2 col-form-label" ></label>
                                            <div class="col-sm-10">
                                                <label class="col-form-label">Size</label>
                                                <input type="hidden" min="1" name="product_import_detail_size_id_old" value="{{ $product_import_detail->size_id }}" required="" class="form-control" >
                                                <select name="product_import_detail_size_id" class="form-control">
                                                    @foreach ($all_size as $key => $size)
                                                        @if($size->id==$product_import_detail->size_id)
                                                            <option selected value="{{ $size->id }}">{{ $size->size }}</option>
                                                        @else
                                                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <div class="text-lg-right mt-3 mt-lg-0">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card-box -->
            </div><!-- end row -->
        </div>
                <!-- end row -->
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
