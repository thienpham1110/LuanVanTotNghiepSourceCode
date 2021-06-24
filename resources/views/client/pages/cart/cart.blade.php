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
    <form action="#">
        <div class="row">
            <div class="col-12">
                <div class="table_desc">
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
                                    $total=$product['product_price']*$product['product_quantity'];
                                    $subtotal+=$total;
                                @endphp
                                <tr>
                                    <input type="hidden" name="product_session_id[{{ $product['product_id'] }}]" class="product_session_id_{{ $product['session_id'] }}" value="{{ $product['session_id'] }}">
                                    <td class="product_remove"><button class="btn btn-outline-danger delete-cart" data-id_product="{{ $product['session_id']}}" type="button"><i class="fa fa-trash-o"></i></button></td>
                                    <td class="product_thumb"><a href="#"><img src="{{asset('public/uploads/admin/product/'.$product['product_img'])}}" width="70px" height="75px" alt=""></a></td>
                                    <td class="product_name"><a href="#">{{ $product['product_name'] }}</a> <br><label>Size: {{ $product['product_size_name'] }}</label> </td>
                                    <td class="product-price">{{ $product['product_price'] }}</td>
                                    <td class="product_quantity"><input min="1" max="{{ $product['product_in_stock'] }}" value="{{ $product['product_quantity'] }}" type="number"></td>
                                    <td class="product_total">{{ $product['product_price'] * $product['product_quantity']}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                    </div>
                    <div class="cart_submit">
                        <button type="submit">update cart</button>
                    </div>
                </div>
             </div>
         </div>
         <!--coupon code area start-->
        <div class="coupon_area">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code">
                        <h3>Coupon</h3>
                        <div class="coupon_inner">
                            <p>Enter your coupon code if you have one.</p>
                            <input placeholder="Coupon code" type="text">
                            <button type="submit">Apply coupon</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code">
                        <h3>Calculate shipping</h3>
                        <div class="coupon_inner">
                            <p>Enter your calculate shipping code if you have one.</p>
                            <input placeholder="Calculate shipping" type="text">
                            <button type="submit">Apply shipping</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="coupon_code">
                        <h3>Cart Totals</h3>
                        <div class="coupon_inner">
                           <div class="cart_subtotal">
                               <p>Subtotal</p>
                               <p class="cart_amount">£215.00</p>
                           </div>
                           <div class="cart_subtotal ">
                               <p>Shipping</p>
                               <p class="cart_amount"><span>Flat Rate:</span> £255.00</p>
                           </div>
                           <a href="#">Calculate shipping</a>

                           <div class="cart_subtotal">
                               <p>Total</p>
                               <p class="cart_amount">£215.00</p>
                           </div>
                           <div class="checkout_btn">
                               <a href="#">Proceed to Checkout</a>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--coupon code area end-->
    </form>
 </div>
 <!--shopping cart area end -->
@endsection
