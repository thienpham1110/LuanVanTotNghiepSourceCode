<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">RGUWB</li>
                <li>
                    <a href="{{URL::to('/dashboard')}}" class="waves-effect">
                        <i class="remixicon-dashboard-line"></i>
                        <span> Admin </span>
                    </a>
                </li>
                @if(Session::get('admin_id'))
                    @if(Session::get('admin_role')==1 || Session::get('admin_role')==2)
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="remixicon-stack-line"></i>
                                <span>Quản Lý Sản Phẩm </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/product')}}">Sản Phẩm</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/brand')}}">Thương Hiệu</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-type')}}">Loại Sản Phẩm</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/collection')}}">Dòng Sản Phẩm</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/coupon-code')}}">Mã Khuyến Mãi</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-discount')}}">Khuyến Mãi</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/comment')}}">Bình Luận</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="remixicon-stack-line"></i>
                                <span>Quản Lý Nhập Hàng</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/product-import')}}">Đơn Nhập Hàng</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/supplier')}}">Nhà Cung Cấp</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/size')}}">Size</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-import-add')}}">Thêm Đơn Nhập Hàng</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="remixicon-layout-line"></i>
                                {{-- <span class="badge badge-pink float-right">New</span> --}}
                                <span>Quản Lý Đơn Hàng</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/order')}}">Đơn Hàng</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/order-add')}}">Đơn Hàng Đang Tạo</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/transport-fee')}}">Phí Vận Chuyển</a>
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
                                <span>Quản Lý Giao Hàng</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/update-order-id-delivery')}}">Giao Hàng</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/transport-fee')}}">Phí Vận chuyển</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/customer')}}">Khách Hàng</a>
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
                                <span>Quản Lý Tin Tức</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level nav" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/about-store')}}">Cửa Hàng</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-news')}}">Tin Tức</a>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="false">Hiển Thị Website
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
                                <span>Quản Lý Thống Kê</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level nav" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/sales-statistics')}}">Thống Kê Đơn Hàng</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/import-statistics')}}">Thống Kê Nhập</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-view-statistics')}}">Thống Kê Lượt Xem</a>
                                </li>
                                <li>
                                    <a href="{{URL::to('/product-in-stock-statistics')}}">Thống Kê Tồn Kho</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="remixicon-stack-line"></i>
                                <span>Quản Lý User</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{URL::to('/customer')}}">Khách Hàng</a>
                                </li>
                                @if(Session::get('admin_role')==1)
                                    <li>
                                        <a href="{{URL::to('/staff')}}">Nhân Viên</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('/admin-change-password-staff')}}">Đổi Mật Khẩu Nhân Viên</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('/admin-change-email-staff')}}">Đổi Email Nhân Viên</a>
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
