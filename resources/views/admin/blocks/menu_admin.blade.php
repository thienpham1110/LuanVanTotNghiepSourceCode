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
                @if(Session::get('admin_id'))
                    @if(Session::get('admin_role')==1 || Session::get('admin_role')==2)
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
                                <li>
                                    <a href="{{URL::to('/comment')}}">Comment</a>
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
                                    <a href="{{URL::to('/product-import-add')}}">Product Import Add</a>
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
                                    <a href="{{URL::to('/order')}}">Order</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/order-add')}}">Unfinished Order</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/transport-fee')}}">Transport fee</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
                @if(Session::get('admin_id'))
                    @if(Session::get('admin_role')==1 || Session::get('admin_role')==3)
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="remixicon-layout-line"></i>
                                {{-- <span class="badge badge-pink float-right">New</span> --}}
                                <span>Manage Delivery</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/update-order-id-delivery')}}">Delivery Order</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/transport-fee')}}">Transport fee</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/customer')}}">Customer</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
                @if(Session::get('admin_id'))
                    @if(Session::get('admin_role')==1 || Session::get('admin_role')==2)
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
                                <i class="remixicon-folder-add-line"></i>
                                <span>Manage Statistics</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level nav" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/sales-statistics')}}">Sales Statistics</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/import-statistics')}}">Import Statistics</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-view-statistics')}}">Product View Statisticss</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-in-stock-statistics')}}">Product In Stock Statisticss</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="remixicon-stack-line"></i>
                                <span>Manage User</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/customer')}}">Customer</a>
                                </li>
                                @if(Session::get('admin_role')==1)
                                    <li>
                                        <a href="{{URL::to('/staff')}}">Staff</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('/admin-change-password-staff')}}">Change Password Staff</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('/admin-change-email-staff')}}">Change Email Staff</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
