<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>RGUWB Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('public/backend/images\favicon.png')}}">
    <!-- App css -->
    <link href="{{asset('public/backend/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/css/icons.min.css')}}"rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/css/app.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/multiselect/multi-select.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/clockpicker/bootstrap-clockpicker.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/backend/libs/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <link href="{{asset('public/backend/libs/footable/footable.core.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/custombox/custombox.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/backend/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('public/backend/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css">
</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        @include('admin.blocks.header_admin')
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.blocks.menu_admin')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <script src="{{asset('public/backend/js/vendor.min.js')}}"></script>
	<script src="{{asset('public/backend/js/app.min.js')}}"></script>
    <script src="{{asset('public/backend/js/jquery.js')}}"></script>
    <script src="{{asset('public/backend/js/jquery2.js')}}"></script>
    <script src="{{asset('public/backend/js/pages/form-fileuploads.init.js')}}"></script>
	<script src="{{asset('public/backend/js/pages/form-advanced.init.js')}}"></script>
	<script src="{{asset('public/backend/js/pages/form-pickers.init.js')}}"></script>

	<script src="{{asset('public/backend/libs/jquery-quicksearch/jquery.quicksearch.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/clockpicker/bootstrap-clockpicker.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/moment/moment.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <script src="{{asset('public/backend/libs/dropzone/dropzone.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/multiselect/jquery.multi-select.js')}}"></script>
    <script src="{{asset('public/backend/libs/select2/select2.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/custombox/custombox.min.js')}}"></script>

	<script src="{{asset('public/backend/libs/footable/footable.all.min.js')}}"></script>
	<script src="{{asset('public/backend/js/pages/foo-tables.init.js')}}"></script>
    <script src="{{asset('public/backend/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('public/backend/js/pages/sweet-alerts.init.js')}}"></script>

    <script src="{{asset('public/backend/libs/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/backend/libs/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/backend/js/pages/datatables.init.js')}}"></script>
    <script src="{{asset('public/backend/libs/datatables/dataTables.bootstrap4.js')}}"></script>
	<script src="{{asset('public/backend/libs/datatables/buttons.html5.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="{{asset('public/backend/js/jquery3.js')}}"></script>
    <script src="{{asset('public/backend/js/jquery.scrollUp.min.js')}}"></script>
</body>

</html>
<script type="text/javascript">
    document.getElementById("files").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("image").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    };
</script>
<script type="text/javascript">
    $(document).ready(function(){
        function load_queue(){
            $('.add-queue').click(function(){
                var id = $(this).data('id_product');
                var product_id =$('.product_id_' + id).val();
                var product_name =$('.product_name_' + id).val();
                var _token = $('input[name="_token"]').val();
                 $.ajax({
                     url: '{{url('/product-import-add-queue')}}',
                     method: 'POST',
                     data:{product_id:product_id,product_name:product_name,_token:_token},
                     success:function(data){
                         Swal.fire({
                             title: "Add Success",
                             type: "success",
                             showConfirmButton: !1,
                            timer: 500
                             })
                         $('#show-list-product').html(data);

                     }
                 });
             });
        }load_queue();

    });
</script>
<script type="text/javascript">
    $(document).on('mouseup','.delete-row-queue',function(){
        function delete_row_queue(){
            $('.delete-row-queue').click(function(){
                var id = $(this).data('id_product');
                var product_id =$('.product_id_' + id).val();
                var product_session_id =$('.product_session_id_' + id).val();
                var product_name =$('.product_name_' + id).val();
                var _token = $('input[name="_token"]').val();

                 $.ajax({
                     url: '{{url('/product-import-delete-row-queue')}}',
                     method: 'GET',
                     data:{product_id:product_id,product_session_id:product_session_id,product_name:product_name ,_token:_token},
                     success:function(data){

                        $('#show-list-product').html(data);
                     }
                 });
             });
        }
        delete_row_queue();
    });
