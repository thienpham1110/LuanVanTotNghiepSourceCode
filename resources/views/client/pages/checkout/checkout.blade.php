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
                    <li>checkout</li>
                </ul>

            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
<!--Checkout page section-->
<div class="Checkout_section">
    <div class="row">
           <div class="col-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {!! session()->get('message') !!}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {!! session()->get('error') !!}
                </div>
            @endif
                <div class="user-actions mb-20">
                    <h3>
                        <a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_login" aria-expanded="true">Click Here To Calculate Fee</a>
                    </h3>
                     <div id="checkout_login" class="collapse" data-parent="#accordion">

                        <div class="checkout_info">
                            <p>Calculate Fee</p>
                            <form action="{{ URL::to('/check-transport-feeship')}}" method="POST">
                                @csrf
                                <div class="col-12 mb-30">
                                    <label for="country">City <span>*</span></label>
                                    <select name="city" id="city" required="" class="choose city form-control ">
                                        <option>Choose City</option>
                                        @foreach ($city as $key=>$cty)
                                            <option value="{{$cty->id}}">{{ $cty->tinhthanhpho_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-30">
                                    <label for="country">Province <span>*</span></label>
                                    <select name="province" required="" id="province" class="choose province form-control">
                                        <option>Province</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-30">
                                    <label for="country">Wards <span>*</span></label>
                                    <select name="wards" required="" id="wards" class="wards form-control">
                                        <option >Wards</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-30">
                                    <div class="order_button">
                                        <button type="submit">Change Transport Fee</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="user-actions mb-20">
                    <h3>
                        <a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_coupon" aria-expanded="true">Click here to enter your code</a>
                    </h3>
                     <div id="checkout_coupon" class="collapse" data-parent="#accordion">
                        <div class="checkout_info">
                            @if(Session::get('cart'))
                                <form action="{{ URL::to('/check-coupon')}}" method="POST">
                                    @csrf
                                    <div class="coupon_inner">
                                        <input placeholder="Coupon code" name="cart_coupon" type="text">
                                        <input type="submit" class="check-coupon" name="check_coupon" value="Apply coupon">
                                    </div>
                                </form>
                            @else
                                <h4 style="text-align: center">There Are No Products In The Cart</h4>
                            @endif
                            {{-- <form action="#">
                                <input placeholder="Coupon code" type="text">
                                 <input value="Apply coupon" type="submit">
                            </form> --}}
                        </div>
                    </div>
                </div>
           </div>
        </div>
    <div class="checkout_form">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h3>Billing Details</h3>
                    <form action="{{ URL::to('/order-checkout-save')}}" method="POST">
                        @csrf
                            <div class="col-lg-12 mb-30">
                                <label>Name <span>*</span></label>
                                <input name="order_checkout_name" required="" type="text">
                            </div>
                            <div class="col-lg-12 mb-30">
                                <label> Email   <span>*</span></label>
                                  <input name="order_checkout_email" required="" type="text">
                            </div>
                            <div class="col-lg-12 mb-30">
                                <label>Phone<span>*</span></label>
                                <input name="order_checkout_phone_number" required="" type="number">
                            </div>

                            <div class="col-12 mb-30">
                                <label>address  <span>*</span></label>
                                <input name="order_checkout_address" required="" placeholder="Please enter the full form or you can choose below" type="text">
                            </div>
                            <div class="col-12 mb-30">
                                <label for="country">City <span>*</span></label>
                                <select name="order_city" id="order_city" required="" class="choose-address order_city form-control ">
                                    <option>Choose City</option>
                                    @foreach ($city as $key=>$cty)
                                        <option value="{{$cty->id}}">{{ $cty->tinhthanhpho_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-30">
                                <label for="country">Province <span>*</span></label>
                                <select name="order_province" required="" id="order_province" class="choose-address select-province form-control">
                                    <option>Province</option>
                                </select>
                            </div>
                            <div class="col-12 mb-30">
                                <label for="country">Wards <span>*</span></label>
                                <select name="order_wards" required="" id="order_wards" class="select-wards form-control">
                                    <option >Wards</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-30">
                                <div class="order-notes">
                                    <label for="order_note">Order Notes</label>
                                   <textarea id="order_note" name="order_checkout_note" required="" placeholder="Notes about your order"></textarea>
                               </div>
                            </div>
                            <div class="col-lg-12 mb-30">
                                <div class="payment_method">
                                    <div class="panel-default">
                                         <input id="payment" value="0" checked name="order_checkout_pay_method" type="radio">
                                         <label for="payment" data-toggle="collapse" data-target="#method" aria-controls="method">COD</label>
                                     </div>
                                    <div class="panel-default">
                                         <input id="payment_defult" value="1" name="order_checkout_pay_method" type="radio" >
                                         <label for="payment_defult" data-toggle="collapse" data-target="#collapsedefult" aria-controls="collapsedefult">Bank Transfer</label>
                                         <div id="collapsedefult" class="collapse one" data-parent="#accordion">
                                             <div class="card-body1">
                                                <p>Please transfer money to this account : 0123456789</p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                            </div>
                            <div class="col-12 mb-30">

                                <label for="account" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">
                                    <input id="account" name="order_checkout_create_account" value="1" type="checkbox" data-target="createp_account">
                                    Create an account?
                                </label>
                                <div id="collapseOne" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                       <label> User Name<span>*</span></label>
                                        <input placeholder="user name" name="checkout_order_user_name" type="text">
                                    </div>
                                    <br>
                                    <div class="card-body1">
                                        <label> Account password<span>*</span></label>
                                         <input placeholder="password" name="checkout_order_password" type="password">
                                     </div>
                                </div>
                            </div>
                            <div class="col-12 mb-30">
                                <div class="order_button">
                                    <button type="submit">Order Confirm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <form action="#">
                            <h3>Your order</h3>
                            <div class="order_table table-responsive mb-30">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
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
                                                    <td> {{ $product['product_name'] }} <strong> × {{ $product['product_quantity'] }}</strong></td>
                                                    <td>{{number_format( $product['product_price'] * $product['product_quantity'] ,0,',','.').' VNĐ' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cart Subtotal</th>
                                            <td>
                                                @if(Session::get('cart')==true)
                                                    {{number_format($subtotal,0,',','.').' VNĐ' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td>
                                                <strong>
                                                    @if(Session::get('feeship'))
                                                        @foreach (Session::get('feeship') as $k=>$fee)
                                                            @php
                                                                $fee_ship=$fee['fee'];
                                                            @endphp
                                                            {{number_format($fee_ship,0,',','.').' VNĐ' }}
                                                        @endforeach
                                                    @else
                                                    {{number_format(35000,0,',','.').' VNĐ' }}
                                                    @endif
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Coupon</th>
                                            <td>
                                                <strong>
                                                    @if(Session::get('coupon'))
                                                        @foreach (Session::get('coupon') as $key=>$cou)
                                                            @if($cou['coupon_type']==0)
                                                                @php
                                                                    $total_coupon =(($subtotal*$cou['coupon_number'])/100);
                                                                @endphp

                                                            @else
                                                                @php
                                                                    $total_coupon =$cou['coupon_number'];
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                       - {{number_format($total_coupon,0,',','.').' VNĐ' }}
                                                    @else
                                                       - {{number_format(0,0,',','.').' VNĐ' }}
                                                    @endif
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr class="order_total">
                                            <th>Order Total</th>
                                            <td><strong>
                                            @if(Session::get('cart'))
                                                @if(Session::get('coupon'))
                                                   @if(Session::get('feeship'))
                                                        {{number_format($subtotal+$fee_ship-$total_coupon,0,',','.').' VNĐ' }}
                                                   @else
                                                    {{number_format($subtotal-$total_coupon,0,',','.').' VNĐ' }}
                                                   @endif
                                                @else
                                                    @if(Session::get('feeship'))
                                                            {{number_format($subtotal+$fee_ship,0,',','.').' VNĐ' }}
                                                    @else
                                                        {{number_format($subtotal,0,',','.').' VNĐ' }}
                                                    @endif
                                                @endif
                                            @else
                                            {{number_format(0,0,',','.').' VNĐ' }}
                                            @endif
                                            </strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="payment_method">
                                 <div class="order_button">
                                     <a type="button" class="btn btn-warning" href="{{ URL::to('/cart')}}">Back To Cart</a>
                                     <a type="button" class="btn btn-success" href="{{ URL::to('/shop-now')}}" >Keep Shopping</a>
                                 </div>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    <!--Checkout page section end-->
@endsection
