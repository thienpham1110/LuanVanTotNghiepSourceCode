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
                                <a href="{{URL::to('/product')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                                <a href="{{URL::to('/product-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Product Information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <form action="{{ URL::to('/product-save-edit/'.$product->id) }}" enctype="multipart/form-data"class="form-horizontal" role="form"  method="post" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Product Information</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Product Code</label>
                                                    <input type="text" value="{{$product->sanpham_ma_san_pham }}" name="product_code" required="" class="form-control" placeholder="Example: SP01">
                                                    <label class="col-form-label">Name</label>
                                                    <input type="text" value="{{$product->sanpham_ten }}" name="product_name" required="" class="form-control" placeholder="Example: AF1,..">
                                                    <label class="col-form-label">Price</label>
                                                    <input type="number" min="1" name="product_price" value="{{$product->sanpham_gia_ban }}" class="form-control" required="" placeholder="100.000 VNĐ">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label class="col-form-label">Gender</label>
                                                            <select name="product_gender" class="form-control">
                                                                <option value="{{ $product->sanpham_nguoi_su_dung }}">
                                                                    <?php
                                                                    if($product->sanpham_nguoi_su_dung==0){
                                                                        echo 'Male';
                                                                    }else if($product->sanpham_nguoi_su_dung==1){
                                                                        echo 'Famale';
                                                                    }
                                                                    else if($product->sanpham_nguoi_su_dung==2){
                                                                        echo 'Unisex';
                                                                    }else if($product->sanpham_nguoi_su_dung==3){
                                                                        echo 'Kids';
                                                                    }
                                                                    ?>
                                                                </option>
                                                                <option value="0">Male</option>
                                                                <option value="1">Famale</option>
                                                                <option value="2">Unisex</option>
                                                                <option value="3">Kids</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Where production</label>
                                                            <input type="text" value="{{$product->sanpham_noi_san_xuat }}" required="" name="product_production"  class="form-control"  placeholder="VN">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Color</label>
                                                            <input type="text" value="{{$product->sanpham_mau_sac }}" required="" name="product_color" class="form-control"  placeholder="Red">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Accessories</label>
                                                            <input type="text" value="{{$product->sanpham_phu_kien }}" required="" name="product_accessories" class="form-control"  placeholder="Box,tag,..">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Material</label>
                                                            <input type="text" value="{{$product->sanpham_chat_lieu }}" required="" name="product_material"  class="form-control"  placeholder="Vai">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Guarantee</label>
                                                            <input type="text" value="{{$product->sanpham_bao_hanh }}" required="" name="product_guarantee" class="form-control"  placeholder="1:1">
                                                        </div>
                                                    </div>
                                                    <label  class="col-form-label">Feature</label>
                                                    <textarea name="product_feature" class="form-control" required="" placeholder="Chạy bộ..">{{$product->sanpham_tinh_nang }}</textarea>
                                                    <label class="col-form-label">Description</label>
                                                    <textarea class="form-control" required="" name="product_description" placeholder="Des..">{{$product->sanpham_mo_ta }}</textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Product Type</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Name</label>
                                                    <select name="product_type" class="form-control">
                                                        @foreach ($product_type as $key => $pro_type)
                                                            @if($pro_type->id==$product->loaisanpham_id)
                                                                <option selected value="{{ $pro_type->id }}">{{ $pro_type->loaisanpham_ten }}</option>
                                                            @else
                                                                <option value="{{ $pro_type->id }}">{{ $pro_type->loaisanpham_ten }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <label class="col-form-label"></label>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <div class="button-list form-group row">
                                                                <div class="col-sm-12">
                                                                    <div class=" mt-3 mt-lg-0">
                                                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal"> <i class="mdi mdi-plus-circle mr-1"></i>Add Product Type</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Brand</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Name</label>
                                                    <select name="brand" class="form-control">
                                                        @foreach ($product_brand as $key => $brand)
                                                            @if($brand->id==$product->thuonghieu_id)
                                                                <option selected value="{{ $brand->id }}">{{ $brand->thuonghieu_ten }}</option>
                                                            @else
                                                                <option value="{{ $brand->id }}">{{ $brand->thuonghieu_ten }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <label class="col-form-label"></label>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <div class="button-list form-group row">
                                                                <div class="col-sm-12">
                                                                    <div class=" mt-3 mt-lg-0">
                                                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal1"> <i class="mdi mdi-plus-circle mr-1"></i>Add Brand</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Collection</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Name</label>
                                                    <select name="collection" class="form-control">
                                                        @foreach ($product_collection as $key => $collection)
                                                            @if($collection->id==$product->dongsanpham_id)
                                                                <option selected value="{{ $collection->id }}">{{ $collection->dongsanpham_ten }}</option>
                                                            @else
                                                                <option value="{{ $collection->id }}">{{ $collection->dongsanpham_ten }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <label class="col-form-label"></label>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">

                                                            <div class="button-list form-group row">
                                                                <div class="col-sm-12">
                                                                    <div class=" mt-3 mt-lg-0">
                                                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal2"> <i class="mdi mdi-plus-circle mr-1"></i>Add Collection</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Images</label>
                                                <div class="col-sm-10">
                                                    <div class="user-image mb-3 text-center">
                                                        <div class="imgPreview" >

                                                        </div>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="upload custom-file-input"  value="{{ $product->sanpham_anh }}" name="product_img" id="images">
                                                        <label class="custom-file-label" for="images">Choose image</label>
                                                    </div>
                                                    <label class="col-form-label mt-3">Old image</label>
                                                    <img class=" mt-3" width="100px" height="100px" id="image" src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Status</label>
                                                    <select name="product_status" class="form-control">
                                                        <option value="{{ $product->sanpham_trang_thai}}">{{ $product->sanpham_trang_thai?'Show':'Hide' }}</option>
                                                        <option value="0">Hide</option>
                                                        <option value="1">Show</option>
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
                    </div> <!-- end card-box -->
                </div><!-- end col -->
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
{{-- form collection
<form action="">
    <div id="con-close-modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Collection</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Name</label>
                                <input type="text" class="form-control" id="field-1" placeholder="Run">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <textarea class="form-control" placeholder="Des.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
</form>
{{-- end form colleciton --}}
{{-- form brand --}}
<form action="">
    <div id="con-close-modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Brand</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Name</label>
                                <input type="text" class="form-control" id="field-1" placeholder="Adidas">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <textarea class="form-control" placeholder="Des.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
</form>

{{-- end form brand --}}

{{-- form product type --}}
<form action="">
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Product Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Name</label>
                                <input type="text" class="form-control" id="field-1" placeholder="AF1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label class="col-form-label">Description</label>
                            <textarea class="form-control" placeholder="Des.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

</form> --}}
@endsection