</script>
<script type="text/javascript">
    $('tbody').delegate('.product_price,.product_quantity','keyup',function(){
        var tr=$(this).parent().parent();
        var quantity=tr.find('.product_quantity').val();
        var price=tr.find('.product_price').val();
        var amount=(quantity*price);
        tr.find('.amount').val(amount);
        total();
    });
    function total(){
        var total=0;
        $('.amount').each(function(i,e){
            var amount=$(this).val()-0;
        total +=amount;
    });
    $('.total').html(total+".00 VNĐ");
    }
</script>
<script type="text/javascript">
    $(document).on('mouseup','.refresh-queue',function(){
        function refresh_queue_product_import(){
            $('.refresh-queue').submit(function(e){
                e.preventDefault();
                var id = $(this).data('id_product');
                {{-- let data = $(this).serializeToObject(); --}}

                {{-- var product_id =$('.product_id_' + id).val();
                var product_session_id =$('.product_session_id_' + id).val();
                var product_name =$('.product_name_' + id).val();
                var product_quantity =$('.product_quantity_' + id).val();
                var product_price =$('.product_price_' + id).val();
                var product_price_retail =$('.product_price_retail_' + id).val();
                var product_size =$('.product_size_' + id).val(); --}}

                var _token = $('input[name="_token"]').val();

                var product_id =[];
                var product_session_id =[];
                var product_name =[];
                var product_quantity =[];
                var product_price =[];
                var product_price_retail =[];
                var product_size =[];
            {{-- $($('.product_id_' + id).val()).each(function(){
                product_id.push($(this).val());
            });
            $($('.product_session_id_' + id).val()).each(function(){
                product_session_id.push($(this).val());
            });
            $($('.product_name_' + id).val()).each(function(){
                product_name.push($(this).val());
            });
            $($('.product_quantity_' + id).val()).each(function(){
                product_quantity.push($(this).val());
            });
            $($('.product_price_' + id).val()).each(function(){
                product_price.push($(this).val());
            });
            $($('.product_price_retail_' + id).val()).each(function(){
                product_price_retail.push($(this).val());
            });
            $($('.product_size_' + id).val()).each(function(){
                product_size.push($(this).val());
            }); --}}
                {{--  alert(product_name);  --}}
                 $.ajax({
                     url: '{{url('/product-import-refresh-queue')}}',
                     method: 'POST',
                     data:{product_id:product_id,product_session_id:product_session_id,product_name:product_name,
                        product_quantity:product_quantity,product_price:product_price,
                        product_price_retail:product_price_retail,product_size:product_size,_token:_token},
                     success:function(data){
                        Swal.fire({
                            title: "Add Success",
                            type: "success",
                            showConfirmButton: !1,
                           timer: 500
                            })
                        $('#show-list-product').html(data);
                     }
                 });
             });
        }
        refresh_queue_product_import();
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
{{-- <script  type="text/javascript">
    $(document).ready(function(){
        $('.refresh-queue').on('click',(function(e){
            e.preventDefault();
            const product_id =[];
            const product_session_id =[];
            const product_name =[];
            const product_quantity =[];
            const product_price =[];
            const product_price_retail =[];
            const product_size =[];
            {{-- alert(product_name); --}}

            {{-- $('input[name="product_id"]').each(function(){
                product_id.push($(this).val());
            });
            $('input[name="product_session_id"]').each(function(){
                product_session_id.push($(this).val());
            });
            $('input[name="product_name"]').each(function(){
                product_name.push($(this).val());
            });
            $('input[name="product_quantity"]').each(function(){
                product_quantity.push($(this).val());
            });
            $('input[name="product_price"]').each(function(){
                product_price.push($(this).val());
            });
            $('input[name="product_price_retail"]').each(function(){
                product_price_retail.push($(this).val());
            });
            $('input[name="product_size"]').each(function(){
                product_size.push($(this).val());
            }); --}}
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{route('save_data')}}',
                method:"POST",
                data:{product_id:product_id,
                    product_session_id:product_session_id,
                    product_name:product_name,
                    product_quantity:product_quantity,
                    product_price:product_price,
                    product_price_retail:product_price_retail,
                    product_size:product_size,
                    _token:_token
                },
                success:function(data){
                    $('#show-list-product').html(data);
            }
        });
     }
   });
});
</script> --}}
