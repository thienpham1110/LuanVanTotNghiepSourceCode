<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">RGUWB</li>
                <li>
                    <a href="{{URL::to('/dashboard')}}" class="waves-effect">
                        <i class="remixicon-dashboard-line"></i>
                        <span> Dashboards </span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="remixicon-stack-line"></i>
                        <span>Manage Product </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{URL::to('/product')}}">Product</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/product-discount-show-product')}}">Discount Products</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/brand')}}">Brand</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/product-type')}}">Product Type</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/collection')}}">Collection</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/coupon-code')}}">Coupon Code</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/product-discount')}}">Discount</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="remixicon-stack-line"></i>
                        <span>Product Import</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{URL::to('/product-import')}}">Product Import</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/supplier')}}">Supplier</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/size')}}">Size</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/product-import-add-multiple')}}">Product Import Mutiple</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="remixicon-layout-line"></i>
                        {{-- <span class="badge badge-pink float-right">New</span> --}}
                        <span>Manage Order</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="index_order.php">Order</a>
                        </li>
                        <li>
                            <a href="index_delivery_order.php">Delivery Order</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/transport-fee')}}">Transport fee</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="remixicon-folder-add-line"></i>
                        <span>Manage News</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li>
                            <a href="{{URL::to('/about-store')}}">About Store</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/product-news')}}">News</a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" aria-expanded="false">Website
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-third-level nav" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/slideshow')}}">Slideshow</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/headershow')}}">Header</a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="remixicon-stack-line"></i>
                        <span>Manage Customer</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="index_customer.php">Customer</a>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
