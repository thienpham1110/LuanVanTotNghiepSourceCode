<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductInStock;
use App\Models\ProductImportDetail;
use App\Models\ProductImage;
use App\Models\ProductDiscount;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Collection;
use App\Models\HeaderShow;
use App\Models\ProductViews;
use App\Models\ProductImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
session_start();
class StatisticsController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function ShowProductViewsStatistics(){
        $this->AuthLogin();
        $all_views=ProductViews::all();
        if($all_views->count()>0){
            foreach($all_views as $key=>$total_view){
                $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)->sum('viewssanpham_views');
                $total_view_array[]=array(
                    'product_id'=>$total_view->sanpham_id,
                    'sum_view'=>$pro_total_view
                );
            }
        }else{
            $total_view_array=null;
        }
        $all_product_views=ProductViews::orderby('viewssanpham_ngay_xem','DESC')->get();
        return view('admin.pages.statistics.statistics_product_views')
        ->with('total_view_array',$total_view_array)
        ->with('all_product_views',$all_product_views);
    }

    public function SearchViewsSelect(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date_now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $date_week=date("Y-m-d", strtotime($date_now . "- 7  day"));
        $date_month=date("Y-m-d", strtotime($date_now . "- 30  day"));
        $date_quarter=date("Y-m-d", strtotime($date_now . "- 120  day"));
        $date_year=date("Y-m-d", strtotime($date_now . "- 365  day"));
        if($data['search_type']==1){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem', $date_now)->get();
        }elseif($data['search_type']==2){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=',$date_week)->get();
        }elseif($data['search_type']==3){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=', $date_month)->get();
        }elseif($data['search_type']==4){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=',$date_quarter)->get();
        }elseif($data['search_type']==5){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=',$date_year)->get();
        }else{
            $all_product_views=ProductViews::orderby('viewssanpham_ngay_xem','DESC')->get();
        }
        if($all_product_views->count()>0){
            foreach($all_product_views as $key=>$total_view){
                if($data['search_type']==1){
                    $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)->
                    whereDate('viewssanpham_ngay_xem', $date_now)->sum('viewssanpham_views');
                }elseif($data['search_type']==2){
                    $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)
                    ->whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=',$date_week)->sum('viewssanpham_views');
                }elseif($data['search_type']==3){
                    $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)
                    ->whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=', $date_month)->sum('viewssanpham_views');
                }elseif($data['search_type']==4){
                    $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)
                    ->whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=',$date_quarter)->sum('viewssanpham_views');
                }elseif($data['search_type']==5){
                    $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)->
                    whereDate('viewssanpham_ngay_xem','<=', $date_now)->whereDate('viewssanpham_ngay_xem','>=',$date_year)->sum('viewssanpham_views');
                }else{
                    $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)->sum('viewssanpham_views');
                }
                $total_view_array[]=array(
                    'product_id'=>$total_view->sanpham_id,
                    'sum_view'=>$pro_total_view
                );
            }
        }else{
            $total_view_array=null;
        }
        $output = '';
        foreach($all_product_views as $key=>$views){
            $output .= '
            <tr>
            <td>
                <a href="javascript: void(0);">
                    <img src="'.asset('public/uploads/admin/product/'.$views->Product->sanpham_anh).'" alt="contact-img" title="contact-img" class="avatar-lg rounded-circle img-thumbnail">
                </a>
            </td>
            <td>
                '. $views->Product->sanpham_ten .'
            </td>
            <td>
            '. $views->viewssanpham_views .'
            </td>
            <td>
            '. $views->viewssanpham_ngay_xem .'
            </td>';
            foreach($total_view_array as $k=>$sum_views){
                if($sum_views['product_id']==$views->sanpham_id){
                    $output .= '
                    <td>'.$sum_views['sum_view'].'</td>
                    ';
                    break;
                }

            }
            $output .= ' </tr>
            ';
        }
        echo $output;
    }

    public function SearchFromToDayViews(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $all_views=ProductViews::all();
        if($all_views->count()>0){
            foreach($all_views as $key=>$total_view){
                $pro_total_view=ProductViews::where('sanpham_id',$total_view->sanpham_id)->sum('viewssanpham_views');
                $total_view_array[]=array(
                    'product_id'=>$total_view->sanpham_id,
                    'sum_view'=>$pro_total_view
                );
            }
        }else{
            $total_view_array=null;
        }
        if($data['from_day'] && $data['to_day']){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem','>=',$data['from_day'])->whereDate('viewssanpham_ngay_xem','<=',$data['to_day'])->get();
        }elseif(!$data['from_day'] && $data['to_day']){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem','<=',$data['to_day'])->get();
        }elseif($data['from_day'] && !$data['to_day']){
            $all_product_views=ProductViews::whereDate('viewssanpham_ngay_xem','>=',$data['from_day'])->get();
        }else{
            $all_product_views=ProductViews::orderby('viewssanpham_ngay_xem','DESC')->get();
        }
        $output = '';
        foreach($all_product_views as $key=>$views){
            $output .= '
            <tr>
            <td>
                <a href="javascript: void(0);">
                    <img src="'.asset('public/uploads/admin/product/'.$views->Product->sanpham_anh).'" alt="contact-img" title="contact-img" class="avatar-lg rounded-circle img-thumbnail">
                </a>
            </td>
            <td>
                '. $views->Product->sanpham_ten .'
            </td>
            <td>
            '. $views->viewssanpham_views .'
            </td>
            <td>
            '. $views->viewssanpham_ngay_xem .'
            </td>';
            foreach($total_view_array as $k=>$sum_views){
                if($sum_views['product_id']==$views->sanpham_id){
                    $output .= '
                    <td>'.$sum_views['sum_view'].'</td>
                    ';
                    break;
                }
            }
            $output .= ' </tr>
            ';
        }
        echo $output;
    }

    public function ShowProductInStockStatistics(){
        $this->AuthLogin();
        $all_product_in_stock_statistics=ProductInStock::orderby('id','DESC')->get();
        $all_size=Size::orderby('size_thu_tu','ASC')->get();
        return view('admin.pages.statistics.statistics_product_in_stock')
        ->with('all_size',$all_size)
        ->with('all_product_in_stock_statistics',$all_product_in_stock_statistics);
    }

    public function SearchProductInStockStatistics(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $all_size=Size::orderby('size_thu_tu','ASC')->get();
        $all_product=Product::all();
        if($all_product->count()>0 && $data['product_name']){
            foreach($all_product as $key =>$prod){
                $pro_name=Product::where('sanpham_ten','like','%'.$data['product_name'].'%')->get();
                foreach($pro_name as $k=>$v){
                    $pro_id[]=$v->id;
                }
            }
        }else{
            $pro_id=null;
        }
        if($data['product_name'] && $data['product_size']){
            $all_product_in_stock_statistics=ProductInStock::whereIn('sanpham_id',$pro_id)->where('size_id',$data['product_size'])->get();
        }elseif(!$data['product_name'] && $data['product_size']){
            $all_product_in_stock_statistics=ProductInStock::where('size_id',$data['product_size'])->get();
        }elseif($data['product_name'] && !$data['product_size']){
            $all_product_in_stock_statistics=ProductInStock::whereIn('sanpham_id',$pro_id)->get();
        }else{
            $all_product_in_stock_statistics=ProductInStock::orderby('id','DESC')->get();
        }
        $output = '';
        foreach($all_product_in_stock_statistics as $key=>$product_in_stock ){
            $output .= '
            <tr>
                <td>
                    <a href="javascript: void(0);">
                        <img src="'.asset('public/uploads/admin/product/'.$product_in_stock->Product->sanpham_anh).'" alt="contact-img" title="contact-img" class="avatar-lg rounded-circle img-thumbnail">
                    </a>
                </td>
                <td>
                    '. $product_in_stock->Product->sanpham_ten .'
                </td>
                <td>
                '. $product_in_stock->Size->size .'
                </td>
                <td>
                '.number_format( $product_in_stock->sanphamtonkho_so_luong_ton ,0,',','.' ) .'
                </td>
                <td>
                '.number_format( $product_in_stock->sanphamtonkho_so_luong_da_ban ,0,',','.' ) .'
                </td>
            </tr>
            ';
        }
        echo $output;
    }

    public function ShowImportStatistics(){
        $this->AuthLogin();
        $all_product_import_statistics=ProductImport::orderby('id','DESC')->get();
        if($all_product_import_statistics->count()>0){
            foreach($all_product_import_statistics as $key=>$import_detail){
                $id_import[]=$import_detail->id;
            }
        }else{
            $id_import=null;
        }
        $count_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->count();
        $sum_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->sum('chitietnhap_so_luong_nhap');
        $all_import_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->get();
        $sum_total_import=ProductImport::sum('donnhaphang_tong_tien');
        return view('admin.pages.statistics.statistics_product_import')
        ->with('all_import_detail',$all_import_detail)
        ->with('sum_total_import',$sum_total_import)
        ->with('sum_detail',$sum_detail)
        ->with('count_detail',$count_detail)
        ->with('all_product_import_statistics',$all_product_import_statistics);
    }

    public function SearchImportStatistics(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        if($data['from_day'] && $data['to_day']){
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap','>=',$data['from_day'])
            ->whereDate('donnhaphang_ngay_nhap','<=',$data['to_day'])->get();
            $sum_total_import=ProductImport::whereDate('donnhaphang_ngay_nhap','>=',$data['from_day'])
            ->whereDate('donnhaphang_ngay_nhap','<=',$data['to_day'])->sum('donnhaphang_tong_tien');
        }elseif(!$data['from_day'] && $data['to_day']){
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap','<=',$data['to_day'])->get();
            $sum_total_import=ProductImport::whereDate('donnhaphang_ngay_nhap','<=',$data['to_day'])->sum('donnhaphang_tong_tien');
        }elseif($data['from_day'] && !$data['to_day']){
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap','>=',$data['from_day'])->get();
            $sum_total_import=ProductImport::whereDate('donnhaphang_ngay_nhap','>=',$data['from_day'])->sum('donnhaphang_tong_tien');
        }else{
            $all_product_import_statistics=ProductImport::orderby('donnhaphang_ngay_nhap','DESC')->get();
            $sum_total_import=ProductImport::sum('donnhaphang_tong_tien');
        }
        if($all_product_import_statistics->count()>0){
            foreach($all_product_import_statistics as $key=>$import_detail){
                $id_import[]=$import_detail->id;
            }
        }else{
            $id_import=null;
        }
        $all_import_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->get();
        $count_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->count();
        $sum_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->sum('chitietnhap_so_luong_nhap');
        $output = '';
        $output .= '
        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 " cellspacing="0" id="tickets-table">
            <h4 class="mt-3 mb-3"><span>Total: </span><span>'.number_format( $sum_total_import ,0,',','.' )." VNĐ" .'</span></h4>
            <h4 class="mt-3 mb-3"><span>Product: </span><span>'.number_format( $count_detail ,0,',','.' ) .'</span></h4>
            <h4 class="mt-3 mb-3"><span>Import Quantity: </span><span>'.number_format( $sum_detail ,0,',','.' ) .'</span></h4>
            <thead class="bg-light">
                <tr>
                    <th class="font-weight-medium">No.</th>
                    <th class="font-weight-medium">Day</th>
                    <th class="font-weight-medium">Supplier</th>
                    <th class="font-weight-medium">Total</th>
                </tr>
            </thead>
            <tbody class="font-14 show_views_type_search" >';
                foreach ($all_product_import_statistics as $key=>$product_import){
                    $output .= ' <tr>
                        <td>
                            '. $product_import->donnhaphang_ma_don_nhap_hang .'
                        </td>
                        <td>
                            '. date('d-m-Y', strtotime( $product_import->donnhaphang_ngay_nhap)) .'
                        </td>
                        <td>
                        '.$product_import->Supplier->nhacungcap_ten .'
                        </td>
                        <td>
                            '.number_format( $product_import->donnhaphang_tong_tien ,0,',','.' ).' VNĐ' .'
                        </td>
                    </tr>';
                }
                $output .= '
            </tbody>
        </table>
        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 " cellspacing="0" id="tickets-table">
            <h4 class="mt-3 mb-3"><span>Product: </span></h4>
            <thead class="bg-light">
                <tr>
                    <th class="font-weight-medium">No.</th>
                    <th class="font-weight-medium">Day</th>
                    <th class="font-weight-medium">Product Name</th>
                    <th class="font-weight-medium">Size</th>
                    <th class="font-weight-medium">Import Price</th>
                    <th class="font-weight-medium">Quantity</th>
                    <th class="font-weight-medium">Total</th>
                </tr>
            </thead>
            <tbody class="font-14 show_views_type_search" >';
                foreach ($all_import_detail as $key=>$product_import_detail){
                    $output .= ' <tr>
                        <td>
                            '. $product_import_detail->chitietnhap_ma_don_nhap_hang .'
                        </td>
                        <td>
                            '. date('d-m-Y', strtotime( $product_import_detail->ProductImport->donnhaphang_ngay_nhap)) .'
                        </td>
                        <td>
                        '.$product_import_detail->Product->sanpham_ten .'
                        </td>
                        <td>
                        '.$product_import_detail->Size->size .'
                        </td>
                        <td>
                            '.number_format( $product_import_detail->chitietnhap_gia_nhap ,0,',','.' ).' VNĐ' .'
                        </td>
                        <td>
                        '.$product_import_detail->chitietnhap_so_luong_nhap .'
                        </td>
                        <td>
                            '.number_format( $product_import_detail->chitietnhap_so_luong_nhap* $product_import_detail->chitietnhap_gia_nhap,0,',','.' ).' VNĐ' .'
                        </td>
                    </tr>';
                }
                $output .= '
            </tbody>
        </table>
        ';
        echo $output;
    }

    public function SearchSelectImportStatistics(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date_now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $date_week=date("Y-m-d", strtotime($date_now . "- 7  day"));
        $date_month=date("Y-m-d", strtotime($date_now . "- 30  day"));
        $date_quarter=date("Y-m-d", strtotime($date_now . "- 120  day"));
        $date_year=date("Y-m-d", strtotime($date_now . "- 365  day"));
        if($data['search_type']==1){
            $sum_total_import=ProductImport::whereDate('donnhaphang_ngay_nhap', $date_now)->sum('donnhaphang_tong_tien');
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap', $date_now)->get();
        }elseif($data['search_type']==2){
            $sum_total_import=ProductImport::whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=',$date_week)->sum('donnhaphang_tong_tien');
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=',$date_week)->get();
        }elseif($data['search_type']==3){
            $sum_total_import=ProductImport::whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=', $date_month)->sum('donnhaphang_tong_tien');
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=', $date_month)->get();
        }elseif($data['search_type']==4){
            $sum_total_import=ProductImport::whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=',$date_quarter)->sum('donnhaphang_tong_tien');
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=',$date_quarter)->get();
        }elseif($data['search_type']==5){
            $sum_total_import=ProductImport:: whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=',$date_year)->sum('donnhaphang_tong_tien');
            $all_product_import_statistics=ProductImport::whereDate('donnhaphang_ngay_nhap','<=', $date_now)->whereDate('donnhaphang_ngay_nhap','>=',$date_year)->get();
        }else{
            $sum_total_import=ProductImport::sum('donnhaphang_tong_tien');
            $all_product_import_statistics=ProductImport::orderby('donnhaphang_ngay_nhap','DESC')->get();
        }
        if($all_product_import_statistics->count()>0){
            foreach($all_product_import_statistics as $key=>$import_detail){
                $id_import[]=$import_detail->id;
            }
        }else{
            $id_import=null;
        }
        $all_import_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->get();
        $count_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->count();
        $sum_detail=ProductImportDetail::whereIn('donnhaphang_id',$id_import)->sum('chitietnhap_so_luong_nhap');
        $output = '';
        $output .= '
        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 " cellspacing="0" id="tickets-table">
            <h4 class="mt-3 mb-3"><span>Total: </span><span>'.number_format( $sum_total_import ,0,',','.' )." VNĐ" .'</span></h4>
            <h4 class="mt-3 mb-3"><span>Product: </span><span>'.number_format( $count_detail ,0,',','.' ) .'</span></h4>
            <h4 class="mt-3 mb-3"><span>Import Quantity: </span><span>'.number_format( $sum_detail ,0,',','.' ) .'</span></h4>
            <thead class="bg-light">
                <tr>
                    <th class="font-weight-medium">No.</th>
                    <th class="font-weight-medium">Day</th>
                    <th class="font-weight-medium">Supplier</th>
                    <th class="font-weight-medium">Total</th>
                </tr>
            </thead>
            <tbody class="font-14 show_views_type_search" >';
                foreach ($all_product_import_statistics as $key=>$product_import){
                    $output .= ' <tr>
                        <td>
                            '. $product_import->donnhaphang_ma_don_nhap_hang .'
                        </td>
                        <td>
                            '. date('d-m-Y', strtotime( $product_import->donnhaphang_ngay_nhap)) .'
                        </td>
                        <td>
                        '.$product_import->Supplier->nhacungcap_ten .'
                        </td>
                        <td>
                            '.number_format( $product_import->donnhaphang_tong_tien ,0,',','.' ).' VNĐ' .'
                        </td>
                    </tr>';
                }
                $output .= '
            </tbody>
        </table>
        <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100 " cellspacing="0" id="tickets-table">
        <h4 class="mt-3 mb-3"><span>Product: </span></h4>
        <thead class="bg-light">
            <tr>
                <th class="font-weight-medium">No.</th>
                <th class="font-weight-medium">Day</th>
                <th class="font-weight-medium">Product Name</th>
                <th class="font-weight-medium">Size</th>
                <th class="font-weight-medium">Import Price</th>
                <th class="font-weight-medium">Quantity</th>
                <th class="font-weight-medium">Total</th>
            </tr>
        </thead>
        <tbody class="font-14 show_views_type_search" >';
            foreach ($all_import_detail as $key=>$product_import_detail){
                $output .= ' <tr>
                    <td>
                        '. $product_import_detail->chitietnhap_ma_don_nhap_hang .'
                    </td>
                    <td>
                        '. date('d-m-Y', strtotime( $product_import_detail->ProductImport->donnhaphang_ngay_nhap)) .'
                    </td>
                    <td>
                    '.$product_import_detail->Product->sanpham_ten .'
                    </td>
                    <td>
                    '.$product_import_detail->Size->size .'
                    </td>
                    <td>
                        '.number_format( $product_import_detail->chitietnhap_gia_nhap ,0,',','.' ).' VNĐ' .'
                    </td>
                    <td>
                    '.$product_import_detail->chitietnhap_so_luong_nhap .'
                    </td>
                    <td>
                        '.number_format( $product_import_detail->chitietnhap_so_luong_nhap* $product_import_detail->chitietnhap_gia_nhap,0,',','.' ).' VNĐ' .'
                    </td>
                </tr>';
            }
            $output .= '
        </tbody>
    </table>
        ';
        echo $output;
    }
}
