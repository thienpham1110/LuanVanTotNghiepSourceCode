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
                                <a href="{{URL::to('/order-add-show-product')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle  mr-1"></i>Add Product</a>
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
                                        <form action="{{URL::to('/order-add-save')}}" method="POST" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label class="col-form-label">Product Import</label>
                                                    <div class="table-responsive" id="ajax-queue">
                                                        <table class="table table-hover  mb-0">
                                                            <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <td>Product Name</td>
                                                                <td>Size</td>
                                                                <td>Price</td>
                                                                <td>Quantity</td>
                                                                <td>Total</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="show-list-product-order">
                                                                <form >
                                                                    @csrf
                                                                    @if(Session::get('order_admin')==true)
                                                                        @php
                                                                        $subtotal=0;
                                                                        @endphp
                                                                        @foreach (Session::get('order_admin') as $key=> $product )
                                                                            @php
                                                                                $total=$product['product_price']*$product['product_quantity'];
                                                                                $subtotal+=$total;
                                                                            @endphp
                                                                            <tr>
                                                                                <td scope="row">
                                                                                    <button type="button" data-id_product="{{ $product['session_id']}}" name="delete-row-order-admin" class="delete-row-order-admin btn btn-danger waves-effect waves-light btn-sm">
                                                                                        <i class="mdi mdi-close mr-1"></i>
                                                                                    </button>
                                                                                </td>
                                                                                <td>{{ $product['product_name'] }}</td>
                                                                                <td>{{ $product['product_size_name'] }}</td>
                                                                                <td>{{ $product['product_price'] }}</td>
                                                                                <input type="hidden" name="product_id[{{ $product['product_id'] }}]" class="product_id_{{ $product['session_id'] }}" value="{{ $product['product_id'] }}">
                                                                                <input type="hidden" name="product_session_id[{{ $product['product_id'] }}]" class="product_session_id_{{ $product['session_id'] }}" value="{{ $product['session_id'] }}">
                                                                                <input type="hidden" name="product_size_id[{{ $product['product_id'] }}]" class="product_size_id_{{ $product['session_id'] }}" value="{{ $product['product_size_id'] }}">
                                                                                <input type="hidden" name="product_size_name[{{ $product['product_id'] }}]" class="product_size_name_{{ $product['session_id'] }}" value="{{ $product['product_size_name'] }}">
                                                                                <input type="hidden" name="product_price[{{ $product['product_id'] }}]" class="product_price_{{ $product['session_id'] }} product_price" value="{{ $product['product_price'] }}">
                                                                                <input type="hidden" name="product_name[{{ $product['product_id'] }}]" class="product_name_{{ $product['session_id'] }}" value="{{ $product['product_name'] }}">
                                                                                <td><input type="number" min="1" max="{{ $product['product_in_stock']}}" value="{{ $product['product_quantity'] }}" name="product_quantity[]" class="product_quantity_{{ $product['session_id']}} product_quantity form-control" ></td>
                                                                                <td><input type="text" value="{{$total}}" name="product_total[{{ $product['product_id'] }}]" class="form-control product_total"></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </form>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-form-label">Delivery Information</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-form-label">Customer</label>
                                                                    <input type="text" name="order_customer" class="form-control" required="" placeholder="Thien">
                                                                    <label class="col-form-label">Email</label>
                                                                    <input type="text" name="order_email" class="form-control" required="" placeholder="cus@gmail.com">
                                                                    <label class="col-form-label">Phone Number</label>
                                                                    <input type="number" name="order_phone_number" class="form-control" required="" placeholder="096...">
                                                                    <label class="col-form-label">Address</label>
                                                                    <input type="text" name="order_address" class="form-control" required="" placeholder="HCM">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-form-label">Transport</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label class="col-form-label">City</label>
                                                                            <select name="city" id="city" class="choose required city form-control">
                                                                                <option>Choose City</option>
                                                                                @foreach ($city as $key=>$cty)
                                                                                    <option value="{{$cty->id}}">{{ $cty->tinhthanhpho_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <label class="col-form-label">Province</label>
                                                                            <select name="province" id="province" class="choose required province form-control">
                                                                                <option>Province</option>
                                                                            </select>
                                                                            <label class="col-form-label">Wards</label>
                                                                            <select name="wards" id="wards" class="wards required form-control">
                                                                                <option >Wards</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-form-label">Note</label>
                                                                    <textarea class="form-control" name="order_note"  placeholder="Des.."></textarea>
                                                                    <label class="col-form-label">Discoutn</label>
                                                                    <input type="number" min="0" name="product_order_discount" class="form-control product_order_discount" placeholder="coupon code">
                                                                    <label class="col-form-label">Payment Status</label>
                                                                    <select name="order_payment" class="form-control">
                                                                        <option value="1">Paid</option>
                                                                        <option value="0">Unpaid</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="text-lg-left mt-3 mt-lg-0">
                                                                <div class="float-left">
                                                                    <p><b>Sub-total:</b> <span class="float-right total" ></span></p>
                                                                     <h3 class="total"></h3>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <div class="text-lg-right mt-3 mt-lg-0">
                                                                        <button type="submit" value="submit" name="" class="product-import-add-save add-save btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-content-save mr-1"></i>Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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