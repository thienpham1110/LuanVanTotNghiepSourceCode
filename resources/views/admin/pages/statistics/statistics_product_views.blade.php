@extends('admin.index_layout_admin')
@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Statistical Product Views</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- content -->
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <form class="form-inline">
                                    @csrf
                                    <div class="form-group mr-3">
                                        <label for="status-select" class="mr-2">From Day</label>
                                        <input type="date" id="search_from_day_views" class="form-control search_from_day_views">
                                    </div>
                                    <div class="form-group">
                                        <label for="status-select" class="mr-2">To Day</label>
                                        <input type="date" id="search_to_day_views" class="form-control search_to_day_views">
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <a type="button" class="btn btn-success waves-effect waves-light clear-search-views">Clear</a>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <label class="mr-2">Type</label>
                                        <select class="custom-select search-view-select">
                                            <option selected="" value="0"> All</option>
                                            <option value="1">Day</option>
                                            <option value="2">Week-7-Day</option>
                                            <option value="3">Month-30-Day</option>
                                            <option value="4">Quarter Of The Year - 120 - Day</option>
                                            <option value="5">Year - 365 - Day</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                           <!-- end col-->
                        </div> <!-- end row -->
                    </div> <!-- end card-box -->
                </div><!-- end col-->
            </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Views Of The Day</th>
                                    <th class="font-weight-medium">Views Date</th>
                                    <th class="font-weight-medium">Total Views Product</th>
                                </tr>
                                </thead>
                                <tbody class="font-14 show_views_type_search" >
                                    @foreach ($all_product_views as $key=>$views)
                                    <tr>
                                        <td>
                                            <a href="javascript: void(0);">
                                                <img src="{{asset('public/uploads/admin/product/'.$views->Product->sanpham_anh)}}" alt="contact-img" title="contact-img" class="avatar-lg rounded-circle img-thumbnail">
                                            </a>
                                        </td>
                                        <td>
                                            {{ $views->Product->sanpham_ten }}
                                        </td>
                                        <td>
                                            {{ $views->viewssanpham_views }}
                                        </td>
                                        <td>
                                           {{ $views->viewssanpham_ngay_xem }}
                                        </td>
                                        @foreach ($total_view_array as $k=>$sum_views)
                                            @if($sum_views['product_id']==$views->sanpham_id)
                                                <td>{{ $sum_views['sum_view'] }}</td>
                                                @break
                                            @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
            <!-- end content -->
            <!-- end page title -->
        </div>
        <!-- container -->
    </div>
    <!-- content -->

    <!-- Footer Start -->
   @include('admin.blocks.footer_admin')
    <!-- end Footer -->
</div>

@endsection
