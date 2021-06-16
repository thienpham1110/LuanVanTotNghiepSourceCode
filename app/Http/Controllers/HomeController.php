<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\ProductType;
use App\Models\HeaderShow;
use App\Models\SlideShow;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function Index(){
        $all_product=Product::where('sanpham_trang_thai','1')->orderBy('id','DESC')->get();
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
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header)
        ->with('slide_show',$all_slide);
    }

    public function MenuShowProductNow(){
        $all_product=Product::where('sanpham_trang_thai','1')->orderBy('id','DESC')->get();
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
        $all_product=Product::where('sanpham_trang_thai','1')->where('loaisanpham_id',$product_type_id)->orderBy('id','DESC')->get();
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
        $all_product=Product::where('sanpham_trang_thai','1')->where('thuonghieu_id',$product_brand_id)->orderBy('id','DESC')->get();
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
        $all_product=Product::where('sanpham_trang_thai','1')->where('dongsanpham_id',$product_collection_id)->orderBy('id','DESC')->get();
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

}
