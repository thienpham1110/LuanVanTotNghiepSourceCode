<?php

namespace App\Http\Controllers;

use App\Models\AboutStore;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\Delivery;
use App\Models\ProductType;
use App\Models\ProductInStock;
use App\Models\ProductImportDetail;
use App\Models\ProductImage;
use App\Models\ProductDiscount;
use App\Models\Discount;
use App\Models\Customer;
use App\Models\HeaderShow;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Comment;
use App\Models\SlideShow;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Mail;
session_start();

class HomeController extends Controller
{
    public function Index(){

        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
        foreach($all_product_in_stock as $key =>$in_stock){
            $product_id[]=$in_stock->sanpham_id;
        }
        $all_featured=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('sanphamtonkho_so_luong_da_ban','DESC')->get();
        foreach($all_featured as $key =>$featured){
            $pro_fea_id[]=$featured->sanpham_id;
        }
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->get();//lay sp dc km
                foreach ($product_discount as $k => $v) {
                    $pro_dis[]=$v->sanpham_id;//id sp km
                }
            }
            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)->orderBy('id','DESC')->paginate(9);
            $all_product_featured=Product::whereIn('id',$pro_fea_id)->whereNotIn('id',$pro_dis)->where('sanpham_trang_thai','1')->get();
        }else{
            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
            $all_product_featured=Product::whereIn('id',$pro_fea_id)->where('sanpham_trang_thai','1')->get();
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $all_slide=SlideShow::where('slidequangcao_trang_thai','1')->orderby('slidequangcao_thu_tu','ASC')->get();
    	return view('client.pages.index_home')
        ->with('all_product',$all_product)
        ->with('all_product_in_stock',$all_product_in_stock)
        ->with('all_product_featured',$all_product_featured)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header)
        ->with('slide_show',$all_slide);
    }

    public function ShowMyWishlist(){
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
    	return view('client.pages.products.product_wishlist')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('all_product_in_stock',$all_product_in_stock)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function MenuShowProductDiscount(){
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        $comment_customer=Comment::where('binhluan_id_phan_hoi','=',0)->where('binhluan_trang_thai',1)
        ->where('binhluan_diem_danh_gia','>=',4)->get();
        foreach($comment_customer as $key=>$comment){
            $pro_rate_id[]=$comment->sanpham_id;
        }
        if($pro_rate_id){
            $all_product_rate=Product::where('sanpham_trang_thai',1)->whereIn('id',$pro_rate_id)->get();
        }else{
            $all_product_rate=Product::where('sanpham_trang_thai',1)->get();
        }
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->get();//lay sp dc km
                foreach ($product_discount as $k => $v) {
                    $pro_dis[]=$v->sanpham_id;//id sp km
                }
            }
            $product_import_in_stock=ProductInstock::whereIn('sanpham_id',$pro_dis)->get();//lay sp km trong kho
            $all_product=Product::whereIn('id',$pro_dis)->paginate(9);//lay sp km
        }else{
            return Redirect::to('/shop-now')->with('message','No Promotion');
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_discount=ProductDiscount::whereIn('sanpham_id',$pro_dis)->get();//lay sp dc km
        $all_size=Size::where('size_trang_thai',1)->orderby('size_thu_tu','ASC')->get();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.products.show_product_promotion')
		->with('all_product_discount', $all_product_discount)
        ->with('all_product_rate',$all_product_rate)
        ->with('comment_customer',$comment_customer)
        ->with('all_product', $all_product)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_import_in_stock', $product_import_in_stock)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('all_size',$all_size)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    public function MenuShowProductDiscountDetail($product_id){
        $comment_customer=Comment::where('sanpham_id',$product_id)->where('binhluan_id_phan_hoi','=',0)->where('binhluan_trang_thai',1)->get();
        $comment_admin=Comment::with('Product')->where('binhluan_id_phan_hoi','>',0)->get();
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $pro_dis[]=$value->id;
            }
        }else{
            return Redirect::to('/shop-now')->with('message','No Promotion');
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $product_discount=ProductDiscount::whereIn('khuyenmai_id',$pro_dis)->where('sanpham_id',$product_id)->first();//lay sp dc km
        $all_product_image=ProductImage::where('sanpham_id',$product_id)->orderby('id','DESC')->get();
        $get_product=Product::find($product_id);
        $all_size=ProductInStock::select('size_id')->where('sanpham_id',$product_id)->where('sanphamtonkho_so_luong_ton','>',0)->get();
        $get_in_stock=ProductInStock::where('sanpham_id',$product_id)->get();
        $all_product_type=ProductType::orderby('id','desc')->get();
        $all_brand=Brand::orderby('id','desc')->get();
        $all_collection=Collection::orderby('id','desc')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
    	return view('client.pages.products.show_detail_product_promotion')
        ->with('product',$get_product)
        ->with('all_size',$all_size)
        ->with('product_discount',$product_discount)
        ->with('get_in_stock',$get_in_stock)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('comment_customer',$comment_customer)
        ->with('all_product_image',$all_product_image)
        ->with('comment_admin',$comment_admin)
        ->with('header_min',$thu_tu_header);
    }

    public function MenuShowProductNow(){
         Session::forget('search_filter_customer');
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
        $comment_customer=Comment::where('binhluan_id_phan_hoi','=',0)->where('binhluan_trang_thai',1)
        ->where('binhluan_diem_danh_gia','>=',4)->get();
        foreach($comment_customer as $key=>$comment){
            $pro_rate_id[]=$comment->sanpham_id;
        }
        if($pro_rate_id){
            $all_product_rate=Product::where('sanpham_trang_thai',1)->whereIn('id',$pro_rate_id)->get();
        }else{
            $all_product_rate=Product::where('sanpham_trang_thai',1)->get();
        }
        foreach($all_product_in_stock as $key =>$in_stock){
            $product_id[]=$in_stock->sanpham_id;
        }
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->get();//lay sp dc km
                foreach ($product_discount as $k => $v) {
                    $pro_dis[]=$v->sanpham_id;//id sp km
                }
            }
            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->whereNotIn('id',$pro_dis)->orderBy('id','DESC')->paginate(9);
        }else{
            $all_product=Product::whereIn('id',$product_id)->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
        }
        $all_size=Size::where('size_trang_thai',1)->orderby('size_thu_tu','ASC')->get();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        Session::put('pages_name','Shop Now');
    	return view('client.pages.products.product')
        ->with('all_product',$all_product)
        ->with('all_product_in_stock',$all_product_in_stock)
        ->with('all_product_rate',$all_product_rate)
        ->with('comment_customer',$comment_customer)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('all_size',$all_size)
        ->with('header_min',$thu_tu_header);
    }

    public function MenuShowProductType($product_type_id){
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
        $comment_customer=Comment::where('binhluan_id_phan_hoi','=',0)->where('binhluan_trang_thai',1)
        ->where('binhluan_diem_danh_gia','>=',4)->get();
        foreach($comment_customer as $key=>$comment){
            $pro_rate_id[]=$comment->sanpham_id;
        }
        if($pro_rate_id){
            $all_product_rate=Product::where('sanpham_trang_thai',1)->whereIn('id',$pro_rate_id)->get();
        }else{
            $all_product_rate=Product::where('sanpham_trang_thai',1)->get();
        }
        foreach($all_product_in_stock as $key =>$in_stock){
            $product_id[]=$in_stock->sanpham_id;
        }
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->get();//lay sp dc km
                foreach ($product_discount as $k => $v) {
                    $pro_dis[]=$v->sanpham_id;//id sp km
                }
            }
            $all_product=Product::whereIn('id',$product_id)->where('loaisanpham_id',$product_type_id)->whereNotIn('id',$pro_dis)
            ->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
        }else{
            $all_product=Product::whereIn('id',$product_id)->where('loaisanpham_id',$product_type_id)
            ->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_size=Size::where('size_trang_thai',1)->orderby('size_thu_tu','ASC')->get();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $product_type=ProductType::find($product_type_id);
        Session::put('pages_name','Category'.'<li><i class="fa fa-angle-right"></i></li>'.'<li>'.$product_type->loaisanpham_ten.'</li>');
    	return view('client.pages.products.product')
        ->with('all_product_rate',$all_product_rate)
        ->with('comment_customer',$comment_customer)
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('all_size',$all_size)
        ->with('header_min',$thu_tu_header);
    }
    public function MenuShowProducBrand($product_brand_id){
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
        $comment_customer=Comment::where('binhluan_id_phan_hoi','=',0)->where('binhluan_trang_thai',1)
        ->where('binhluan_diem_danh_gia','>=',4)->get();
        foreach($comment_customer as $key=>$comment){
            $pro_rate_id[]=$comment->sanpham_id;
        }
        if($pro_rate_id){
            $all_product_rate=Product::where('sanpham_trang_thai',1)->whereIn('id',$pro_rate_id)->get();
        }else{
            $all_product_rate=Product::where('sanpham_trang_thai',1)->get();
        }
        foreach($all_product_in_stock as $key =>$in_stock){
            $product_id[]=$in_stock->sanpham_id;
        }
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->get();//lay sp dc km
                foreach ($product_discount as $k => $v) {
                    $pro_dis[]=$v->sanpham_id;//id sp km
                }
            }
            $all_product=Product::whereIn('id',$product_id)->where('thuonghieu_id',$product_brand_id)->whereNotIn('id',$pro_dis)
            ->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
        }else{
            $all_product=Product::whereIn('id',$product_id)->where('thuonghieu_id',$product_brand_id)
            ->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_size=Size::where('size_trang_thai',1)->orderby('size_thu_tu','ASC')->get();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $brand=Brand::find($product_brand_id);
        Session::put('pages_name','Brand'.'<li><i class="fa fa-angle-right"></i></li>'.'<li>'.$brand->thuonghieu_ten.'</li>');
    	return view('client.pages.products.product')
        ->with('all_product_rate',$all_product_rate)
        ->with('comment_customer',$comment_customer)
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('all_size',$all_size)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    public function MenuShowProductCollection($product_collection_id){
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
        $comment_customer=Comment::where('binhluan_id_phan_hoi','=',0)->where('binhluan_trang_thai',1)
        ->where('binhluan_diem_danh_gia','>=',4)->get();
        foreach($comment_customer as $key=>$comment){
            $pro_rate_id[]=$comment->sanpham_id;
        }
        if($pro_rate_id){
            $all_product_rate=Product::where('sanpham_trang_thai',1)->whereIn('id',$pro_rate_id)->get();
        }else{
            $all_product_rate=Product::where('sanpham_trang_thai',1)->get();
        }
        foreach($all_product_in_stock as $key =>$in_stock){
            $product_id[]=$in_stock->sanpham_id;
        }
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->get();//lay sp dc km
                foreach ($product_discount as $k => $v) {
                    $pro_dis[]=$v->sanpham_id;//id sp km
                }
            }
            $all_product=Product::whereIn('id',$product_id)->where('dongsanpham_id',$product_collection_id)->whereNotIn('id',$pro_dis)
            ->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
        }else{
            $all_product=Product::whereIn('id',$product_id)->where('dongsanpham_id',$product_collection_id)
            ->where('sanpham_trang_thai','1')->orderBy('id','DESC')->paginate(9);
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_size=Size::where('size_trang_thai',1)->orderby('size_thu_tu','ASC')->get();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $collection=Collection::find($product_collection_id);
        Session::put('pages_name','Collection'.'<li><i class="fa fa-angle-right"></i></li>'.'<li>'.$collection->dongsanpham_ten.'</li>');

    	return view('client.pages.products.product')
        ->with('all_product_rate',$all_product_rate)
        ->with('comment_customer',$comment_customer)
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('all_size',$all_size)
        ->with('header_min',$thu_tu_header);
    }

    public function ProductDetail($product_id){
        $comment_customer=Comment::where('sanpham_id',$product_id)->where('binhluan_id_phan_hoi','=',0)->where('binhluan_trang_thai',1)->get();
        $comment_admin=Comment::with('Product')->where('binhluan_id_phan_hoi','>',0)->get();
        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        if($discount->count()>0){
            foreach($discount as $key => $value){
                $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->where('sanpham_id',$product_id)->first();//lay sp dc km
            }
        }else{
            $product_discount=null;
        }
        $all_product_image=ProductImage::where('sanpham_id',$product_id)->orderby('id','DESC')->get();
        $get_product=Product::find($product_id);
        // $all_product=Product::where('sanpham_trang_thai','1')->get();
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
        foreach($all_product_in_stock as $key =>$in_stock){
            $pro_id[]=$in_stock->sanpham_id;
        }
        $all_product=Product::whereIn('id',$pro_id)
        ->where('sanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_size=ProductInStock::select('size_id')->where('sanpham_id',$product_id)->where('sanphamtonkho_so_luong_ton','>',0)->get();
        $get_in_stock=ProductInStock::where('sanpham_id',$product_id)->get();
        $all_product_type=ProductType::orderby('id','desc')->get();
        $all_brand=Brand::orderby('id','desc')->get();
        $all_collection=Collection::orderby('id','desc')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $product_type_id= $get_product->loaisanpham_id;
        $related_product=Product::where('id',$pro_id)
        ->where('loaisanpham_id',$product_type_id)
        ->where('sanpham_trang_thai','1')
        ->whereNotIn('tbl_sanpham.id',[$product_id])->get();
    	return view('client.pages.products.product_detail')
        ->with('product',$get_product)
        ->with('all_size',$all_size)
        ->with('product_discount',$product_discount)
        ->with('get_in_stock',$get_in_stock)
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('related_product',$related_product)
        ->with('header_show',$all_header)
        ->with('comment_customer',$comment_customer)
        ->with('all_product_image',$all_product_image)
        ->with('comment_admin',$comment_admin)
        ->with('header_min',$thu_tu_header);
    }

    public function OrderTracking(){
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
    	return view('client.pages.order_tracking.order_tracking')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function GetRequestOrderTracking(Request $request){
        $data=$request->all();
        $now=time();
        $order_tracking=Session::get('order_tracking');
        if($order_tracking || $data){
            Session::put('order_tracking',$data['order_tracking']);
            Session::put('order_tracking_time',$now + 180);
            return Redirect::to('/show-order-tracking');
        }else{
            return Redirect::to('/order-tracking');
        }
    }
    public function ShowOrderTracking(){
        $now=time();
        $data=Session::get('order_tracking');
        $time_order_tracking=Session::get('order_tracking_time');
        if(!$data || !$time_order_tracking || $time_order_tracking < $now){
            Session::forget('order_tracking');
            Session::forget('order_tracking_time');
            return Redirect::to('/order-tracking')->with('error','Enter your order code or email to check your order');
        }else{
            $order=Order::where('dondathang_ma_don_dat_hang',$data)->orderBy('id','DESC')->first();
            $order_delivery = Delivery::where('giaohang_nguoi_nhan_email',$data)->orderBy('id','DESC')->get();
            $order_user=Customer::where('khachhang_email',$data)->first();
            if(!$order && $order_delivery->count()<=0 && !$order_user){
                return Redirect::to('/order-tracking')->with('error','Not Found');
            }elseif($order){
                $get_order=Order::where('dondathang_ma_don_dat_hang',$data)->orderBy('id','DESC')->get();
            }elseif($order_user && $order_delivery->count()>0){
                foreach($order_delivery as $key =>$value){
                    $order_id[]=$value->giaohang_ma_don_dat_hang;
                }
                $order_cus_id=Order::where('khachhang_id',$order_user->id)->orderBy('id','DESC')->get();
                foreach($order_cus_id as $k =>$v){
                    $cus_id[]=$v->id;
                }
                $get_order=Order::whereIn('dondathang_ma_don_dat_hang',$order_id)->orderBy('id','DESC')->get();
                $get_order=Order::whereIn('id',$cus_id)->orderBy('id','DESC')->get();
            }elseif($order_delivery->count()>0 && !$order_user){
                foreach($order_delivery as $key =>$value){
                    $order_id[]=$value->giaohang_ma_don_dat_hang;
                }
                $get_order=Order::whereIn('dondathang_ma_don_dat_hang',$order_id)->orderBy('id','DESC')->get();
            }elseif($order_delivery->count()<=0 && $order_user){
                $get_order=Order::where('khachhang_id',$order_user->id)->orderBy('id','DESC')->get();
            }else{
                $get_order=null;
            }
            if($get_order==null){
                return Redirect::to('/order-tracking')->with('error','Enter your order code or email to check your order');
            }
            foreach($get_order as $key=>$value){
                $customer_order_detail=OrderDetail::where('chitietdondathang_ma_don_dat_hang',$value->dondathang_ma_don_dat_hang)->get();
                $customer_order_delivery=Delivery::where('giaohang_ma_don_dat_hang',$value->dondathang_ma_don_dat_hang)->first();
                $customer_order_delivery_update=Delivery::find($customer_order_delivery->id);
                $customer_order_delivery_update->dondathang_id=$value->id;
                $customer_order_delivery_update->save();
                foreach($customer_order_detail as $k=>$v){
                    if($value->dondathang_ma_don_dat_hang==$v->chitietdondathang_ma_don_dat_hang){
                        $customer_order_detail_update=OrderDetail::find($v->id);
                        $customer_order_detail_update->dondathang_id=$value->id;
                        $customer_order_detail_update->save();
                    }
                }
            }
            $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
            $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
            $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
            $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
            $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
            ->orderby('headerquangcao_thu_tu','ASC')->get();
            foreach($all_header as $key=>$value){
                $thu_tu_header=$value->headerquangcao_thu_tu;
                break;
            }
            return view('client.pages.order_tracking.show_order_tracking')
            ->with('product_type',$all_product_type)
            ->with('product_brand',$all_brand)
            ->with('get_about_us_bottom',$get_about_us_bottom)
            ->with('product_collection',$all_collection)
            ->with('header_show',$all_header)
            ->with('get_order',$get_order)
            ->with('header_min',$thu_tu_header);
        }
    }

    public function ShowOrderTrackingDetail($order_id){
        $get_all_order_detail=OrderDetail::where('dondathang_id',$order_id)->get();
        $customer_order=Order::find($order_id);
        $customer_delivery=Delivery::where('giaohang_ma_don_dat_hang',$customer_order->dondathang_ma_don_dat_hang)->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        return view('client.pages.order_tracking.show_order_tracking_detail')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('header_min',$thu_tu_header)
        ->with('customer_order',$customer_order)
        ->with('all_order_detail',$get_all_order_detail)
        ->with('customer_delivery',$customer_delivery);
    }
}
