
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
                                            <div class="mega_items">
                                                <h3><a href="#">Collection</a></h3>
                                                <ul>
                                                    @foreach ($product_collection as $key => $collection)
                                                        <li><a href="{{URL::to ('/product-collection/'.$collection->id)}}">{{ $collection->dongsanpham_ten }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mega_bottom fix">
                                            <div class="mega_thumb">
                                                <a href="#"><img src="{{URL::asset('public/frontend/img/banner/banner1.jpg')}}" alt=""></a>
                                            </div>
                                            <div class="mega_thumb">
                                                <a href="#"><img src="{{URL::asset('public/frontend/img/banner/banner2.jpg')}}" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                {{--  <li><a href="#">Collection</a>
                                    <div class="mega_menu">
                                        <div class="mega_top fix">
                                            @foreach ($product_collection as $key => $collection)
                                                <div class="mega_items">
                                                    <ul>
                                                        <li><a href="{{URL::to ('/product-collection/'.$collection->id)}}">{{ $collection->dongsanpham_ten }}</a></li>
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mega_bottom fix">
                                            <div class="mega_thumb">
                                                <a href="#"><img src="{{URL::asset('public/frontend/img/banner/banner1.jpg')}}" alt=""></a>
                                            </div>
                                            <div class="mega_thumb">
                                                <a href="#"><img src="{{URL::asset('public/frontend/img/banner/banner2.jpg')}}" alt=""></a>
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
                                <li><a href=""><h5>WOMEN </h5></a></li>
                                    <div>
                                        <li>
                                            <h3><a href="#">Accessories</a></h3>
                                            <ul>
                                                <li><a href="#">Cocktai</a></li>
                                                <li><a href="#">day</a></li>
                                                <li><a href="#">Evening</a></li>
                                                <li><a href="#">Sundresses</a></li>
                                                <li><a href="#">Belts</a></li>
                                                <li><a href="#">Sweets</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h3><a href="#">HandBags</a></h3>
                                            <ul>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Hats and Gloves</a></li>
                                                <li><a href="#">Lifestyle</a></li>
                                                <li><a href="#">Bras</a></li>
                                                <li><a href="#">Scarves</a></li>
                                                <li><a href="#">Small Leathers</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h3><a href="#">Tops</a></h3>
                                            <ul>
                                                <li><a href="#">Evening</a></li>
                                                <li><a href="#">Long Sleeved</a></li>
                                                <li><a href="#">Shrot Sleeved</a></li>
                                                <li><a href="#">Tanks and Camis</a></li>
                                                <li><a href="#">Sleeveless</a></li>
                                                <li><a href="#">Sleeveless</a></li>
                                            </ul>
                                        </li>
                                    </div>
                                <li><a href=""><h5>MEN </h5></a></li>
                                    <div>
                                        <li>
                                            <h3><a href="#">Rings</a></h3>
                                            <ul>
                                                <li><a href="#">Platinum Rings</a></li>
                                                <li><a href="#">Gold Ring</a></li>
                                                <li><a href="#">Silver Ring</a></li>
                                                <li><a href="#">Tungsten Ring</a></li>
                                                <li><a href="#">Sweets</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h3><a href="#">Bands</a></h3>
                                            <ul>
                                                <li><a href="#">Platinum Bands</a></li>
                                                <li><a href="#">Gold Bands</a></li>
                                                <li><a href="#">Silver Bands</a></li>
                                                <li><a href="#">Silver Bands</a></li>
                                                <li><a href="#">Sweets</a></li>
                                            </ul>
                                        </li>
                                    </div>
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
