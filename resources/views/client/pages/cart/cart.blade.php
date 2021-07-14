@extends('client.index_layout')
@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="row">
        <div class="col-12">
            <div class="breadcrumb_content">
                <ul>
                    <li><a href="index.html">home</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li>Shopping Cart</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
 <!--shopping cart area start -->
<div class="shopping_cart_area">
    <form action="{{ URL::to('/update-cart')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="table_cart">
                    <div class="cart_page table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product_remove">Delete</th>
                                    <th class="product_thumb">Image</th>
                                    <th class="product_name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product_quantity">Quantity</th>
                                    <th class="product_total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(Session::get('cart')==true)
                                    @php
                                        $subtotal=0;
                                    @endphp
                                    @foreach (Session::get('cart') as $key =>$product)
                                        @php
                                            $subtotal+=$product['product_price']*$product['product_quantity'];
                                        @endphp
                                        <tr>
                                            <input type="hidden" name="product_session_id[{{ $product['product_id'] }}]" class="product_session_id_{{ $product['session_id'] }}" value="{{ $product['session_id'] }}">
                                            <td class="product_remove"><button class="btn btn-outline-danger delete-cart" data-id_product="{{ $product['session_id']}}" type="button"><i class="fa fa-trash-o"></i></button></td>
                                            <td class="product_thumb"><a href="#"><img src="{{asset('public/uploads/admin/product/'.$product['product_img'])}}" width="70px" height="75px" alt=""></a></td>
                                            <td class="product_name"><a href="#">{{ $product['product_name'] }}</a> <br><label>Size: {{ $product['product_size_name'] }}</label> </td>
                                            <td class="product-price">{{number_format($product['product_price']  ,0,',','.').' VNĐ' }}</td>
                                            <td class="product_quantity"><input min="1" name="cart_quantity[{{$product['session_id']}}]" max="{{ $product['product_in_stock'] }}" value="{{ $product['product_quantity'] }}" type="number"></td>
                                            <td class="product_total">{{number_format( $product['product_price'] * $product['product_quantity'] ,0,',','.').' VNĐ' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr >
                                    <td colspan="6" ><h4 style="text-align: center">There Are No Products In The Cart</h4>
                                        <a type="button" class="btn btn-danger" href="{{ URL::to('/shop-now')}}" >Shop Now</a>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(Session::get('cart')==true)
                    <div class="cart_submit">
                        <button type="submit" >update cart</button>
                    </div>
                    @endif
                </div>
             </div>
         </div>
        </form>
         <!--coupon code area start-->
        <div class="coupon_area">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code">
                        <h3>Coupon</h3>
                        @if(Session::get('cart'))
                            <form action="{{ URL::to('/check-coupon')}}" method="POST">
                                @csrf
                                <div class="coupon_inner">
                                    <p>Enter your coupon code if you have one.</p>
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {!! session()->get('message') !!}
                                        </div>
                                    @elseif(session()->has('error'))
                                        <div class="alert alert-danger">
                                            {!! session()->get('error') !!}
                                        </div>
                                    @endif
                                    <input placeholder="Coupon code" required="" name="cart_coupon" type="text">
                                    <button type="submit" class="check-coupon">Apply coupon</button>
                                </div>
                            </form>
                        @else
                            <h4 style="text-align: center">There Are No Products In The Cart</h4>
                        @endif
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-md-3">
                    <div class="coupon_code">
                        <h3>Calculate shipping</h3>
                        <form >
                            @csrf
                        <div class="coupon_inner">
                            <p>Enter your calculate shipping code if you have one.</p>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <select name="city" id="city" class="choose city form-control">
                                        <option>Choose City</option>
                                        @foreach ($city as $key=>$cty)
                                            <option value="{{$cty->id}}">{{ $cty->tinhthanhpho_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <select name="province" id="province" class="choose province form-control">
                                        <option>Province</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <select name="wards" id="wards" class="wards form-control">
                                        <option >Wards</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="choose city form-control">Apply shipping</button>
                        </div>
                    </form>
                    </div>
                </div> --}}
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code">
                        <h3>Cart Totals</h3>
                        <div class="coupon_inner">
                            <div class="cart_subtotal">
                                <p>Subtotal</p>
                                <p class="cart_amount">
                                    @if(Session::get('cart')==true)
                                    {{number_format($subtotal,0,',','.').' VNĐ' }}
                                    @endif
                                </p>
                            </div>
                            <div class="cart_subtotal ">
                                 <p>Coupon</p>
                                 <p class="cart_amount"><span>Discount:
                                    @if(Session::get('cart')==true)
                                        @if(Session::get('coupon'))
                                            @foreach (Session::get('coupon') as $key=>$cou)
                                                @if($cou['coupon_type']==0)
                                                    {{ $cou['coupon_number'] }} %
                                                    @php
                                                        $total_coupon =$subtotal- (($subtotal*$cou['coupon_number'])/100);
                                                    @endphp
                                                @else
                                                {{number_format( $cou['coupon_number'],0,',','.').' VNĐ' }}
                                                    @php
                                                        $total_coupon =$subtotal-$cou['coupon_number'];
                                                    @endphp
                                                @endif
                                            @endforeach
                                            </span>
                                            {{number_format($total_coupon,0,',','.').' VNĐ' }}
                                        @endif
                                    @else
                                    No Products
                                    @endif
                                </p>
                             </div>
                            <div class="cart_subtotal">
                                <p>Total</p>
                                <p class="cart_amount">
                                    @if(Session::get('cart')==true)
                                    @if(Session::get('coupon'))
                                        @foreach (Session::get('coupon') as $key=>$cou)
                                            @if($cou['coupon_type']==0)
                                                @php
                                                    $total_coupon =$subtotal- (($subtotal*$cou['coupon_number'])/100);
                                                @endphp

                                            @else
                                                @php
                                                    $total_coupon =$subtotal-$cou['coupon_number'];
                                                @endphp
                                            @endif
                                        @endforeach
                                        </span>
                                        {{number_format($total_coupon,0,',','.').' VNĐ' }}
                                    @else
                                    {{number_format($subtotal,0,',','.').' VNĐ' }}
                                    @endif
                                </p>
                            </div>
                            <div class="checkout_btn">
                               @if(Session::get('customer_id')!=NULL)
                                <a href="{{ URL::to('/checkout')}}">Proceed to Checkout</a>
                               @else
                               <a href="{{ URL::to('/login-customer')}}">Proceed to Checkout</a>
                               @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--coupon code area end-->

 </div>
 <!--shopping cart area end -->
@endsection
