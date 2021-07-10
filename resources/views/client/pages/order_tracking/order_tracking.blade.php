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
                    <li>Order Tracking</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->
<!-- customer login start -->
<div class="customer_login">
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
<div class="row">
    <!--blog area start-->
    <div class="main_blog_area">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-6">
                <div class="blog_details_left">
                    <div class="blog_gallery">
                        <form action="{{URL::to('/get-order-tracking')}}" method="POST">
                            @csrf
                            <div class="blog_thumb blog__hover">
                                <input type="text" required="" name="order_tracking">
                            </div>
                            <div class="blog_fullwidth_desc">
                                <p>Enter your order number or email to check your order</p>
                                 <button type="submit">search order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div
        </div>
    </div>
    <!--blog area end-->
        </div>
</div>
<!-- customer login end -->
@endsection
