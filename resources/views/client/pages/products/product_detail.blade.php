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
                                <a href="#"><img id="wishlist_viewed_product_image{{ $product->id }}" src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                                <div class="img_icone">
                                   <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                               </div>
                                <div class="view_img">
                                    <a class="large_view" href="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}"><i class="fa fa-search-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        @foreach ($all_product_image as $key =>$pro_img)
                            <div class="tab-pane fade" id="p_tab2" role="tabpanel">
                                <div class="modal_img">
                                    <a href="#"><img src="{{asset('public/uploads/admin/productimages/'.$pro_img->anhsanpham_ten)}}" alt=""></a>
                                    <div class="img_icone">
                                    <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                                </div>
                                    <div class="view_img">
                                        <a class="large_view" href="{{asset('public/uploads/admin/productimages/'.$pro_img->anhsanpham_ten)}}"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="product_tab_button">
                        <ul class="nav" role="tablist">
                            @php
                                $count_img=1;
                            @endphp
                            @foreach ($all_product_image as $key =>$pro_img)
                                @if ($count_img<=3)
                                    <li>
                                        <a class="active" data-toggle="tab" href="#p_tab2" role="tab" aria-controls="p_tab1" aria-selected="false"><img src="{{asset('public/uploads/admin/productimages/'.$pro_img->anhsanpham_ten)}}" alt=""></a>
                                    </li>
                                    @php
                                        $count_img++;
                                    @endphp
                                @else
                                @break
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    {{--  <div class="product_tab_button ">
                        <ul id="imageGallery">
                            <li data-thumb="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" data-src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}">
                              <img class="product-img" src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" />
                            </li>
                            @foreach ($all_product_image as $key =>$pro_img)
                                <li data-thumb="{{asset('public/uploads/admin/productimages/'.$pro_img->anhsanpham_ten)}}" data-src="{{asset('public/uploads/admin/productimages/'.$pro_img->anhsanpham_ten)}}">
                                    <img class="product-img"  src="{{asset('public/uploads/admin/productimages/'.$pro_img->anhsanpham_ten)}}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>  --}}
                </div>
            </div>

            <div class="col-lg-8 col-md-6">
                <div class="product_d_right">
                    <h1>{{ $product->sanpham_ten }}</h1>

                     <div class="product_ratting mb-10">
                        <ul>
                            @php
                            $sum=0;
                            $count_rate=0;
                            @endphp
                            @foreach($comment_customer as $k=>$comment_cus)
                                @php
                                    $sum+=$comment_cus->binhluan_diem_danh_gia;
                                    $count_rate++;
                                @endphp
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
                            <li><a href="#"> Number of reviews : <span>{{ $count_rate }}</span></a></li>
                        </ul>
                    </div>
                    <div class="product_desc">
                        <p>{{ $product->sanpham_mo_ta }}</p>
                    </div>

                    <div class="content_price mb-15">
                        <span>
                            {{number_format($product->sanpham_gia_ban ,0,',','.').' VNĐ' }}
                        </span>
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
                                 <input type="hidden" value=" {{number_format($product->sanpham_gia_ban ,0,',','.').' VNĐ' }}" id="wishlist_viewed_product_price{{ $product->id }}">
                                 <input id="wishlist_viewed_product_url{{ $product->id }}"  value="{{URL::to('/product-detail/'.$product->id)}}"  type="hidden">
                                <input name="product_id" value="{{ $product->id }}" class="product_id_{{ $product->id }}" type="hidden">
                                <input name="product_img" value="{{ $product->sanpham_anh }}" class="product_img_{{ $product->id }}" type="hidden">
                                <input name="product_name" id="wishlist_viewed_product_name{{ $product->id }}" value="{{ $product->sanpham_ten }}" class="product_name_{{ $product->id }}" type="hidden">
                                <input name="product_price" class="product_price_{{ $product->id }}" value="{{number_format($product->sanpham_gia_ban ,0,',','') }}" type="hidden">
                                <button type="button" data-id_product="{{ $product->id}}" class="add-to-cart"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                <a type="button" onclick="add_wistlist(this.id);" id="{{ $product->id }}" title="add to wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a>
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
                            <a class="active"  data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Data sheet</a>
                       </li>
                        <li>
                            <a data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                        </li>
                        <li>
                           <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade " id="info" role="tabpanel">
                        <div class="product_info_content">
                            <p> {{ $product->sanpham_mo_ta }}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="sheet" role="tabpanel">
                        <div class="product_d_table">
                           <form action="#">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="first_child">NHÃN HIỆU</td>
                                            <td>{{ $product->Brand->thuonghieu_ten }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">TÊN</td>
                                            <td>{{ $product->sanpham_ten }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">MÃ SẢN PHẨM</td>
                                            <td>{{ $product->sanpham_ma_san_pham }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">LOẠI SẢN PHẨM</td>
                                            <td>{{ $product->ProductType->loaisanpham_ten }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">DÒNG SẢN PHẨM</td>
                                            <td>{{ $product->Collection->dongsanpham_ten }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">NƠI SẢN XUẤT</td>
                                            <td>{{ $product->sanpham_noi_san_xuat}}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">CHẾ ĐỘ BẢO HÀNH</td>
                                            <td>{{ $product->sanpham_bao_hanh}}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">PHỤ KIỆN KÈM THEO</td>
                                            <td>{{ $product->sanpham_phu_kien}}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">MÀU SẮC SẢN PHẨM</td>
                                            <td>{{ $product->sanpham_mau_sac}}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">GIỚI TÍNH</td>
                                            <td>
                                                @if ($product->sanpham_nguoi_su_dung==0)
                                                Nam
                                                @elseif($product->sanpham_nguoi_su_dung==1)
                                                Nữ
                                                @elseif($product->sanpham_nguoi_su_dung==2)
                                                Unisex
                                                @else
                                                Trẻ em
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">CHẤT LIỆU</td>
                                            <td>{{ $product->sanpham_chat_lieu}}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_child">TÍNH NĂNG</td>
                                            <td>{{ $product->sanpham_tinh_nang}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="product_info_content">
                            <p> {{ $product->sanpham_mo_ta }}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="product_info_content">
                            <p> {{ $product->sanpham_mo_ta }}</p>
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {!! session()->get('message') !!}
                                {!! session()->forget('message') !!}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {!! session()->get('error') !!}
                                {!! session()->forget('error') !!}
                            </div>
                        @endif
                        <form action="{{URL::to('/post-comment-customer')}}" method="POST">
                            @csrf
                            <div class="product_review_form rmp">
                                <h2>Add your review</h2>
                                <p>Required fields are marked </p>
                                <div class="product_ratting mb-10 rps">
                                    <i class="fa fa-star" data-index="0" style="display:none" ></i>
                                    <i class="fa fa-star" data-index="1"></i>
                                    <i class="fa fa-star" data-index="2"></i>
                                    <i class="fa fa-star" data-index="3"></i>
                                    <i class="fa fa-star" data-index="4"></i>
                                    <i class="fa fa-star" data-index="5"></i>
                                </div>
                                <input type="hidden" value="" required="" class="starRateV" name="starRateV">
                                <input type="hidden" value="{{ $product->id }}" name="product_id" class="product_id" >
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <label for="author">Name</label>
                                        <input id="review-name" class="review_name" name="review_name" required="" type="text">
                                    </div>
                                    <div class="col-12">
                                        <label for="review_comment">Your review </label>
                                        <textarea name="review_comment" class="review_comment" required="" id="review-comment"></textarea>
                                    </div>
                                    <div class="rate-error" align="center"></div>
                                </div>
                                <button type="submit">Submit</button>
                            </div>
                        </form>
                        <hr>
                        <form>
                            @csrf
                            <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$product->id}}">
                            <div id="comment_show">
                                @foreach ($comment_customer as $key=>$comment )
                                    <div class="product_info_inner ">
                                        <div class="product_ratting mb-10 col-md-6">
                                            <div class="col-md-2">
                                                <img width="100%" src="{{URL::asset('public/backend/images/users/batman-icon.png')}}" class="img img-responsive img-thumbnail comment-img">
                                            </div>
                                            <br>
                                            <div col-md-4>
                                                <ul>
                                                    @for($count = 1; $count <=5; $count++)
                                                        @if($count <= $comment->binhluan_diem_danh_gia)
                                                            <i class="fa fa-star ratting_review"></i>
                                                        @else
                                                            <i class="fa fa-star ratting_no_review"></i>
                                                        @endif
                                                    @endfor
                                                </ul>
                                                <strong>{{ $comment->binhluan_ten_nguoi_danh_gia }}</strong>
                                                <p>{{ $comment->binhluan_ngay_danh_gia }}</p>
                                                <p>{{ $comment->binhluan_noi_dung }}</p>
                                            </div>
                                        </div>
                                        &emsp;&emsp;
                                        @foreach ($comment_admin as $k=>$ad_comment)
                                            @if($ad_comment->binhluan_id_phan_hoi==$comment->id)
                                                <div class="col-md-6">
                                                    <div class="product_demo">
                                                        <div class="col-md-2">
                                                            <img width="70%" src="{{URL::asset('public/backend/images/users/rguwb.png')}}" class="img img-responsive img-thumbnail comment-img">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong>
                                                                @if($ad_comment->admin_id)
                                                                Admin
                                                                @else
                                                                {{ $comment->binhluan_ten_nguoi_danh_gia }}
                                                                @endif
                                                            </strong>
                                                            <p>{{ $ad_comment->binhluan_noi_dung }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </form>
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
            <h3>other products category:</h3>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="single_p_active owl-carousel">
            @foreach ($all_product as $key => $product )
                <div class="col-lg-3">
                    <div class="single_product">
                        <div class="product_thumb">
                        <a href="{{URL::to('/product-detail/'.$product->id)}}"><img id="wishlist_viewed_product_image{{ $product->id }}" src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                        <div class="img_icone">
                            <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                        </div>
                        </div>
                        <div class="product_content">
                            <span class="product_price">
                                {{number_format( $product->sanpham_gia_ban,0,',','.').' VNĐ' }}
                            </span>
                            <h3 class="product_title"><a href="{{URL::to('/product-detail/'.$product->id)}}">{{ $product->sanpham_ten }}</a></h3>
                        </div>
                        <div class="product_info">
                            <ul>
                                <input type="hidden" value="{{ $product->sanpham_ten }}" id="wishlist_viewed_product_name{{ $product->id }}">
                                <input type="hidden" value="{{number_format($product->sanpham_gia_ban,0,',','.').' VNĐ' }}" id="wishlist_viewed_product_price{{ $product->id }}">
                                <li><a type="button" onclick="add_wistlist(this.id);" id="{{ $product->id }}" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                <li><a class="views-product-detail" data-views_product_id="{{$product->id}}" id="wishlist_viewed_product_url{{ $product->id }}"href="{{URL::to('/product-detail/'.$product->id)}}"title="Quick view">View Detail</a></li>
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
                        <a href="{{URL::to('/product-detail/'.$product->id)}}"><img id="wishlist_viewed_product_image{{ $product->id }}" src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                        <div class="img_icone">
                            <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                        </div>
                        </div>
                        <div class="product_content">
                            <span class="product_price">
                                {{number_format( $product->sanpham_gia_ban,0,',','.').' VNĐ' }}
                            </span>
                            <h3 class="product_title"><a href="{{URL::to('/product-detail/'.$product->id)}}">{{ $product->sanpham_ten }}</a></h3>
                        </div>
                        <div class="product_info">
                            <ul>
                                <input type="hidden" value="{{ $product->sanpham_ten }}" id="wishlist_viewed_product_name{{ $product->id }}">
                                <input type="hidden" value="{{number_format($product->sanpham_gia_ban,0,',','.').' VNĐ' }}" id="wishlist_viewed_product_price{{ $product->id }}">
                                <li><a type="button" onclick="add_wistlist(this.id);" id="{{ $product->id }}" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                <li><a class="views-product-detail" data-views_product_id="{{$product->id}}" id="wishlist_viewed_product_url{{ $product->id }}"href="{{URL::to('/product-detail/'.$product->id)}}"title="Quick view">View Detail</a></li>
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
            @foreach ($all_product_wishlist as $key => $product )
                <div class="col-lg-3">
                    <div class="single_product">
                        <div class="product_thumb">
                        <a href="{{URL::to('/product-detail/'.$product->id)}}"><img id="wishlist_viewed_product_image{{ $product->id }}" src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                        <div class="img_icone">
                            <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                        </div>
                        </div>
                        <div class="product_content">
                            <span class="product_price">
                                {{number_format( $product->sanpham_gia_ban,0,',','.').' VNĐ' }}
                            </span>
                            <h3 class="product_title"><a href="{{URL::to('/product-detail/'.$product->id)}}">{{ $product->sanpham_ten }}</a></h3>
                        </div>
                        <div class="product_info">
                            <ul>
                                <input type="hidden" value="{{ $product->sanpham_ten }}" id="wishlist_viewed_product_name{{ $product->id }}">
                                <input type="hidden" value="{{number_format($product->sanpham_gia_ban,0,',','.').' VNĐ' }}" id="wishlist_viewed_product_price{{ $product->id }}">
                                <li><a type="button" onclick="add_wistlist(this.id);" id="{{ $product->id }}" title=" Add to Wishlist ">Add to Wishlist</a></li>
                                <li><a class="views-product-detail" data-views_product_id="{{$product->id}}" id="wishlist_viewed_product_url{{ $product->id }}"href="{{URL::to('/product-detail/'.$product->id)}}"title="Quick view">View Detail</a></li>
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
