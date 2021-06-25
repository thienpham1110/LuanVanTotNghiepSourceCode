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
                    <li>product detail</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--product wrapper start-->
<div class="product_details video_details">
    <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="product_tab product_video fix">
                    <div class="tab-content produc_tab_c">
                        <div class="tab-pane fade show active" id="p_tab1" role="tabpanel">
                            <div class="modal_img">
                                <a href="#"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                                <div class="img_icone">
                                   <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                               </div>
                                <div class="view_img">
                                    <a class="large_view" href="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}"><i class="fa fa-search-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="p_tab2" role="tabpanel">
                            <div class="modal_img">
                                <a href="#"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                                <div class="img_icone">
                                   <img src="assets\img\cart\span-new.png" alt="">
                               </div>
                                <div class="view_img">
                                    <a class="large_view" href="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}"><i class="fa fa-search-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="p_tab3" role="tabpanel">
                            <div class="modal_img">
                                <a href="#"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                                <div class="img_icone">
                                   <img src="assets\img\cart\span-new.png" alt="">
                               </div>
                                <div class="view_img">
                                    <a class="large_view" href="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}"><i class="fa fa-search-plus"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="product_tab_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#p_tab1" role="tab" aria-controls="p_tab1" aria-selected="false"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                            </li>
                            <li>
                                 <a data-toggle="tab" href="#p_tab2" role="tab" aria-controls="p_tab2" aria-selected="false"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                            </li>
                            <li>
                               <a data-toggle="tab" href="#p_tab3" role="tab" aria-controls="p_tab3" aria-selected="false"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-6">
                <div class="product_d_right">
                    <h1>{{ $product->sanpham_ten }}</h1>
                     <div class="product_ratting mb-10">
                        <ul>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"> Write a review </a></li>
                        </ul>
                    </div>
                    <div class="product_desc">
                        <p>{{ $product->sanpham_mo_ta }}</p>
                    </div>

                    <div class="content_price mb-15">
                        @if(isset($product_discount))
                            @if($product_discount->sanpham_id==$product->id)
                                <span>
                                    @if($product_discount->Discount->khuyenmai_loai==1)
                                    {{number_format( $product->sanpham_gia_ban -(($product->sanpham_gia_ban * $product_discount->Discount->khuyenmai_gia_tri)/100) ).' VND' }}
                                    @else
                                    {{number_format( $product->sanpham_gia_ban - $product_discount->khuyenmai_gia_tri ).' VND' }}
                                    @endif
                                </span>
                                <span class="old-price">{{number_format($product->sanpham_gia_ban).' VNĐ' }}</span>
                            @endif
                        @else
                        <span>
                            {{number_format($product->sanpham_gia_ban).' VNĐ' }}
                        </span>
                        @endif
                    </div>
                    <form action="{{ URL::to('/add-cart') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="box_quantity mb-20 ">
                                <h5>quantity</h5>
                                <input name="product_quantity" class="product_quantity_{{ $product->id }}" min="1"
                                @php
                                    $qty_in_stock=0;
                                @endphp
                                @foreach ($get_in_stock as $key=>$in_stock )
                                @php
                                    $qty_in_stock += $in_stock->sanphamtonkho_so_luong_ton;
                                @endphp
                                @endforeach
                                max="{{ $qty_in_stock }}"
                                 value="1" type="number">
                                <input name="product_id" value="{{ $product->id }}" class="product_id_{{ $product->id }}" type="hidden">
                                <input name="product_img" value="{{ $product->sanpham_anh }}" class="product_img_{{ $product->id }}" type="hidden">
                                <input name="product_name" value="{{ $product->sanpham_ten }}" class="product_name_{{ $product->id }}" type="hidden">
                                <input name="product_price" class="product_price_{{ $product->id }}"
                                @if(isset($product_discount))
                                    @if($product_discount->sanpham_id==$product->id)
                                        @if($product_discount->Discount->khuyenmai_loai==1)
                                            value="{{number_format( $product->sanpham_gia_ban -(($product->sanpham_gia_ban * $product_discount->Discount->khuyenmai_gia_tri)/100) ,0,',','') }}"
                                        @else
                                            value="{{number_format( $product->sanpham_gia_ban - $product_discount->khuyenmai_gia_tri ,0,',','') }}"
                                        @endif
                                    @endif
                                @else
                                    value="{{number_format($product->sanpham_gia_ban ,0,',','') }}"
                                @endif
                                 type="hidden">
                                <button type="button" data-id_product="{{ $product->id}}" class="add-to-cart"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                <a href="#" title="add to wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a>
                        </div>
                        <div class="product_d_size mb-20 col-md-3">
                            <label for="group_1" class="col-6">size</label>
                            <select name="product_size_id" class="product_size_id_{{ $product->id }} form-control" id="group_1">
                                @foreach ($all_size as $key=>$size )
                                <option value="{{ $size->size_id }}">{{$size->Size->size}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="product_stock mb-20">
                       <p>{{$qty_in_stock }} items</p>
                        <span>
                            @if($qty_in_stock>0)
                            In Stock
                            @else
                            Sold Out
                            @endif
                        </span>
                    </div>
                    {{--  <div class="wishlist-share">
                        <h4>Share on:</h4>
                        <ul>
                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                            <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                            <li><a href="#"><i class="fa fa-tumblr"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>  --}}
                </div>
            </div>
        </div>
</div>
<!--product details end-->


<!--product info start-->
<div class="product_d_info">
    <div class="row">
        <div class="col-12">
            <div class="product_d_inner">
                <div class="product_info_button">
                    <ul class="nav" role="tablist">
                        <li>
                            <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">More info</a>
                        </li>
                        <li>
                             <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Data sheet</a>
                        </li>
                        <li>
                           <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <div class="product_info_content">
                            <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman's wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="sheet" role="tabpanel">
                        <div class="product_d_table">
                           <form action="#">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="first_child">Compositions</td>
                                            <td>Polyester</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">Styles</td>
                                            <td>Girly</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">Properties</td>
                                            <td>Short Dress</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="product_info_content">
                            <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman's wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="product_info_content">
                            <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman's wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>
                        </div>
                        <div class="product_info_inner">
                            <div class="product_ratting mb-10">
                                <ul>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                </ul>
                                <strong>Posthemes</strong>
                                <p>09/07/2018</p>
                            </div>
                            <div class="product_demo">
                                <strong>demo</strong>
                                <p>That's OK!</p>
                            </div>
                        </div>
                        <div class="product_review_form">
                            <form action="#">
                                <h2>Add a review </h2>
                                <p>Your email address will not be published. Required fields are marked </p>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="review_comment">Your review </label>
                                        <textarea name="comment" id="review_comment"></textarea>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="author">Name</label>
                                        <input id="author" type="text">

                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="email">Email </label>
                                        <input id="email" type="text">
                                    </div>
                                </div>
                                <button type="submit">Submit</button>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product info end-->


<!--new product area start-->
<div class="new_product_area product_page">
    <div class="row">
        <div class="col-12">
            <div class="block_title">
            <h3>  11 other products category:</h3>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="single_p_active owl-carousel">
            @foreach ($all_product as $key => $product )
            <div class="col-lg-3">
                <div class="single_product">
                    <div class="product_thumb">
                       <a href="single-product.html"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                       <div class="img_icone">
                           <img src="assets\img\cart\span-new.png" alt="">
                       </div>
                       <div class="product_action">
                           <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                       </div>
                    </div>
                    <div class="product_content">
                        <span class="product_price">$500</span>
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
</div>
<!--new product area start-->


<!--new product area start-->
<div class="new_product_area product_page">
    <div class="row">
        <div class="col-12">
            <div class="block_title">
            <h3>Related Products</h3>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="single_p_active owl-carousel">
            @foreach ($related_product as $key => $product )
            <div class="col-lg-3">
                <div class="single_product">
                    <div class="product_thumb">
                       <a href="single-product.html"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                       <div class="img_icone">
                           <img src="assets\img\cart\span-new.png" alt="">
                       </div>
                       <div class="product_action">
                           <a href="#"> <i class="fa fa-shopping-cart"></i> Add to cart</a>
                       </div>
                    </div>
                    <div class="product_content">
                        <span class="product_price">$500</span>
                        <h3 class="product_title"><a href="{{URL::to('/product-detail/'.$product->id)}}">{{ $product->sanpham_ten }}</a></h3>
                    </div>
                    <div class="product_info">
                        <ul>
                            <li><a href="#" title=" Add to Wishlist ">Add to Wishlist</a></li>
                            <li><a href="{{URL::to('/product-detail/'.$product->id)}}" title="Quick view">View Detail</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--new product area start-->
@endsection
