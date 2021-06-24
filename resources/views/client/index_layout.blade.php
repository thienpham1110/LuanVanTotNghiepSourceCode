<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>RGUWB Shop</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/img/favicon.png')}}">

		<!-- all css here -->
        <link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/plugin.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/bundle.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('public/frontend/css/responsive.css')}}">
        <script src="{{asset('public/frontend/js/vendor/modernizr-2.8.3.min.js')}}"></script>
        <link href="{{URL::asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">
    </head>
    <body>
            <!-- Add your site or application content here -->

            <!--pos page start-->
            <div class="pos_page">
                <div class="container">
                   <!--pos page inner-->
                    <div class="pos_page_inner">
                       <!--header area -->
                        <div class="header_area">
                               <!--header top-->

                               @include('client.blocks.header')

                                <!--header middel end-->
                           <!-- menu -->

                           @include('client.blocks.menu')

                           <!-- end menu -->
                        </div>
                        <!--header end -->
                        <!-- content -->
                        <!--pos home section-->

                        @yield('content')

                        <!--pos home section end-->
                        <!-- end content -->
                    </div>
                    <!--pos page inner end-->
                </div>
            </div>
            <!--pos page end-->

            <!--footer area start-->
            @include('client.blocks.footer')
            <!--footer area end-->
		<!-- all js here -->
        <script src="{{asset('public/frontend/js/vendor/jquery-1.12.0.min.js')}}"></script>
        <script src="{{asset('public/frontend/js/popper.js')}}"></script>
        <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('public/frontend/js/bootstrap.js')}}"></script>
        <script src="{{asset('public/frontend/js/ajax-mail.js')}}"></script>
        <script src="{{asset('public/frontend/js/plugins.js')}}"></script>
        <script src="{{asset('public/frontend/js/main.js')}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="{{URL::asset('public/frontend/js/jquery3.js')}}"></script>
        <script src="{{URL::asset('public/frontend/js/sweetalert.min.js')}}"></script>
        <script src="{{URL::asset('public/frontend/js/jquery.js')}}"></script>
    <script src="{{URL::asset('public/frontend/js/jquery2.js')}}"></script>

    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $('.add-to-cart').click(function(){
            var id = $(this).data('id_product');
            var product_id =$('.product_id_' + id).val();
            var product_name =$('.product_name_' + id).val();
            var product_size_id =$('.product_size_id_' + id).val();
            var product_img =$('.product_img_' + id).val();
            var product_quantity =$('.product_quantity_' + id).val();
            var product_price =$('.product_price_' + id).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/add-cart')}}',
                method: 'POST',
                data:{product_id:product_id,product_size_id:product_size_id,product_price:product_price,
                    product_name:product_name ,product_img:product_img,product_quantity:product_quantity,_token:_token},
                success:function(data){
                    {{--  alert(data);  --}}
                    swal({
                        title: "Đã thêm sản phẩm vào giỏ hàng",
                        showCancelButton: true,
                        cancelButtonText: "Xem tiếp",
                        confirmButtonClass: "btn btn-info",
                        cancelButtonClass: "btn btn-success",
                        confirmButtonText: "Đến giỏ hàng",
                        closeOnConfirm: false
                    },
                    function() {
                        window.location.href = "{{url('/cart')}}";
                    });
               }
            });
         });
    });
</script>
<script type="text/javascript">
    $(document).on('mouseup','.delete-cart',function(){
        function delete_row_order_admin(){
            $('.delete-cart').click(function(){
                var id = $(this).data('id_product');
                var product_session_id =$('.product_session_id_' + id).val();
                var _token = $('input[name="_token"]').val();
                 $.ajax({
                     url: '{{url('/delete-cart')}}',
                     method: 'GET',
                     data:{product_session_id:product_session_id,_token:_token},
                     success:function(data){
                        window.location.href = "{{url('/cart')}}";
                    }
                 });
             });
        }
        delete_row_order_admin();
    });
</script>
