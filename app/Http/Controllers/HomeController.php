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
use App\Models\ProductImportDetail;
use App\Models\ProductImage;
use App\Models\ProductDiscount;
use App\Models\Discount;
use App\Models\HeaderShow;
use App\Models\SlideShow;
use Illuminate\Support\Facades\Redirect;
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
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header)
        ->with('slide_show',$all_slide);
    }

    public function MenuShowProductDiscount(){

        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        $discount_ends=Discount::where('khuyenmai_trang_thai',0)->get();//lay tin km
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
            foreach($discount_ends as $end => $no_dis){
                $product_discount=ProductDiscount::where('khuyenmai_id',$no_dis->id)->get();//lay sp dc km
                foreach ($product_discount as $ke => $val) {
                    $pro_no_dis[]=$val->sanpham_id;//id sp km
                }
            }
            $product_import_in_stock=ProductInstock::whereIn('sanpham_id',$pro_no_dis)->get();//lay sp km trong kho
            $all_product=Product::whereIn('id',$pro_no_dis)->paginate(9);//lay sp km
        }

        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.products.product')
		->with('all_product_discount', $product_discount)
        ->with('all_product', $all_product)
        ->with('product_import_in_stock', $product_import_in_stock)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function MenuShowProductNow(){
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
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
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        Session::put('pages_name','Shop Now');
    	return view('client.pages.products.product')
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function MenuShowProductType($product_type_id){
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
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
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    public function MenuShowProducBrand($product_brand_id){
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
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
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    public function MenuShowProductCollection($product_collection_id){
        $all_product_in_stock=ProductInStock::where('sanphamtonkho_so_luong_ton','>',0)->orderby('id','DESC')->get();
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
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function ProductDetail($product_id){

        $discount=Discount::where('khuyenmai_trang_thai',1)->get();//lay tin km
        foreach($discount as $key => $value){
            $product_discount=ProductDiscount::where('khuyenmai_id',$value->id)->where('sanpham_id',$product_id)->first();//lay sp dc km
        }

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
        ->with('related_product',$related_product)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }


}
