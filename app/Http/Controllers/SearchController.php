<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\ProductType;
use App\Models\ProductInStock;
use App\Models\ProductDiscount;
use App\Models\Discount;
use App\Models\AboutStore;
use App\Models\HeaderShow;
use App\Models\Comment;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Mail;
session_start();
class SearchController extends Controller
{
    public function ShowProductSearchHeaderCustomer()
    {
        $now=time();
        $data=Session::get('search_keyword');
        $search_time=Session::get('search_time');
        if (!$data || !$search_time || $now > $search_time ||$data==null ||$data=="") {
            Session::forget('search_keyword');
            Session::forget('search_time');
            return redirect()->back();
        } else {
            $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton', '>', 0)->orderby('id', 'DESC')->get();
            $comment_customer=Comment::where('binhluan_id_phan_hoi', '=', 0)->where('binhluan_trang_thai', 1)
            ->where('binhluan_diem_danh_gia', '>=', 4)->get();
            foreach ($comment_customer as $key=>$comment) {
                $pro_rate_id[]=$comment->sanpham_id;
            }
            if ($pro_rate_id) {
                $all_product_rate=Product::where('sanpham_trang_thai', 1)->whereIn('id', $pro_rate_id)->get();
            } else {
                $all_product_rate=Product::where('sanpham_trang_thai', 1)->get();
            }
            foreach ($all_product_in_stock as $key =>$in_stock) {
                $product_id[]=$in_stock->sanpham_id;
            }
            $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
            $all_product=Product::whereIn('id', $product_id)->where('sanpham_trang_thai', '1')
            ->where('sanpham_ten', 'like', '%'.$data.'%')->orderBy('id', 'DESC')->paginate(9);
            $all_size=Size::where('size_trang_thai', 1)->orderby('size_thu_tu', 'ASC')->get();
            $all_product_type=ProductType::where('loaisanpham_trang_thai', '1')->orderBy('id', 'DESC')->get();
            $all_brand=Brand::where('thuonghieu_trang_thai', '1')->orderBy('id', 'DESC')->get();
            $all_collection=Collection::where('dongsanpham_trang_thai', '1')->orderBy('id', 'DESC')->get();
            $all_header=HeaderShow::where('headerquangcao_trang_thai', '1')
            ->orderby('headerquangcao_thu_tu', 'ASC')->get();
            foreach ($all_header as $key=>$value) {
                $thu_tu_header=$value->headerquangcao_thu_tu;
                break;
            }
            return view('client.pages.products.product')
            ->with('all_product', $all_product)
            ->with('all_product_rate', $all_product_rate)
            ->with('product_type', $all_product_type)
            ->with('product_brand', $all_brand)
            ->with('get_about_us_bottom',$get_about_us_bottom)
            ->with('product_collection', $all_collection)
            ->with('header_show', $all_header)
            ->with('all_size', $all_size)
            ->with('comment_customer', $comment_customer)
            ->with('header_min', $thu_tu_header);
        }
    }

    public function GetKeyWordSearch(Request $request)
    {
        $data=$request->all();
        $now=time();
        if ($data['search_product_customer'] =="") {
            return redirect()->back();
        } else {
            Session::put('search_keyword', $data['search_product_customer']);
            Session::put('search_time', $now + 600);
            return Redirect::to('/search-product-customer');
        }
    }

    public function GetFilterSearchCustomer(Request $request)
    {
        $data=$request->all();
        $now=time();
        if ($data['search_customer_brand'] ==null && $data['search_customer_product_type'] ==null && $data['search_customer_collection'] ==null && $data['search_customer_price'] ==null && $data['search_customer_gender'] ==null && $data['search_customer_size']==null) {
            return Redirect::to('/shop-now');
        } else {
            $search_filter_customer[] = array(
                'search_customer_brand' => $data['search_customer_brand'],
                'search_customer_product_type' =>  $data['search_customer_product_type'],
                'search_customer_collection' =>  $data['search_customer_collection'],
                'search_customer_price' =>  $data['search_customer_price'],
                'search_customer_gender' =>  $data['search_customer_gender'],
                'search_customer_size' =>  $data['search_customer_size'],
                'search_time_filter' => $now + 60,
            );
            Session::put('search_filter_customer', $search_filter_customer);
            return Redirect::to('/search-product-filter-customer');
        }
    }

