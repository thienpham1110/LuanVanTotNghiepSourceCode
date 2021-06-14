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
                                        <a href="index_product_add.php" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add Product</a>
                                    </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div>

                </div>
            </div>

            <!-- content -->

            <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Product Import</h4>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                    <div class="card-body">
                                                        <label class="col-form-label">Import No.</label>
                                                        <input type="text" id="simpleinput" class="form-control" placeholder="Example: DH01,..">
                                                        <label class=" col-form-label">Delivery Day</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" data-provide="datepicker" >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="ti-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label  class="col-form-label">Staff</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="col-form-label">Status</label>
                                                                <select name="Sex" class="form-control">
                                                                    <option>---#---</option>
                                                                    <option>A</option>
                                                                    <option>B</option>
                                                                    <option>C</option>
                                                                    <option>D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label class="col-form-label">Size</label>
                                                    <select name="Sex" class="form-control">
                                                        <option>---#---</option>
                                                        <option>A</option>
                                                        <option>B</option>
                                                        <option>C</option>
                                                        <option>D</option>
                                                    </select>
                                                    <label class="col-form-label"></label>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                        <div id="con-close-modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Size</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="field-1" class="control-label">Size</label>
                                                                                    <input type="text" class="form-control" id="field-1" placeholder="40">
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
                                                        <div class="button-list form-group row">
                                                            <div class="col-sm-12">
                                                                <div class=" mt-3 mt-lg-0">
                                                                    <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal2"> <i class="mdi mdi-plus-circle mr-1"></i>Add Size</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label class="col-form-label">Supplier</label>
                                                    <select name="Sex" class="form-control">
                                                        <option>---#---</option>
                                                        <option>A</option>
                                                        <option>B</option>
                                                        <option>C</option>
                                                        <option>D</option>
                                                    </select>
                                                    <label class="col-form-label"></label>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                        <div id="con-close-modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Supplier</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="field-1" class="control-label">Name</label>
                                                                                    <input type="text" class="form-control" id="field-1" placeholder="Thien">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="field-2" class="control-label">Phone Number</label>
                                                                                    <input type="number" min="1" class="form-control" id="field-2" placeholder="0123456789">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="field-3" class="control-label">Email</label>
                                                                                    <input type="text" class="form-control" id="field-3" placeholder="Email">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="field-4" class="control-label">Address</label>
                                                                                    <input type="text" class="form-control" id="field-4" placeholder="Address">
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
                                                        <div class="button-list form-group row">
                                                            <div class="col-sm-12">
                                                                <div class=" mt-3 mt-lg-0">
                                                                    <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal1"> <i class="mdi mdi-plus-circle mr-1"></i>Add Supplier</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="header-title">Product List</h4>
                                                            <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Selective</th>
                                                                        <th>Name</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($all_product as $key=>$product)
                                                                    <form>
                                                                        {{ csrf_field() }}
                                                                    <tr>
                                                                        <td>
                                                                            {{--  <a href="{{URL::to ('/product-ipmort-add-queue/'.$product->id)}}"  class="btn btn-success waves-effect waves-light btn-sm">
                                                                        <i class="mdi mdi-plus-circle mr-1"></i>Add</a>  --}}
                                                                        <button type="button" data-id_product="{{ $product->id}}" name="add-queue" class="btn btn-success waves-effect waves-light btn-sm add-queue">
                                                                            <i class="mdi mdi-plus-circle mr-1"></i>Add</button>
                                                                        </td>
                                                                        <input type="hidden" value="{{ $product->id }}" class="product_id_{{ $product->id }}">
                                                                        <input type="hidden" value="{{ $product->sanpham_ten }}" class="product_name_{{ $product->id }}">
                                                                        <td>{{$product->sanpham_ten }}</td>
                                                                    </tr>
                                                                </form>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div> <!-- end card body-->
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label class="col-form-label">Product Import</label>
                                                    <div class="table-responsive" id="ajax-queue">
                                                        <table class="table table-hover mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Product Name</th>
                                                                <th>Quantity</th>
                                                                <th>Price</th>
                                                                <th>Retail Price</th>
                                                                <th>Size</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach (Session::get('queue') as $key=> $product )
                                                            <tr>
                                                                <th scope="row"><a href="#" class="demo-delete-row btn-xs btn-icon"><i class="mdi mdi-close mr-1"></i></a> </th>
                                                                <td>{{ $product['product_name'] }}</td>
                                                                <input type="hidden" name="product_id" value="{{ $product['session_id'] }}">
                                                                <td><input type="number" min="1" name="product_quantity" id=""></td>
                                                                <td><input type="number" min="1" name="product_price" id=""></td>
                                                                <td><input type="number" min="1" name="product_price_retail" id=""></td>
                                                                <td><input type="number" min="1" name="product_size" id=""></td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="text-lg-right mt-3 mt-lg-0">
                                                        <a href="index_save_add.php" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Save</a>
                                                    </div>
                                                    <div class="text-lg-left mt-3 mt-lg-0">
                                                        <div class="float-left">
                                                            <p><b>Sub-total :</b></p>
                                                            <h3>$4147.75 USD</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
@endsection