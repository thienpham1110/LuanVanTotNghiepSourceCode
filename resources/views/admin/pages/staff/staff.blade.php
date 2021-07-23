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
                        <div class="page-title-right">
                            <div class="text-lg-right mt-3 mt-lg-0">
                                <a href="{{URL::to('/staff-add')}}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                            </div>
                        </div>
                        <ol class="breadcrumb page-title">
                            <li class="breadcrumb-item"><a href="index.php">RGUWB</a></li>
                            <li class="breadcrumb-item active">Staff</li>
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
                                    <form class="form-inline" action="{{URL::to('/admin-search-staff')}}" method="GET">
                                        <div class="form-group">
                                            <label for="inputPassword2" class="sr-only">Search</label>
                                            <input type="search" class="form-control" name="search_staff_keyword"
                                            @if(isset($search_keyword))
                                                value="{{ $search_keyword }}"
                                            @endif
                                            placeholder="Search Keyword...">
                                        </div>
                                        <div class="form-group mx-sm-3">
                                            <label for="status-select" class="mr-2">Gender</label>
                                            <select class="custom-select" name="search_select_gender" id="status-select">
                                                @if(isset($search_gender))
                                                    @if($search_gender==-1)
                                                        <option selected="" value="-1">All</option>
                                                        <option value="1">Male</option>
                                                        <option value="0">Female</option>
                                                    @elseif($search_gender==1)
                                                        <option  value="-1">All</option>
                                                        <option selected="" value="1">Male</option>
                                                        <option value="0">Female</option>
                                                    @elseif($search_gender==0)
                                                        <option value="-1">All</option>
                                                        <option value="1">Male</option>
                                                        <option selected="" value="0">Female</option>
                                                    @endif
                                                @else
                                                    <option selected="" value="-1">All</option>
                                                    <option value="1">Male</option>
                                                    <option value="0">Female</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group mx-sm-3">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Search</button>
                                        </div>
                                        <div class="form-group ">
                                            <a href="{{URL::to('/staff')}}" class="btn btn-success waves-effect waves-light">All</a>
                                        </div>
                                    </form>
                                </div>
                               <!-- end col-->
                            </div> <!-- end row -->
                        </div> <!-- end card-box -->
                    </div><!-- end col-->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" cellspacing="0" id="tickets-table">
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
                                <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-medium">Images</th>
                                    <th class="font-weight-medium">Name</th>
                                    <th class="font-weight-medium">Gender</th>
                                    <th class="font-weight-medium">Email</th>
                                    <th class="font-weight-medium">Phone Number</th>
                                    <th class="font-weight-medium">Address</th>
                                    <th class="font-weight-medium">Status</th>
                                    <th class="font-weight-medium">Role</th>
                                    <th class="font-weight-medium">Action</th>
                                </tr>
                                </thead>
                                <tbody class="font-14">
                                    @foreach ($all_staff as $key=>$staff)
                                    <tr>
                                        <td>
                                            <a href="javascript: void(0);">
                                                <img src="{{asset('public/uploads/admin/staff/'.$staff->admin_anh)}}" alt="contact-img" title="contact-img" class="rounded-circle avatar-lg img-thumbnail">
                                            </a>
                                        </td>
                                        <td>
                                            {{ $staff->admin_ho}}  {{ $staff->admin_ten}}
                                        </td>
                                        <td>
                                            @if($staff->admin_gioi_tinh!=true)
                                                Null
                                            @else
                                                {{ $staff->admin_gioi_tinh?'Male':'Famale' }}
                                            @endif

                                        </td>
                                        <td>
                                            {{ $staff->admin_email}}
                                        </td>
                                        <td>
                                            {{ $staff->admin_so_dien_thoai }}
                                        </td>
                                        <td>
                                            {{ $staff->admin_dia_chi }}
                                        </td>
                                        <td>
                                            {{ $staff->admin_trang_thai?'Online':'Offline' }}
                                        </td>
                                        <td>

                                            @if($staff->UserAccount->loainguoidung_id==1)
                                                Admin
                                            @elseif($staff->UserAccount->loainguoidung_id==2)
                                                Staff
                                            @elseif($staff->UserAccount->loainguoidung_id==3)
                                                Shipper
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{URL::to('/staff-edit/'.$staff->id)}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                    <a class="dropdown-item" href="index_order_detail.php"><i class="mdi mdi-delete mr-2 text-muted font-18 vertical-middle"></i>Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                <nav>
                <ul class="pagination pagination-rounded mb-3">
                    {{ $all_staff->links('layout.paginationlinks') }}
                </ul>
            </nav>
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
