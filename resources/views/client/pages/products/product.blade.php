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
                    $search_keywword=Session::get('search_keyword');
                    if($pages_name){
                        echo '<li>'.$pages_name.'</li>';
                        Session::put('pages_name',null);
                    }elseif($search_keywword){
                        echo '<li>'.$search_keywword.'</li>';
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

                <!--wishlist block start-->
                <div class="sidebar_widget wishlist mb-30">
                    <div class="block_title">
                        <h3><a href="#">Wishlist</a></h3>
                    </div>
                    <div id="list_row_wishlist">
                    </div>

                    <div class="block_content">
                        <p id="count_product_wishlist">
                        </p>
                        <a href="{{URL::to('/my-wishlists')}}">» My wishlists</a>
                    </div>
                </div>
                <!--wishlist block end-->
                <!--special product start-->
                <div class="sidebar_widget special">
                    <div class="block_title">
                        <h3>Special Products</h3>
                    </div>
                    @php
                        $count=0;
                    @endphp
                    @foreach ($all_product_rate as $key => $pro_rating)
                        @if($count==5)
                            @break
                        @else
                            <div class="special_product_inner mb-20">
                                <div class="special_p_thumb">
                                    <a href="{{URL::to('/product-detail/'.$pro_rating->id)}}"><img src="{{asset('public/uploads/admin/product/'.$pro_rating->sanpham_anh)}}" class="pro-img-rating" width="60px" height="80px" alt=""></a>
                                </div>
                                <div class="small_p_desc">
                                    <div class="product_ratting">
                                    <ul>
                                        @php
                                        $sum=0;
                                        $count_rate=0;
                                        @endphp
                                        @foreach($comment_customer as $k=>$comment_cus)
                                            @if ($comment_cus->sanpham_id==$pro_rating->id)
                                            @php
                                                $sum+=$comment_cus->binhluan_diem_danh_gia;
                                                $count_rate++;
                                            @endphp
                                            @endif
                                        @endforeach
                                        @php
                                        if($count_rate!=0){
                                            $average=$sum/$count_rate;
                                        }else{
                                            $average=0;
                                        }
                                        @endphp
                                        @for($count = 1; $count <=5; $count++)
                                            @if($count <= $average)
                                                <i class="fa fa-star ratting_review"></i>
                                            @else
                                                <i class="fa fa-star ratting_no_review"></i>
                                            @endif
                                        @endfor
                                    </ul>
                                </div>
                                    <h3><a href="single-product.html">{{ $pro_rating->sanpham_ten }}</a></h3>
                                    <div class="special_product_proce">
                                        {{--  <span class="old_price">$124.58</span>  --}}
                                        <span class="new_price">{{number_format($pro_rating->sanpham_gia_ban).' VNĐ' }}</span>
                                    </div>
                                </div>
                            </div>
                            @php
                                $count++;
                            @endphp
                        @endif
                    @endforeach
                </div>
                <!--special product end-->
            </div>
            <div class="col-lg-9 col-md-12">
                <!--shop toolbar start-->
                <div class="col-md-12 mb-35">
                    <form class="form-inline" action="{{URL::to('/get-filter-search-customer')}}" method="POST">
                        @csrf
                        @php
                            $session_search_filter_customer=Session::get('search_filter_customer');
                        @endphp
                        <div class="form-group col-lg-3 mt-3">
                            <select name="search_customer_brand" class="custom-select" id="status-select">
                                <option value="" selected="">---Brand---</option>
                                @foreach ($product_brand as $key => $brand)
                                    @if($session_search_filter_customer)
                                        @foreach ($session_search_filter_customer as $key=>$brd)
                                            @if($brand->id==$brd['search_customer_brand'])
                                                <option selected value="{{ $brand->id }}">{{ $brand->thuonghieu_ten }}</option>
                                            @else
                                            <option value="{{ $brand->id }}">{{ $brand->thuonghieu_ten }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                    <option value="{{ $brand->id }}">{{ $brand->thuonghieu_ten }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 mt-3">
                            <select name="search_customer_product_type" class="custom-select" id="status-select">
                                <option value="" selected="">---Catygory---</option>
                                @foreach ($product_type as $key => $pro_type)
                                    @if($session_search_filter_customer)
                                        @foreach ($session_search_filter_customer as $key=>$type_pro)
                                            @if($pro_type->id==$type_pro['search_customer_product_type'])
                                                <option selected value="{{ $pro_type->id }}">{{ $pro_type->loaisanpham_ten}}</option>
                                            @else
                                                <option value="{{ $pro_type->id }}">{{ $pro_type->loaisanpham_ten}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                    <option value="{{ $pro_type->id }}">{{ $pro_type->loaisanpham_ten}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 mt-3">
                            <select name="search_customer_collection" class="custom-select" id="status-select">
                                <option value="" selected="">---Collection---</option>
                                @foreach ($product_collection as $key => $collection)
                                    @if($session_search_filter_customer)
                                        @foreach ($session_search_filter_customer as $key=>$collec)
                                            @if($collection->id==$collec['search_customer_collection'])
                                                <option selected value="{{ $collection->id }}">{{ $collection->dongsanpham_ten }}</option>
                                            @else
                                                <option value="{{ $collection->id }}">{{ $collection->dongsanpham_ten }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                    <option value="{{ $collection->id }}">{{ $collection->dongsanpham_ten }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 mt-3">
                            <select name="search_customer_price" class="custom-select" id="status-select">
                                <option value="" selected="">---Price---</option>
                                @if($session_search_filter_customer)
                                    @foreach ($session_search_filter_customer as $key=>$price)
                                        @if($price['search_customer_price']==1)
                                            <option selected value="1">< 500.000 VNĐ</option>
                                            <option value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                            <option value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                            <option value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                            <option value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                            <option value="6">Other Price</option>
                                        @elseif($price['search_customer_price']==2)
                                            <option value="1">< 500.000 VNĐ</option>
                                            <option selected value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                            <option value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                            <option value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                            <option value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                            <option value="6">Other Price</option>
                                        @elseif($price['search_customer_price']==3)
                                            <option value="1">< 500.000 VNĐ</option>
                                            <option value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                            <option selected value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                            <option value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                            <option value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                            <option value="6">Other Price</option>
                                        @elseif($price['search_customer_price']==4)
                                            <option value="1">< 500.000 VNĐ</option>
                                            <option value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                            <option value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                            <option selected value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                            <option value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                            <option value="6">Other Price</option>
                                        @elseif($price['search_customer_price']==5)
                                            <option value="1">< 500.000 VNĐ</option>
                                            <option value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                            <option value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                            <option value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                            <option selected value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                            <option value="6">Other Price</option>
                                        @elseif($price['search_customer_price']==6)
                                            <option value="1">< 500.000 VNĐ</option>
                                            <option value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                            <option value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                            <option value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                            <option value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                            <option selected value="6">Other Price</option>
                                        @else
                                            <option value="1">< 500.000 VNĐ</option>
                                            <option value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                            <option value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                            <option value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                            <option value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                            <option value="6">Other Price</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="1">< 500.000 VNĐ</option>
                                    <option value="2">500.000 VNĐ - 1.000.000 VNĐ</option>
                                    <option value="3">1.000.000 VNĐ - 2.000.000 VNĐ</option>
                                    <option value="4">2.000.000 VNĐ - 5.000.000 VNĐ</option>
                                    <option value="5">5.000.000 VNĐ - 10.000.000 VNĐ</option>
                                    <option value="6">Other Price</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-3 mt-3">
                            <select name="search_customer_gender" class="custom-select" id="status-select">
                                <option value="" selected="">---Gender---</option>
                                @if($session_search_filter_customer)
                                    @foreach ($session_search_filter_customer as $key=>$gender)
                                        @if($gender['search_customer_gender']==1)
                                            <option selected value="1">Male</option>
                                            <option value="2">Famale</option>
                                            <option value="3">Unisex</option>
                                            <option value="4">Kids</option>
                                        @elseif($gender['search_customer_gender']==2)
                                            <option value="1">Male</option>
                                            <option selected value="2">Famale</option>
                                            <option value="3">Unisex</option>
                                            <option value="4">Kids</option>
                                        @elseif($gender['search_customer_gender']==3)
                                            <option value="1">Male</option>
                                            <option value="2">Famale</option>
                                            <option selected value="3">Unisex</option>
                                            <option value="4">Kids</option>
                                        @elseif($gender['search_customer_gender']==4)
                                            <option value="1">Male</option>
                                            <option value="2">Famale</option>
                                            <option value="3">Unisex</option>
                                            <option selected value="4">Kids</option>
                                        @else
                                            <option value="1">Male</option>
                                            <option value="2">Famale</option>
                                            <option value="3">Unisex</option>
                                            <option value="4">Kids</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="1">Male</option>
                                    <option value="2">Famale</option>
                                    <option value="3">Unisex</option>
                                    <option value="4">Kids</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-lg-3 mt-3">
                            <select name="search_customer_size" class="custom-select" id="status-select">
                                <option value="" selected="">---Size---</option>
                                @foreach ($all_size as $key => $size)
                                    @if($session_search_filter_customer)
                                        @foreach ($session_search_filter_customer as $key=>$si)
                                            @if($size->id==$si['search_customer_size'])
                                                <option selected value="{{ $size->id }}">{{ $size->size}}</option>
                                            @else
                                                <option value="{{ $size->id }}">{{ $size->size}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                    <option value="{{ $size->id }}">{{ $size->size}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <button type="submit" class="btn btn-danger waves-effect waves-light mt-3 mr-3"><i class="mdi mdi-search-web mr-1"></i>Search</button>
                            <a href="{{URL::to('/shop-now')}}" class="btn btn-success waves-effect waves-light mt-3"><i class="mdi mdi-search-web mr-1"></i>All</a>
                        </div>
                    </form>
                </div>
                <!--shop toolbar end-->
                <div class="row col-md-12">
                    <!--shop tab product-->
                    <div class="shop_tab_product">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="large" role="tabpanel">
                                <div class="row">
                                    @foreach ($all_product as $key => $product)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="single_product">
                                            <div class="product_thumb">
                                               <a href="{{URL::to('/product-detail/'.$product->id)}}"><img id="wishlist_product_image{{ $product->id }}" src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                                               <div class="img_icone">
                                                   <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                               </div>
                                            </div>
                                            <div class="product_content content_price mb-15">
                                                <span class="product_price">
                                                    {{number_format($product->sanpham_gia_ban,0,',','.').' VNĐ' }}
                                                </span>

                                                <h3 class="product_title"><a href="{{URL::to('/product-detail/'.$product->id)}}">{{ $product->sanpham_ten }}</a></h3>
                                            </div>
                                            <div class="product_info">
                                                <ul>
                                                    <input type="hidden" value="{{ $product->sanpham_ten }}" id="wishlist_product_name{{ $product->id }}">
                                                    <input type="hidden" value="{{number_format($product->sanpham_gia_ban,0,',','.').' VNĐ' }}" id="wishlist_product_price{{ $product->id }}">
                                                    <li><a type="button" onclick="add_wistlist(this.id);" id="{{ $product->id }}" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                                    <li><a id="wishlist_product_url{{ $product->id }}" href="{{URL::to('/product-detail/'.$product->id)}}"  title="Quick view">View Detail</a></li>
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
</div>
<!--pos home section end-->
@endsection
