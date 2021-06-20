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
    <link rel="shortcut icon" href="{{URL::asset('public/backend/images\favicon.png')}}">
    <!-- App css -->
    <link href="{{URL::asset('public/backend/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('public/backend/css/icons.min.css')}}"rel="stylesheet" type="text/css">
    <link href="{{URL::asset('public/backend/css/app.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('public/backend/css/datatable.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::asset('public/backend/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::asset('public/backend/libs/multiselect/multi-select.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('public/backend/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::asset('public/backend/libs/clockpicker/bootstrap-clockpicker.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::asset('public/backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('public/backend/libs/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <link href="{{URL::asset('public/backend/libs/footable/footable.core.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::asset('public/backend/libs/custombox/custombox.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('public/backend/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::asset('public/backend/libs/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('public/backend/libs/switchery/switchery.min.css')}}"  rel="stylesheet" type="text/css">

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
    <script src="{{URL::asset('public/backend/libs/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('public/backend/libs/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('public/backend/js/pages/datatables.init.js')}}"></script>
    <script src="{{URL::asset('public/backend/libs/datatables/dataTables.bootstrap4.js')}}"></script>
	<script src="{{URL::asset('public/backend/libs/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('public/backend/js/vendor.min.js')}}"></script>
	<script src="{{URL::asset('public/backend/js/app.min.js')}}"></script>
    <script src="{{URL::asset('public/backend/js/jquery.js')}}"></script>
    <script src="{{URL::asset('public/backend/js/jquery2.js')}}"></script>
    <script src="{{URL::asset('public/backend/js/pages/form-fileuploads.init.js')}}"></script>
	<script src="{{URL::asset('public/backend/js/pages/form-advanced.init.js')}}"></script>
	<script src="{{URL::asset('public/backend/js/pages/form-pickers.init.js')}}"></script>

	<script src="{{URL::asset('public/backend/libs/jquery-quicksearch/jquery.quicksearch.min.js')}}"></script>

	<script src="{{URL::asset('public/backend/libs/clockpicker/bootstrap-clockpicker.min.js')}}"></script>
    <script src="{{URL::asset('public/backend/libs/moment/moment.min.js')}}"></script>

	<script src="{{URL::asset('public/backend/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::asset('public/backend/libs/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <script src="{{URL::asset('public/backend/libs/dropzone/dropzone.min.js')}}"></script>

	<script src="{{URL::asset('public/backend/libs/multiselect/jquery.multi-select.js')}}"></script>
    <script src="{{URL::asset('public/backend/libs/select2/select2.min.js')}}"></script>

	<script src="{{URL::asset('public/backend/libs/custombox/custombox.min.js')}}"></script>

	<script src="{{URL::asset('public/backend/libs/footable/footable.all.min.js')}}"></script>
	<script src="{{URL::asset('public/backend/js/pages/foo-tables.init.js')}}"></script>
    <script src="{{URL::asset('public/backend/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{URL::asset('public/backend/js/pages/sweet-alerts.init.js')}}"></script>

    <script src="{{URL::asset('public/backend/libs/datatables/jquery-3.5.1.js')}}"></script>
    <script src="{{URL::asset('public/backend/libs/datatables/my-datatable.js')}}"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="{{URL::asset('public/backend/js/jquery3.js')}}"></script>
    <script src="{{URL::asset('public/backend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{URL::asset('public/libs/switchery/switchery.min.js')}}" ></script>

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
                         {{--  $('#show-list-product').html(data);  --}}
                         window.location.href = "{{url('/product-import-add-multiple')}}";
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
                        Swal.fire({
                            title: "Delete Success",
                            type: "success",
                            showConfirmButton: !1,
                           timer: 500
                            });
                        {{--  $('#show-list-product').html(data);  --}}
                        window.location.href = "{{url('/product-import-add-multiple')}}";
                    }
                 });
             });
        }
        delete_row_queue();
    });
</script>
<script type="text/javascript">
    $('tbody').delegate('.product_quantity,.product_price','keyup',function(){
        var tr=$(this).parent().parent();
        var quantity=tr.find('.product_quantity').val();
        var price=tr.find('.product_price').val();
        var amount=(quantity*price);
        tr.find('.product_total').val(amount);
        total();
    });
    function total(){
        var total=0;
        $('.product_total').each(function(i,e){
            var amount=$(this).val()-0;
        total +=amount;
    });
    $('.total').html(total+".00 VNĐ");
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.delete-product-import-detail').click(function(){
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonClass: "btn-danger",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Close",
                closeOnConfirm: false,
                closeOnCancel: false
            },function(isConfirm) {
                if(isConfirm){
                    var id = $(this).data('id_product_import');
                    var product_import_id = $('.product_import_id_' + id).val();
                    $.ajax({
                        url: '{{url('/product-import-delete-detail')}}',
                        method: 'GET',
                        data:{product_import_id:product_import_id,_token:_token},
                        success:function(data){
                            swal("success");
                       }
                    });
                }

            })
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function(){
    fetch_transport_fee();
    function fetch_transport_fee(){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url : '{{url('/select-fee')}}',
            method: 'POST',
            data:{_token:_token},
            success:function(data){
               $('.load-transport-fee').html(data);
            }
        });
    }
    $('.transport-fee-add').on('click',function(){
        var city = $('.city').val();
        var province = $('.province').val();
        var wards = $('.wards').val();
        var transport_fee = $('.transport_fee').val();
        var transport_fee_day = $('.transport_fee_day').val();
        var _token = $('input[name="_token"]').val();
         $.ajax({
             url : '{{url('/transport-fee-add')}}',
             method: 'POST',
             data:{city:city, province:province, _token:_token, wards:wards, transport_fee:transport_fee,transport_fee_day:transport_fee_day},
             success:function(data){
                Swal.fire({
                    title: "Add Success",
                    type: "success",
                    showConfirmButton: !1,
                   timer: 500
                    });
                fetch_transport_fee();
             }
         });
     });
     $('.choose').on('change',function(){
         var action = $(this).attr('id');
         var ma_id = $(this).val();
         var _token = $('input[name="_token"]').val();
         var result = '';
         if(action=='city'){
             result = 'province';
         }else{
             result = 'wards';
         }
         $.ajax({
             url : '{{url('/select-transport-fee')}}',
             method: 'POST',
             data:{action:action,ma_id:ma_id,_token:_token},
             success:function(data){
                $('#'+ result).html(data);
             }
         });
     });
     $(document).on('blur','.fee-edit',function(){
        var feeship_id = $(this).data('feeship_id');
        var fee_value = $(this).text();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url : '{{url('/update-fee')}}',
            method: 'POST',
            data:{feeship_id:feeship_id, fee_value:fee_value, _token:_token},
            success:function(data){
                fetch_transport_fee();
            }
        });
    });
    $(document).on('blur','.fee-edit-day',function(){
        var feeship_id = $(this).data('feeship_id');
        var fee_value = $(this).text();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url : '{{url('/update-fee-day')}}',
            method: 'POST',
            data:{feeship_id:feeship_id, fee_value:fee_value, _token:_token},
            success:function(data){
                fetch_transport_fee();
            }
        });

    }); fetch_transport_fee();
});
</script>
