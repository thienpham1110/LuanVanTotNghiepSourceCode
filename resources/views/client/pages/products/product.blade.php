@extends('client.index_layout')
@section('content')
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="row">
        <div class="col-12">
            <div class="breadcrumb_content">
                <ul>
                    <li><a href="{{URL::to ('/')}}">home</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <?php
                    $pages_name=Session::get('pages_name');
                    if($pages_name){
                        echo '<li>'.$pages_name.'</li>';
                        Session::put('pages_name',null);
                    }else{
                        echo '<li>Shop Now</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
<!--pos home section-->
<div class=" pos_home_section">
    <div class="row pos_home">
            <div class="col-lg-3 col-md-12">
               <!--layere categorie"-->
                  <div class="sidebar_widget shop_c">
                        <div class="categorie__titile">
                            <h4>Categories</h4>
                        </div>
                        <div class="layere_categorie">
                            <ul>
                                <li>
                                    <input id="acces" type="checkbox">
                                    <label for="acces">Accessories<span>(1)</span></label>
                                </li>
                                <li>
                                    <input id="dress" type="checkbox">
                                    <label for="dress">Dresses <span>(2)</span></label>
                                </li>
                                <li>
                                    <input id="tops" type="checkbox">
                                    <label for="tops">Tops<span>(3)</span></label>
                                </li>
                                <li>
                                    <input id="bag" type="checkbox">
                                    <label for="bag">HandBags<span>(4)</span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                <!--layere categorie end-->

                <!--layere categorie"-->
                <div class="sidebar_widget shop_c">
                        <div class="categorie__titile">
                            <h4>Brand</h4>
                        </div>
                        <div class="layere_categorie">
                            <ul>
                                <li>
                                    <input id="acces" type="checkbox">
                                    <label for="acces">Accessories<span>(1)</span></label>
                                </li>
                                <li>
                                    <input id="dress" type="checkbox">
                                    <label for="dress">Dresses <span>(2)</span></label>
                                </li>
                                <li>
                                    <input id="tops" type="checkbox">
                                    <label for="tops">Tops<span>(3)</span></label>
                                </li>
                                <li>
                                    <input id="bag" type="checkbox">
                                    <label for="bag">HandBags<span>(4)</span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                <!--layere categorie end-->

                <!--price slider start-->
                <div class="sidebar_widget price">
                    <h2>Price</h2>
                    <div class="ca_search_filters">

                        <input type="text" name="text" id="amount">
                        <div id="slider-range"></div>
                    </div>
                </div>
                <!--price slider end-->

                <!--wishlist block start-->
                <div class="sidebar_widget wishlist mb-30">
                    <div class="block_title">
                        <h3><a href="#">Wishlist</a></h3>
                    </div>
                    <div class="cart_item">
                       <div class="cart_img">
                           <a href="#"><img src="assets\img\cart\cart.jpg" alt=""></a>
                       </div>
                        <div class="cart_info">
                            <a href="#">lorem ipsum dolor</a>
                            <span class="cart_price">$115.00</span>
                            <span class="quantity">Qty: 1</span>
                        </div>
                        <div class="cart_remove">
                            <a title="Remove this item" href="#"><i class="fa fa-times-circle"></i></a>
                        </div>
                    </div>
                    <div class="cart_item">
                       <div class="cart_img">
                           <a href="#"><img src="assets\img\cart\cart2.jpg" alt=""></a>
                       </div>
                        <div class="cart_info">
                            <a href="#">Quisque ornare dui</a>
                            <span class="cart_price">$105.00</span>
                            <span class="quantity">Qty: 1</span>
                        </div>
                        <div class="cart_remove">
                            <a title="Remove this item" href="#"><i class="fa fa-times-circle"></i></a>
                        </div>
                    </div>
                    <div class="block_content">
                        <p>2  products</p>
                        <a href="#">» My wishlists</a>
                    </div>
                </div>
                <!--wishlist block end-->
                <!--newsletter block start-->
                <div class="sidebar_widget newsletter mb-30">
                    <div class="block_title">
                        <h3>newsletter</h3>
                    </div>
                    <form action="#">
                        <p>Sign up for your newsletter</p>
                        <input placeholder="Your email address" type="text">
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
                <!--newsletter block end-->
                <!--special product start-->
                <div class="sidebar_widget special">
                    <div class="block_title">
                        <h3>Special Products</h3>
                    </div>
                    <div class="special_product_inner mb-20">
                        <div class="special_p_thumb">
                            <a href="single-product.html"><img src="assets\img\cart\cart3.jpg" alt=""></a>
                        </div>
                        <div class="small_p_desc">
                            <div class="product_ratting">
                               <ul>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                               </ul>
                           </div>
                            <h3><a href="single-product.html">Lorem ipsum dolor</a></h3>
                            <div class="special_product_proce">
                                <span class="old_price">$124.58</span>
                                <span class="new_price">$118.35</span>
                            </div>
                        </div>
                    </div>
                    <div class="special_product_inner">
                        <div class="special_p_thumb">
                            <a href="single-product.html"><img src="assets\img\cart\cart18.jpg" alt=""></a>
                        </div>
                        <div class="small_p_desc">
                            <div class="product_ratting">
                               <ul>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                               </ul>
                           </div>
                            <h3><a href="single-product.html">Printed Summer</a></h3>
                            <div class="special_product_proce">
                                <span class="old_price">$124.58</span>
                                <span class="new_price">$118.35</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--special product end-->


            </div>
            <div class="col-lg-9 col-md-12">

                <!--shop toolbar start-->
                <div class="shop_toolbar mb-35">

                    <div class="list_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#large" role="tab" aria-controls="large" aria-selected="true"><i class="fa fa-th-large"></i></a>
                            </li>
                            {{--  <li>
                                <a data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false"><i class="fa fa-th-list"></i></a>
                            </li>  --}}
                        </ul>
                    </div>

                    <div class="select_option">
                        <form action="#">
                            <label>Sort By</label>
                            <select name="orderby" id="short">
                                <option selected="" value="1">Position</option>
                                <option value="1">Price: Lowest</option>
                                <option value="1">Price: Highest</option>
                                <option value="1">Product Name:Z</option>
                                <option value="1">Sort by price:low</option>
                                <option value="1">Product Name: Z</option>
                                <option value="1">In stock</option>
                                <option value="1">Product Name: A</option>
                                <option value="1">In stock</option>
                            </select>
                        </form>
                    </div>
                </div>
                <!--shop toolbar end-->

                <!--shop tab product-->
                <div class="shop_tab_product">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="large" role="tabpanel">
                            <div class="row">
                                @foreach ($all_product as $key => $product)
                                <div class="col-lg-4 col-md-6">
                                    <div class="single_product">
                                        <div class="product_thumb">
                                           <a href="single-product.html"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                                           <div class="img_icone">
                                               <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                           </div>
                                        </div>
                                        <div class="product_content content_price mb-15">
                                            @if(isset($all_product_discount))
                                                @foreach ($all_product_discount as $key =>$value)
                                                    @if($value->Discount->khuyenmai_trang_thai==1)
                                                        @if($value->sanpham_id==$product->id)
                                                            <span class="old-price">{{number_format($product->sanpham_gia_ban).' VNĐ' }}</span>
                                                            <span class="product_price">
                                                                @if($value->Discount->khuyenmai_loai==1)
                                                                {{number_format( $product->sanpham_gia_ban -(($product->sanpham_gia_ban * $value->Discount->khuyenmai_gia_tri)/100) ).' VND' }}
                                                                @else
                                                                {{number_format( $product->sanpham_gia_ban - $product_discount->khuyenmai_gia_tri ).' VND' }}
                                                                @endif
                                                            </span>
                                                        @endif
                                                    @else
                                                        @if($value->sanpham_id==$product->id)
                                                            <span class="old-price">{{number_format($product->sanpham_gia_ban).' VNĐ' }} Ends Promotion</span>
                                                            <span class="product_price">
                                                                @if($value->Discount->khuyenmai_loai==1)
                                                                {{number_format( $product->sanpham_gia_ban -(($product->sanpham_gia_ban * $value->Discount->khuyenmai_gia_tri)/100) ).' VND' }}
                                                                @else
                                                                {{number_format( $product->sanpham_gia_ban - $product_discount->khuyenmai_gia_tri ).' VND' }}
                                                                @endif
                                                            </span>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else
                                            <span class="product_price">
                                                {{number_format($product->sanpham_gia_ban).' VNĐ' }}
                                            </span>
                                            @endif
                                            <h3 class="product_title"><a href="{{URL::to('/product-detail/'.$product->id)}}">{{ $product->sanpham_ten }}</a></h3>
                                        </div>
                                        <div class="product_info">
                                            <ul>
                                                <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                <li><a href="{{URL::to('/product-detail/'.$product->id)}}"  title="Quick view">View Detail</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{--  <div class="tab-pane fade" id="list" role="tabpanel">
                            @foreach ($all_product as $key => $product)
                            <div class="product_list_item mb-35">
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product_thumb">
                                           <a href="single-product.html"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                                           <div class="hot_img">
                                               <img src="assets\img\cart\span-hot.png" alt="">
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-6 col-sm-6">
                                        <div class="list_product_content">
                                           <div class="product_ratting">
                                               <ul>
                                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                                   <li><a href="#"><i class="fa fa-star"></i></a></li>
                                               </ul>
                                           </div>
                                            <div class="list_title">
                                                <h3><a href="{{URL::to('/product-detail/'.$product->id)}}">{{ $product->sanpham_ten }}</a></h3>
                                            </div>
                                            <p class="design">{{ $product->sanpham_mo_ta }}</p>

                                            <p class="compare">
                                                <input id="select" type="checkbox">
                                                <label for="select">Select to compare</label>
                                            </p>
                                            <div class="content_price">
                                                <span>$118.00</span>
                                                <span class="old-price">$130.00</span>
                                            </div>
                                            <div class="add_links">
                                                <ul>
                                                    <li><a href="#" title="add to cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                                                    <li><a href="#" title="add to wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>  --}}
                    </div>
                </div>
                <!--shop tab product end-->
                <!--pagination style start-->
                <div class="pagination_style">
                    <div class="page_number">

                        {{--  <span>Pages: </span>  --}}
                        <ul>
                            <li> {{ $all_product->links('layout.paginationlinks') }}</li>
                            {{--  <li class="current_number">1</li>
                            <li><a href="#">2</a></li>
                            <li>»</li>  --}}
                        </ul>
                    </div>
                </div>
                <!--pagination style end-->
            </div>
        </div>
</div>
<!--pos home section end-->
@endsection
