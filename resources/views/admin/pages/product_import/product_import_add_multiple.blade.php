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
                                <a href="{{URL::to('/product-import')}}" class="btn btn-success waves-effect waves-light"><i class="ti-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Product Import Add</li>
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
                            <?php
                                $message=Session::get('message');
                                if($message){
                                    echo '<p class="text-muted">'.$message.'</p>';
                                    Session::put('message',null);
                                }
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                            <form action="{{URL::to('/product-import-add-save')}}" method="POST" class="form-horizontal">
                                                {{ csrf_field() }}
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                    <div class="card-body">
                                                        <label class="col-form-label">Import No.</label>
                                                        <input type="text" name="product_import_no" required="" class="form-control product_import_no" placeholder="Example: DH01,..">
                                                        <label class=" col-form-label">Delivery Day</label>
                                                        {{--  <div class="input-group">
                                                            <input type="text" name="product_import_delivery_day" required="" class="form-control product_import_delivery_day" data-provide="datepicker" >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="ti-calendar"></i></span>
                                                            </div>
                                                        </div>  --}}
                                                        <input type="date" name="product_import_delivery_day" required="" class="form-control product_import_delivery_day" >
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label  class="col-form-label">Staff</label>
                                                                @foreach ($get_admin as $key => $admin )
                                                                    <input type="text" value="{{ $admin->admin_ten  }}" readonly class="form-control product_import_staff">
                                                                    <input type="hidden" name="product_import_staff" value="{{ $admin->id }}"  class="form-control product_import_staff">
                                                                @endforeach
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="col-form-label">Status</label>
                                                                <select name="product_import_status" required="" class="form-control product_import_status">
                                                                    <option value="1">Paid</option>
                                                                    <option value="0">Unpaid</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        {{--  <div class="form-group row">
                                                            <div class="col-sm-12">
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
                                                        <hr>  --}}
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <label class="col-form-label">Supplier</label>
                                                                <select name="product_import_supplier" required="" class="form-control product_import_supplier">
                                                                    @foreach ($all_supplier as $key => $supplier)
                                                                    <option value="{{ $supplier->id }}">{{ $supplier->nhacungcap_ten }}</option>
                                                                    @endforeach
                                                                </select>
                                                                {{-- <label class="col-form-label"></label>
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
                                                                                <button type="button" data-add_product_import_id="#" class="add-product-import btn btn-success waves-effect waves-light" > <i class="mdi mdi-plus-circle mr-1"></i>Add Supplier</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div> --}}
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
                                                                        <tr>
                                                                            <td>
                                                                                <button type="button" data-id_product="{{ $product->id}}" name="add-queue" class="btn btn-success waves-effect waves-light btn-sm add-queue">
                                                                                <i class="mdi mdi-plus-circle mr-1"></i>Add</button>
                                                                            </td>
                                                                            <input type="hidden" value="{{ $product->id }}" class="product_id_{{ $product->id }}">
                                                                            <input type="hidden" value="{{ $product->sanpham_ten }}" class="product_name_{{ $product->id }}">
                                                                            <td>{{$product->sanpham_ten }}</td>
                                                                        </tr>
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
                                                        <table class="table table-hover  mb-0">
                                                            <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <td>Product Name</td>
                                                                <td>Quantity</td>
                                                                <td>Price</td>
                                                                <td>Retail Price</td>
                                                                <td>Size</td>
                                                                <td>Total</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="show-list-product">
                                                                @foreach (Session::get('queue') as $key=> $product )
                                                                    <tr>
                                                                        <td scope="row">
                                                                            <button type="button" data-id_product="{{ $product['session_id']}}" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                                                                                <i class="mdi mdi-close mr-1"></i>
                                                                            </button>
                                                                        </td>
                                                                        <td>{{ $product['product_name'] }}</td>
                                                                        <input type="hidden" name="session_id[{{ $product['product_id'] }}]" class="product_session_id_{{ $product['session_id'] }}" value="{{ $product['session_id'] }}">
                                                                        <input type="hidden" name="product_id[{{ $product['product_id'] }}]" class="product_id_{{ $product['session_id']}}" value="{{ $product['product_id'] }}">
                                                                        <input type="hidden" name="product_name[{{ $product['product_id'] }}]" class="product_name_{{ $product['session_id']}} " value="{{ $product['product_name'] }}">
                                                                        <td><input type="number" min="1" value="{{ $product['product_quantity'] }}" name="product_quantity[{{ $product['product_id'] }}]" class="product_quantity_{{ $product['session_id']}} product_quantity form-control" ></td>
                                                                        <td><input type="number" min="1" value="{{ $product['product_price'] }}" name="product_price[{{ $product['product_id'] }}]" class="product_price_{{ $product['session_id'] }} product_price form-control"></td>
                                                                        <td><input type="number" min="1" value="{{ $product['product_price_retail'] }}" name="product_price_retail[{{ $product['product_id'] }}]" class="product_price_retail_{{ $product['session_id']}} form-control product_price_retail"></td>

                                                                        <td>
                                                                             <select name="product_size_id[{{ $product['product_id'] }}]" required="" class="product_size_id_{{ $product['session_id']}} form-control product_size_id">
                                                                                @foreach ($all_size as $key => $size)
                                                                                <option value="{{ $size->id }}">{{ $size->size }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" name="product_total[{{ $product['product_id'] }}]" class="form-control product_total"></td>
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
                                                        <button type="submit" value="submit" name="" class="product-import-add-save add-save btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Save</button>
                                                    </div>
                                                    <div class="text-lg-left mt-3 mt-lg-0">
                                                        <div class="float-left">
                                                            <p><b>Sub-total :</b></p>
                                                            <h3 class="total"></h3>
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
