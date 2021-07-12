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
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
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
                                        <form action="{{ URL::to('/product-save') }}" enctype="multipart/form-data"class="form-horizontal" role="form"  method="post">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Product Information</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Product Code</label>
                                                    <input type="text" name="product_code"  class="form-control" required="" placeholder="Example: SP01">
                                                    <label class="col-form-label">Name</label>
                                                    <input type="text" name="product_name" class="form-control" required="" placeholder="Example: AF1,..">
                                                    <label class="col-form-label">Price</label>
                                                    <input type="number" min="1" name="product_price" class="form-control" required="" placeholder="100.000 VNĐ">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label class="col-form-label">Gender</label>
                                                            <select name="product_gender" class="form-control">
                                                                <option value="1">Male</option>
                                                                <option value="2">Famale</option>
                                                                <option value="3">Unisex</option>
                                                                <option value="4">Kids</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Where production</label>
                                                            <input type="text" name="product_production" required="" class="form-control"  placeholder="VN">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Color</label>
                                                            <input type="text" name="product_color" required="" class="form-control" placeholder="Red">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Accessories</label>
                                                            <input type="text" name="product_accessories" required="" class="form-control"  placeholder="Box,tag,..">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Material</label>
                                                            <input type="text" name="product_material" required=""  class="form-control"  placeholder="Vai">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label  class="col-form-label">Guarantee</label>
                                                            <input type="text" name="product_guarantee" required="" class="form-control"  placeholder="1:1">
                                                        </div>
                                                    </div>
                                                    <label  class="col-form-label">Feature</label>
                                                    <textarea name="product_feature" required="" class="form-control" placeholder="Chạy bộ.."></textarea>
                                                    <label class="col-form-label">Description</label>
                                                    <textarea class="form-control" name="product_description" required="" placeholder="Des.."></textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label" >Product Type</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Name</label>
                                                    <select name="product_type" class="form-control">
                                                        @foreach ($product_type as $key => $pro_type)
                                                            <option value="{{ $pro_type->id }}">{{ $pro_type->loaisanpham_ten }}</option>
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
                                                            <option value="{{ $brand->id }}">{{ $brand->thuonghieu_ten }}</option>
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
                                                            <option value="{{ $collection->id }}">{{ $collection->dongsanpham_ten }}</option>
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
                                                        <input type="file" class="upload custom-file-input" required="" name="product_img" id="images">
                                                        <label class="custom-file-label" for="images">Choose image</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-10">
                                                    <label class="col-form-label">Status</label>
                                                    <select name="product_status" class="form-control">
                                                        <option value="1">Show</option>
                                                        <option value="0">Hide</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="text-lg-right mt-3 mt-lg-0">
                                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Add</button>
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
