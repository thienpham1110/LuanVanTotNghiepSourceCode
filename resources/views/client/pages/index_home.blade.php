@extends('client.index_layout')
@section('content')
                        <div class="pos_home_section">

                            <div class="row">
                               <!--banner slider start-->
                               @include('client.blocks.slideshow')
                                 <!--banner slider end -->
                            </div>
                            <!--banner area start-->
                            <div class="banner_area banner_two">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_banner">
                                            <a href="#"><img src="{{asset('public/frontend/img/banner/banner7.jpg')}}" alt=""></a>
                                            <div class="banner_title">
                                                <p>Up to <span> 40%</span> off</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_banner">
                                            <a href="#"><img src="{{asset('public/frontend/img/banner/banner8.jpg')}}" alt=""></a>
                                            <div class="banner_title title_2">
                                                <p>sale off <span> 30%</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_banner">
                                            <a href="#"><img src="{{asset('public/frontend/img/banner/banner11.jpg')}}" alt=""></a>
                                            <div class="banner_title title_3">
                                                <p>sale off <span> 30%</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--banner area end-->
                             <!--new product area start-->
                            <div class="new_product_area product_two">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="block_title">
                                        <h3>  New Products</h3>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="single_p_active owl-carousel">
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product1.jpg')}}" alt=""></a>
                                                   <div class="img_icone">
                                                       <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$50.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Curabitur sodales</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product2.jpg')}}" alt=""></a>
                                                   <div class="hot_img">
                                                       <img src="{{asset('public/frontend/img/cart/span-hot.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$40.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Quisque ornare dui</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product3.jpg')}}" alt=""></a>
                                                   <div class="img_icone">
                                                       <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$60.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Sed non turpiss</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product4.jpg')}}" alt=""></a>
                                                   <div class="hot_img">
                                                       <img src="{{asset('public/frontend/img/cart/span-hot.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$65.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Duis convallis</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product6.jpg')}}" alt=""></a>
                                                   <div class="img_icone">
                                                       <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$50.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Curabitur sodales</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--new product area start-->



                            <!--featured product area start-->
                            <div class="new_product_area product_two">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="block_title">
                                        <h3>   featured Products</h3>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="single_p_active owl-carousel">
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product7.jpg')}}" alt=""></a>
                                                   <div class="img_icone">
                                                       <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$50.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Curabitur sodales</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product8.jpg')}}" alt=""></a>
                                                   <div class="hot_img">
                                                       <img src="{{asset('public/frontend/img/cart/span-hot.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$40.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Quisque ornare dui</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product9.jpg')}}" alt=""></a>
                                                   <div class="img_icone">
                                                       <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$60.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Sed non turpiss</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product3.jpg')}}" alt=""></a>
                                                   <div class="hot_img">
                                                       <img src="{{asset('public/frontend/img/cart/span-hot.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$65.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Duis convallis</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="single_product">
                                                <div class="product_thumb">
                                                   <a href="single-product.html"><img src="{{asset('public/frontend/img/product/product2.jpg')}}" alt=""></a>
                                                   <div class="img_icone">
                                                       <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                                   </div>
                                                   <div class="product_action">
                                                       <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                   </div>
                                                </div>
                                                <div class="product_content">
                                                    <span class="product_price">$50.00</span>
                                                    <h3 class="product_title"><a href="single-product.html">Curabitur sodales</a></h3>
                                                </div>
                                                <div class="product_info">
                                                    <ul>
                                                        <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick view">View Detail</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--featured product area start-->

                            <!--blog area start-->
                            <div class="blog_area blog_two">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_blog">
                                            <div class="blog_thumb">
                                                <a href="blog-details.html"><img src="{{asset('public/frontend/img/blog/blog3.jpg')}}" alt=""></a>
                                            </div>
                                            <div class="blog_content">
                                                <div class="blog_post">
                                                    <ul>
                                                        <li>
                                                            <a href="#">Tech</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.html">When an unknown took a galley of type.</a></h3>
                                                <p>Distinctively simplify dynamic resources whereas prospective core competencies. Objectively pursue multidisciplinary human capital for interoperable.</p>
                                                <div class="post_footer">
                                                    <div class="post_meta">
                                                        <ul>
                                                            <li>Jun 20, 2018</li>
                                                            <li>3 Comments</li>
                                                        </ul>
                                                    </div>
                                                    <div class="Read_more">
                                                        <a href="blog-details.html">Read more  <i class="fa fa-angle-double-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_blog">
                                            <div class="blog_thumb">
                                                <a href="blog-details.html"><img src="{{asset('public/frontend/img/blog/blog4.jpg')}}" alt=""></a>
                                            </div>
                                            <div class="blog_content">
                                                <div class="blog_post">
                                                    <ul>
                                                        <li>
                                                            <a href="#">Men</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.html">When an unknown took a galley of type.</a></h3>
                                                <p>Distinctively simplify dynamic resources whereas prospective core competencies. Objectively pursue multidisciplinary human capital for interoperable.</p>
                                                <div class="post_footer">
                                                    <div class="post_meta">
                                                        <ul>
                                                            <li>Jun 20, 2018</li>
                                                            <li>3 Comments</li>
                                                        </ul>
                                                    </div>
                                                    <div class="Read_more">
                                                        <a href="blog-details.html">Read more  <i class="fa fa-angle-double-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_blog">
                                            <div class="blog_thumb">
                                                <a href="blog-details.html"><img src="{{asset('public/frontend/img/blog/blog1.jpg')}}" alt=""></a>
                                            </div>
                                            <div class="blog_content">
                                                <div class="blog_post">
                                                    <ul>
                                                        <li>
                                                            <a href="#">Women</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h3><a href="blog-details.html">When an unknown took a galley of type.</a></h3>
                                                <p>Distinctively simplify dynamic resources whereas prospective core competencies. Objectively pursue multidisciplinary human capital for interoperable.</p>
                                                <div class="post_footer">
                                                    <div class="post_meta">
                                                        <ul>
                                                            <li>Jun 20, 2018</li>
                                                            <li>3 Comments</li>
                                                        </ul>
                                                    </div>
                                                    <div class="Read_more">
                                                        <a href="blog-details.html">Read more  <i class="fa fa-angle-double-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--blog area end-->

                            <!--brand logo strat-->
                            <div class="brand_logo brand_two">
                                <div class="block_title">
                                    <h3>Brands</h3>
                                </div>
                                <div class="row">
                                    <div class="brand_active owl-carousel">
                                        <div class="col-lg-2">
                                            <div class="single_brand">
                                                <a href="#"><img src="{{asset('public/frontend/img/brand/brand1.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="single_brand">
                                                <a href="#"><img src="{{asset('public/frontend/img/brand/brand2.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="single_brand">
                                                <a href="#"><img src="{{asset('public/frontend/img/brand/brand3.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="single_brand">
                                                <a href="#"><img src="{{asset('public/frontend/img/brand/brand4.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="single_brand">
                                                <a href="#"><img src="{{asset('public/frontend/img/brand/brand5.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="single_brand">
                                                <a href="#"><img src="{{asset('public/frontend/img/brand/brand6.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--brand logo end-->
                        </div>
                        @endsection
