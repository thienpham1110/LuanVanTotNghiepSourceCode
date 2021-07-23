
<div class="header_bottom">
    <div class="row">
            <div class="col-12">
                <div class="main_menu_inner">
                    <div class="main_menu d-none d-lg-block">
                        <nav>
                            <ul>
                                <li class="active"><a href="{{URL::to ('/')}}">Home</a>
                                </li>
                                <li>
                                    <a href="{{URL::to ('/shop-now')}}">shop now</a>
                                </li>
                                <li><a href="#">pages</a>
                                    <div class="mega_menu">
                                        <div class="mega_top fix">
                                            <div class="mega_items">
                                                <h3><a href="#">Brand</a></h3>
                                                <ul>
                                                    @foreach ($product_brand as $key => $brand)
                                                        <li><a href="{{URL::to ('/product-brand/'.$brand->id)}}">{{ $brand->thuonghieu_ten }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mega_items">
                                                <h3><a href="#">Category</a></h3>
                                                <ul>
                                                    @foreach ($product_type as $key => $pro_type)
                                                        <li><a href="{{URL::to ('/product-category/'.$pro_type->id)}}">{{ $pro_type->loaisanpham_ten }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            {{-- <div class="mega_items">
                                                <h3><a href="#">Collection</a></h3>
                                                <ul>
                                                    @foreach ($product_collection as $key => $collection)
                                                        <li><a href="{{URL::to ('/product-collection/'.$collection->id)}}">{{ $collection->dongsanpham_ten }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div> --}}
                                        </div>
                                        <div class="mega_bottom fix">
                                            <div class="mega_thumb">
                                                <a href="#"><img src="{{URL::asset('public/frontend/img/banner/banner1.png')}}" alt=""></a>
                                            </div>
                                            <div class="mega_thumb">
                                                <a href="#"><img src="{{URL::asset('public/frontend/img/banner/banner2.png')}}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                 {{--  <li><a href="#">Collection</a>
                                    <div class="mega_menu">
                                        <div class="mega_top fix">
                                            <div class="mega_items">
                                                <ul>
                                                    @foreach ($product_collection as $key => $collection)
                                                        <li><a href="{{URL::to ('/product-collection/'.$collection->id)}}">{{ $collection->dongsanpham_ten }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>  --}}
                                <li>
                                    <a href="{{URL::to ('/promotion')}}">Promotion</a>
                                </li>
                                <li>
                                    <a href="{{URL::to ('/about-us')}}">About Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="mobile-menu d-lg-none">
                        <nav>
                            <ul>
                                <li>
                                    <a href="{{URL::to ('/')}}"> <h5> Home</h5></a>
                                </li>
                                <li>
                                    <a href="{{URL::to ('/shop-now')}}"><h5>shop now</h5></a>
                                </li>
                                <li><a href=""><h5>PAGES </h5></a></li>
                                    <div>
                                        <li>
                                            <a href="#">Brand</a>
                                            <ul>
                                                @foreach ($product_brand as $key => $brand)
                                                    <li><a href="{{URL::to ('/product-brand/'.$brand->id)}}">{{ $brand->thuonghieu_ten }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Category</a>
                                            <ul>
                                                @foreach ($product_type as $key => $pro_type)
                                                    <li><a href="{{URL::to ('/product-category/'.$pro_type->id)}}">{{ $pro_type->loaisanpham_ten }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Collection</a>
                                            <ul>
                                                @foreach ($product_collection as $key => $collection)
                                                    <li><a href="{{URL::to ('/product-collection/'.$collection->id)}}">{{ $collection->dongsanpham_ten }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </div>
                                <li>
                                    <a href="{{URL::to ('/promotion')}}"><h5>promotion</h5></a>
                                </li>
                                <li><a href="contact.html"> <h5>contact us</h5></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
</div>
