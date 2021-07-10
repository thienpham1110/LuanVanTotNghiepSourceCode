@extends('client.index_layout')
@section('content')
<div class="pos_home_section">
    <div class="row">
       <!--banner slider start-->
       @include('client.blocks.slideshow')
         <!--banner slider end -->
    </div>
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
                @foreach ($all_product as $key => $product)
                <div class="col-lg-3">
                    <div class="single_product">
                        <div class="product_thumb">
                           <a href="single-product.html"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                           <div class="img_icone">
                               <img src="{{asset('public/frontend/img/cart/span-new.png')}}" alt="">
                           </div>
                        </div>
                        <div class="product_content">
                            <span class="product_price">
                                {{number_format( $product->sanpham_gia_ban,0,',','.'  ).' VNĐ' }}
                            </span>
                            <h3 class="product_title"><a href="single-product.html">{{ $product->sanpham_ten }}</a></h3>
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
    <!--featured product area start-->
    <div class="new_product_area product_two">
        <div class="row">
            <div class="col-12">
                <div class="block_title">
                <h3>featured Products</h3>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="single_p_active owl-carousel">
                @foreach ($all_product_featured as $key => $product)
                <div class="col-lg-3">
                    <div class="single_product">
                        <div class="product_thumb">
                           <a href="single-product.html"><img src="{{asset('public/uploads/admin/product/'.$product->sanpham_anh)}}" alt=""></a>
                           <div class="hot_img">
                               <img src="{{asset('public/frontend/img/cart/span-hot.png')}}" alt="">
                           </div>
                        </div>
                        <div class="product_content">
                            <span class="product_price">
                                {{number_format( $product->sanpham_gia_ban,0,',','.'  ).' VNĐ' }}
                            </span>
                            <h3 class="product_title"><a href="single-product.html">{{ $product->sanpham_ten }}</a></h3>
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
    <!--featured product area start-->
    {{--  <!--blog area start-->
    <div class="blog_area blog_two">
        <div class="row">
            <div class="col-lg-12">
                <div class="single_blog">
                    <div class="blog_thumb">
                        <a href="blog-details.html"><img src="{{asset('public/frontend/img/blog/blog1.jpg')}}" alt=""></a>
                    </div>
                    <div class="blog_content">
                        <div class="blog_post">
                            <ul>
                                <li>
                                    cua hang
                                </li>
                            </ul>
                        </div>
                        <h3><a href="blog-details.html">When an unknown took a galley of type.</a></h3>
                        <p>Distinctively simplify dynamic resources whereas prospective core competencies. Objectively pursue multidisciplinary human capital for interoperable.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--blog area end-->  --}}
    <!--brand logo strat-->
    <div class="brand_logo brand_two">
        <div class="block_title">
            <h3>Brands</h3>
        </div>
        <div class="row">
            <div class="brand_active owl-carousel">
                @foreach ($product_brand as $key => $brand)
                <div class="col-lg-2">
                    <div class="single_brand">
                        <a href="{{URL::to ('/product-brand/'.$brand->id)}}"><img src="{{asset('public/uploads/admin/brand/'.$brand->thuonghieu_anh) }}" alt=""></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--brand logo end-->
</div>
@endsection
