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
                    <li>my account</li>
                </ul>
            </div>
        </div>
    </div>
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
<!--breadcrumbs area end-->
<!-- Start Maincontent  -->
<section class="main_content_area">
        <div class="account_dashboard">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#account-details" data-toggle="tab" class="nav-link active">Account details</a></li>
                            <li> <a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                            <li> <a href="#change-password" data-toggle="tab" class="nav-link">Change password</a></li>
                            <li><a href="{{URL::to('/logout-customer')}}" onclick="return confirm('You Sure?')" class="nav-link">logout</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content">
                        <div class="tab-pane fade show active" id="account-details">
                            <h3>Account details </h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <form action="{{URL::to('/customer-edit-save/'.$customer->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            {{--  <p>Already have an account? <a href="#">Log in instead!</a></p>  --}}
                                            <div class="input-radio">
                                            @if ($customer->khachhang_gioi_tinh==1 || $customer->khachhang_gioi_tinh!=true)
                                                <span class="custom-radio"><input type="radio" value="1" checked name="customer_gender"> Mr.</span>
                                                <span class="custom-radio"><input type="radio" value="0" name="customer_gender"> Mrs.</span>
                                            @else
                                                <span class="custom-radio"><input type="radio" value="1" name="customer_gender"> Mr.</span>
                                                <span class="custom-radio"><input type="radio" value="0" checked name="customer_gender"> Mrs.</span>
                                            @endif
                                            </div> <br>
                                            <label>First Name</label>
                                            <input type="text" value="{{ $customer->khachhang_ho}}" name="customer_first_name">
                                            <label>Last Name</label>
                                            <input type="text" value="{{ $customer->khachhang_ten }}" name="customer_last_name">
                                            <label>Email</label>
                                            <input type="text" value="{{ $customer->khachhang_email }}" readonly>
                                            <label>Phone Number</label>
                                            <input type="text" value="{{ $customer->khachhang_so_dien_thoai }}" name="customer_phone_number">
                                            <label>Address</label>
                                            <input type="text" value="{{ $customer->khachhang_dia_chi }}" name="customer_address">
                                            <label>Image</label>
                                            <span><i class="mdi mdi-cloud-upload mr-1"></i>Upload</span>
                                            <input type="file" class="upload" name="customer_img" value="{{ $customer->khachhang_anh }}"multiple="" id="files">
                                            <img width="100px" height="100px" id="image" src="{{asset('public/uploads/client/customer/'.$customer->khachhang_anh)}}"/>
                                            {{--  <span class="example">
                                              (E.g.: 05/31/1970)
                                            </span>  --}}
                                            <br>
                                            <span class="custom_checkbox">
                                                <label><br><em> </em></label>
                                            </span>
                                            <div class="save_button primary_btn default_button">
                                                <button class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="orders">
                            <h3>Orders</h3>
                            <div class="coron_table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Detail</th>
                                            <th>Cancel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($customer_all_order !=null || $customer_all_order_email!=null)
                                            @foreach ($customer_all_order as $key=>$order)
                                                <tr>
                                                    <td>{{ $order->dondathang_ma_don_dat_hang }}</td>
                                                    <td>{{ $order->dondathang_ngay_dat_hang }}</td>
                                                    <td>
                                                        <span class="success">
                                                            @if($order->dondathang_trang_thai==0)
                                                            Unconfirmed
                                                            @elseif($order->dondathang_trang_thai==1)
                                                            Confirmed
                                                            @elseif($order->dondathang_trang_thai==2)
                                                            In Transit
                                                            @elseif($order->dondathang_trang_thai==3)
                                                            Delivered
                                                            @else
                                                            Order Has Been Canceled
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>{{number_format($order->dondathang_tong_tien  ,0,',','.').' VNĐ' }}</td>
                                                    <td><a href="{{URL::to('/customer-show-order/'.$order->id)}}" class="view">Detail</a></td>
                                                    @if($order->dondathang_trang_thai==0 || $order->dondathang_trang_thai==1)
                                                        <td>
                                                            <a href="{{URL::to('/customer-cancel-order/'.$order->id)}}" class="view" onclick="return confirm('You Sure?')">Cancel</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            {{--  @if(isset($customer_all_order_email))
                                                @foreach ($customer_all_order_email as $key=>$order_email)
                                                    <tr>
                                                        <td>{{ $order_email->dondathang_ma_don_dat_hang }}</td>
                                                        <td>{{ $order_email->dondathang_ngay_dat_hang }}</td>
                                                        <td>
                                                            <span class="success">
                                                                @if($order_email->dondathang_trang_thai==0)
                                                                Unconfirmed
                                                                @elseif($order_email->dondathang_trang_thai==1)
                                                                Confirmed
                                                                @elseif($order_email->dondathang_trang_thai==2)
                                                                    In Transit
                                                                @elseif($order_email->dondathang_trang_thai==3)
                                                                Delivered
                                                                @else
                                                                Order Has Been Canceled
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>{{number_format($order_email->dondathang_tong_tien  ,0,',','.').' VNĐ' }}</td>
                                                        <td>
                                                            <a href="{{URL::to('/customer-show-order/'.$order_email->id)}}" class="view">Detail</a>
                                                        </td>
                                                        @if($order_email->dondathang_trang_thai==0 || $order_email->dondathang_trang_thai==1)
                                                            <td>
                                                                <a href="{{URL::to('/customer-cancel-order/'.$order_email->id)}}" class="view" onclick="return confirm('You Sure?')">Cancel</a>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif  --}}
                                        @else
                                        There Are No Products In The Cart
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="change-password">
                            <h3>Change Password</h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <form action="{{URL::to('/customer-change-password-save/'.$customer->khachhang_email)}}" method="POST">
                                            @csrf
                                            <label>Password</label>
                                            <input type="password" name="change_old_password">
                                            <label>New Password</label>
                                            <input type="password" name="change_new_password">
                                            <label>Confirm New Password</label>
                                            <input type="password" name="change_confirm_new_password">
                                            <br>
                                            <span class="custom_checkbox">
                                                <label><br><em> </em></label>
                                            </span>
                                            <div class="primary_btn">
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- End Maincontent  -->
<script type="text/javascript">
    document.getElementById("files").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("image").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    };
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
@endsection