    public function ShowProductSearchFilterCustomer()
    {
        $now=time();
        $search_filter=Session::get('search_filter_customer');
        if (!$search_filter  || $search_filter==null) {
            return Redirect::to('/shop-now');
        } else {
            foreach ($search_filter as $key =>$value) {
                $search_customer_brand = $value['search_customer_brand'];
                $search_customer_product_type =  $value['search_customer_product_type'];
                $search_customer_collection =  $value['search_customer_collection'];
                $search_customer_price =  $value['search_customer_price'];
                $search_customer_gender = $value['search_customer_gender'];
                $search_customer_size =  $value['search_customer_size'];
                $search_time_filter = $value['search_time_filter'];
                break;
            }
            if($now > $search_time_filter){
                Session::forget('search_filter_customer');
                return Redirect::to('/shop-now');
            }else{
                if ($search_customer_size!=null) {
                    $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton', '>', 0)->where('size_id', $search_customer_size)->orderby('id', 'DESC')->first();
                    if($all_product_in_stock==null){
                        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton', '>', 0)->orderby('id', 'DESC')->get();
                    }else{
                        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton', '>', 0)->where('size_id', $search_customer_size)->orderby('id', 'DESC')->get();
                    }
                }else {
                    $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton', '>', 0)->orderby('id', 'DESC')->get();
                }
                $comment_customer=Comment::where('binhluan_id_phan_hoi', '=', 0)->where('binhluan_trang_thai', 1)
                ->where('binhluan_diem_danh_gia', '>=', 4)->get();
                foreach ($comment_customer as $key=>$comment) {
                    $pro_rate_id[]=$comment->sanpham_id;
                }
                if ($pro_rate_id) {
                    $all_product_rate=Product::where('sanpham_trang_thai', 1)->whereIn('id', $pro_rate_id)->get();
                } else {
                    $all_product_rate=Product::where('sanpham_trang_thai', 1)->get();
                }
                foreach ($all_product_in_stock as $key =>$in_stock) {
                    $product_id[]=$in_stock->sanpham_id;
                }
                $viewed=Session::get('product_viewed');
                if($viewed){
                    foreach($viewed as $key=>$view){
                        $view_id[]=$view['product_id_viewed'];
                    }
                }else{
                    $view_id[]=null;
                }
                $discount=Discount::where('khuyenmai_trang_thai', 1)->get();//lay tin km
                if ($discount->count()>0) {
                    foreach ($discount as $key => $value) {
                        $product_discount=ProductDiscount::where('khuyenmai_id', $value->id)->get();//lay sp dc km
                        foreach ($product_discount as $k => $v) {
                            $pro_dis[]=$v->sanpham_id;//id sp km
                        }
                    }
                    $all_product_viewed=Product::whereIn('id',$view_id)->where('sanpham_trang_thai','1')
                    ->whereIn('id',$product_id)
                    ->whereNotIn('id',$pro_dis)->orderBy('id','DESC')->get();
                    if($search_customer_brand!=null){
                        if($search_customer_product_type!=null){//brand!=null
                            if($search_customer_collection!=null){//brand!=null product type != null
                                if($search_customer_gender!=null){//brand!=null product type != null collection != null
                                    if($search_customer_price!=null){//brand!=null product type != null collection != null gender!=null price!=null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//gender=null
                                    if($search_customer_price!=null){//gender=null collection != null brand !=null  product type != null

                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }else{//collection = null brand !=null  product type != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection != null brand !=null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{
                                    if($search_customer_price!=null){//gender=null collection != null brand !=null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }
                        }else{//product type = null brand !=null
                            if($search_customer_collection!=null){//product type = null brand !=null collection != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection != null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//product type = null brand !=null collection != null gender =null
                                    if($search_customer_price!=null){//gender=null collection != null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }

                                }
                            }else{//product type = null brand !=null collection = null
                                if($search_customer_gender!=null){//product type = null brand !=null collection = null
                                    if($search_customer_price!=null){//gender!=null collection = null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection = null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//product type = null brand !=null collection = null gender=null
                                    if($search_customer_price!=null){//gender=null collection = null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection = null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }
                        }
                    }else{//brand = null
                        if($search_customer_product_type!=null){//brand=null
                            if($search_customer_collection!=null){//brand=null product type != null
                                if($search_customer_gender!=null){//brand=null product type != null collection != null
                                    if($search_customer_price!=null){//gender!=null collection != null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//gender=null collection != null brand =null  product type != null
                                    if($search_customer_price!=null){//gender=null collection != null brand =null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection! = null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }else{//collection = null brand =null  product type != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection = null brand !=null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection = null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{
                                    if($search_customer_price!=null){//gender=null collection = null brand =null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection = null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }
                        }else{//product type = null brand =null
                            if($search_customer_collection!=null){//product type = null brand =null collection != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection != null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }

                                }else{//product type = null brand =null collection != null gender =null
                                    if($search_customer_price!=null){//gender=null collection != null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }else{//product type = null brand !=null collection = null
                                if($search_customer_gender!=null){//product type = null brand=null collection = null
                                    if($search_customer_price!=null){//gender!=null collection = null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection = null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//product type = null brand=null collection = null gender=null
                                    if($search_customer_price!=null){//gender=null collection = null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection = null gender=null price=null
                                        return Redirect::to('/shop-now');
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $all_product_viewed=Product::whereIn('id',$view_id)->where('sanpham_trang_thai','1')
                    ->whereIn('id',$product_id)->orderBy('id','DESC')->get();
                    if($search_customer_brand!=null){
                        if($search_customer_product_type!=null){//brand!=null
                            if($search_customer_collection!=null){//brand!=null product type != null
                                if($search_customer_gender!=null){//brand!=null product type != null collection != null
                                    if($search_customer_price!=null){//brand!=null product type != null collection != null gender!=null price!=null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//gender=null
                                    if($search_customer_price!=null){//gender=null collection != null brand !=null  product type != null

                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }else{//collection = null brand !=null  product type != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection != null brand !=null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{
                                    if($search_customer_price!=null){//gender=null collection != null brand !=null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type != null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }
                        }else{//product type = null brand !=null
                            if($search_customer_collection!=null){//product type = null brand !=null collection != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection != null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//product type = null brand !=null collection != null gender =null
                                    if($search_customer_price!=null){//gender=null collection != null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }

                                }
                            }else{//product type = null brand !=null collection = null
                                if($search_customer_gender!=null){//product type = null brand !=null collection = null
                                    if($search_customer_price!=null){//gender!=null collection = null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection = null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//product type = null brand !=null collection = null gender=null
                                    if($search_customer_price!=null){//gender=null collection = null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('thuonghieu_id',$search_customer_brand )
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand!=null product type = null collection = null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('thuonghieu_id',$search_customer_brand )
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }
                        }
                    }else{//brand = null
                        if($search_customer_product_type!=null){//brand=null
                            if($search_customer_collection!=null){//brand=null product type != null
                                if($search_customer_gender!=null){//brand=null product type != null collection != null
                                    if($search_customer_price!=null){//gender!=null collection != null brand !=null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//gender=null collection != null brand =null  product type != null
                                    if($search_customer_price!=null){//gender=null collection != null brand =null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection! = null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }else{//collection = null brand =null  product type != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection = null brand !=null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection = null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{
                                    if($search_customer_price!=null){//gender=null collection = null brand =null  product type != null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('loaisanpham_id', $search_customer_product_type)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type != null collection = null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('loaisanpham_id', $search_customer_product_type)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }
                        }else{//product type = null brand =null
                            if($search_customer_collection!=null){//product type = null brand =null collection != null
                                if($search_customer_gender!=null){
                                    if($search_customer_price!=null){//gender!=null collection != null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection != null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }

                                }else{//product type = null brand =null collection != null gender =null
                                    if($search_customer_price!=null){//gender=null collection != null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('dongsanpham_id', $search_customer_collection)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection != null gender=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('dongsanpham_id', $search_customer_collection)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }
                            }else{//product type = null brand !=null collection = null
                                if($search_customer_gender!=null){//product type = null brand=null collection = null
                                    if($search_customer_price!=null){//gender!=null collection = null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection = null gender!=null price=null
                                        $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                        ->where('sanpham_nguoi_su_dung',$search_customer_gender)
                                        ->orderBy('id', 'DESC')->paginate(9);
                                    }
                                }else{//product type = null brand=null collection = null gender=null
                                    if($search_customer_price!=null){//gender=null collection = null brand =null  product type = null
                                        if($search_customer_price==1){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->where('sanpham_gia_ban','<',500000)
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==2){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->whereBetween('sanpham_gia_ban',[500000,1000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==3){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->whereBetween('sanpham_gia_ban',[1000000,2000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==4){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->whereBetween('sanpham_gia_ban',[2000000,5000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==5){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->whereBetween('sanpham_gia_ban',[5000000,10000000])
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }elseif($search_customer_price==6){
                                            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')
                                            ->orderBy('id', 'DESC')->paginate(9);
                                        }
                                    }else{//brand=null product type = null collection = null gender=null price=null
                                        return Redirect::to('/shop-now');
                                    }
                                }
                            }
                        }
                    }
                }

                $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
                $all_size=Size::where('size_trang_thai', 1)->orderby('size_thu_tu', 'ASC')->get();
                $all_product_type=ProductType::where('loaisanpham_trang_thai', '1')->orderBy('id', 'DESC')->get();
                $all_brand=Brand::where('thuonghieu_trang_thai', '1')->orderBy('id', 'DESC')->get();
                $all_collection=Collection::where('dongsanpham_trang_thai', '1')->orderBy('id', 'DESC')->get();
                $all_header=HeaderShow::where('headerquangcao_trang_thai', '1')
                ->orderby('headerquangcao_thu_tu', 'ASC')->get();
                foreach ($all_header as $key=>$value) {
                    $thu_tu_header=$value->headerquangcao_thu_tu;
                    break;
                }
                return view('client.pages.products.product')
                ->with('all_product', $all_product)
                ->with('all_product_rate', $all_product_rate)
                ->with('product_type', $all_product_type)
                ->with('product_brand', $all_brand)
                ->with('get_about_us_bottom',$get_about_us_bottom)
                ->with('product_collection', $all_collection)
                ->with('header_show', $all_header)
                ->with('all_size', $all_size)
                ->with('all_product_viewed', $all_product_viewed)
                ->with('comment_customer', $comment_customer)
                ->with('header_min', $thu_tu_header);
            }
        }
    }
}
