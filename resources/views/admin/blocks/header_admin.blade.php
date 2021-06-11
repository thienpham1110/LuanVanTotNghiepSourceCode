<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{asset('public/backend/images/users/a.jpg')}}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php
                    $name=Session::get('admin_name');
                    if($name){
                        echo $name;
                    }
                    ?> <i class="mdi mdi-chevron-down"></i>
                    </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>
                <!-- item-->
                <a href="index_profile.php" class="dropdown-item notify-item">
                    <i class="remixicon-account-circle-line"></i>
                    <span>My Account</span>
                </a>
                <!-- item-->
                <a href="index_change_password.php" class="dropdown-item notify-item">
                    <i class="remixicon-lock-line"></i>
                    <span>Change Password</span>
                </a>
                <div class="dropdown-divider"></div>
                <!-- item-->
                <a href="{{ URL::to('/logout') }}" class="dropdown-item notify-item">
                    <i class="remixicon-logout-box-line"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>
    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ URL::to('/dashboard') }}" class="logo text-center">
            <span class="logo-lg">
                    <img src="{{asset('public/backend/images/logo-light.png')}}" alt="" height="20">
                    <!-- <span class="logo-lg-text-light">Xeria</span> -->
            </span>
            <span class="logo-sm">
                    <!-- <span class="logo-sm-text-dark">X</span> -->
            <img src="{{asset('public/backend/images\logo-sm.png')}}" alt="" height="24">
            </span>
        </a>
    </div>
    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
        </li>
    </ul>
</div>