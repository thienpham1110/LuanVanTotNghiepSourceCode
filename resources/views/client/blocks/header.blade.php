<div class="header_top">
    <div class="row align-items-center">
         <div class="col-lg-6 col-md-6">
            <div class="switcher">
                <label for="">HOTLINE : <a class="link_a" href="">0961682847</a></label>
             </div>
         </div>
         <div class="col-lg-6 col-md-6">
             <div class="header_links">
                 <ul>
                     <li><a href="index_contact.php" title="Contact">Contact</a></li>
                     <li><a href="{{URL::to('/my-wishlists')}}" title="wishlist">My wishlist</a></li>
                     <li><a href="{{ URL::to('/order-tracking')}}" title="order tracking">Order Tracking</a></li>
                     <li><a href="{{ URL::to('/cart')}}" title="My cart">My cart</a></li>
                     @if(Session::get('customer_id')==true)
                     <li><a href="{{ URL::to('/my-account')}}" title="My account">My account</a></li>
                     <li><a href="{{URL::to('/logout-customer')}}" onclick="return confirm('You Sure?')"title="Logout">Logout</a></li>
                     @endif
                     @if(Session::get('customer_id')!=true)
                     <li><a href="{{ URL::to('/login-customer')}}" title="Login">Login</a></li>
                     <li><a href="{{ URL::to('/show-verification-email-customer')}}" title="Login">Register</a></li>
                     @endif
                 </ul>
             </div>
         </div>
    </div>
 </div>
 <!--header top end-->
 <!--breadcrumbs area start-->
 <div class="breadcrumbs_area">
     <div class="row hr1">
         <div class="col-12">
             <div class="breadcrumb_content hr3">
                 <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                     <div class="carousel-inner">
                         @foreach ($header_show as $key => $header)
                            @if($header->headerquangcao_thu_tu==$header_min)
                            <div class="carousel-item hr2 active">
                                {{ $header->headerquangcao_noi_dung }}
                            </div>
                            @else
                            <div class="carousel-item hr2">
                                {{ $header->headerquangcao_noi_dung }}
                            </div>
                            @endif

                         @endforeach
                     </div>
                     <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                     </button>
                     <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!--breadcrumbs area end-->
 <!--header middel-->
 <div class="header_middel">
     <div class="row align-items-center">
        <!--logo start-->
         <div class="col-lg-3 col-md-3">
             <div class="logo">
                 <a href="index.php"><img src="{{asset('public/frontend/img/logo/logo.png')}}" alt=""></a>
             </div>
         </div>
         <!--logo end-->
         <div class="col-lg-9 col-md-9">
             <div class="header_right_info">
                 <div class="search_bar">
                    <form action="{{URL::to ('/get-keyword-search')}}" method="POST">
                        @csrf
                        <input placeholder="Search..." required="" name="search_product_customer" type="text">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                 </div>
                 <div class="shopping_cart">

                     <!--mini cart-->
                     <div class="mini_cart">
                        @if(Session::get('cart')==true)
                            @php
                            $subtotal=0;
                            @endphp
                            @foreach (Session::get('cart') as $key=>$product)
                            @php
                            $subtotal+=$product['product_price']*$product['product_quantity'];
                            @endphp
                                <div class="cart_item">
                                    <div class="cart_img">
                                        <a href="#"><img src="{{asset('public/uploads/admin/product/'.$product['product_img'])}}" alt=""></a>
                                    </div>
                                    <div class="cart_info">
                                        <a href="#">{{ $product['product_name'] }}</a>
                                        <span class="cart_price">{{number_format($product['product_price']  ,0,',','.').' VNĐ' }}</span>
                                        <span class="quantity">Qty: {{ $product['product_quantity'] }}</span>
                                    </div>
                                    <div class="cart_remove">
                                        <a title="Remove this item" href="{{ URL::to('/delete-mini-cart/'.$product['session_id'])}}"><i class="fa fa-times-circle"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <h5 style="text-align: center">There Are No Products In The Cart</h5>
                        @endif
                         <div class="shipping_price">
                            <span> Shipping Fee</span>
                            <span>
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
                            </span>
                         </div>
                         <div class="total_price">
                            <span> total </span>
                            <span class="prices">
                                @if(Session::get('cart'))
                                    @if(Session::get('feeship'))
                                        {{number_format($subtotal+$fee_ship,0,',','.').' VNĐ' }}
                                    @else
                                        {{number_format($subtotal+35000,0,',','.').' VNĐ' }}
                                    @endif
                                @else
                                {{number_format(0,0,',','.').' VNĐ' }}
                                @endif
                            </span>
                         </div>
                         <div class="cart_button">
                            <a href="{{ URL::to('/cart')}}">My Cart</a>
                         </div>
                     </div>
                     <a href="#"><i class="fa fa-shopping-cart">
                        </i>
                        @if(Session::get('count_cart'))
                            @if(Session::get('count_cart')==0)
                                {{ Session::forget('count_cart') }}
                            @else
                                {{ Session::get('count_cart') }}
                            @endif
                        @else
                            0
                        @endif
                        Items -
                        @if(Session::get('cart'))
                            {{number_format($subtotal,0,',','.').' VNĐ' }}
                        @else
                            {{number_format(0,0,',','.').' VNĐ' }}
                        @endif
                        <i class="fa fa-angle-down"></i></a>
                     <!--mini cart end-->
                 </div>

             </div>
         </div>
     </div>
 </div>
