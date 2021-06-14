<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function Index(){

        $all_product=DB::table('tbl_sanpham')->where('sanpham_trang_thai','1')->orderby('id','desc')->limit(10)->get();
        $all_product_type=DB::table('tbl_loaisanpham')->where('loaisanpham_trang_thai','1')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->where('thuonghieu_trang_thai','1')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->where('dongsanpham_trang_thai','1')->orderby('id','desc')->get();

        $all_header=DB::table('tbl_headerquangcao')->where('headerquangcao_trang_thai','1')->get();
        $hearder_asc=DB::table('tbl_headerquangcao')->select('headerquangcao_thu_tu')
        ->where('headerquangcao_trang_thai','1')->orderby('headerquangcao_thu_tu','asc')->first();

        foreach($hearder_asc as $key=>$value){
            $thu_tu_header=$value;
        }

        $all_slide=DB::table('tbl_slidequangcao')->where('slidequangcao_trang_thai','1')->get();
        $slide_asc=DB::table('tbl_slidequangcao')->select('slidequangcao_thu_tu')
        ->where('slidequangcao_trang_thai','1')->orderby('slidequangcao_thu_tu','asc')->first();

        foreach($slide_asc as $key=>$value){
            $thu_tu_slide=$value;
        }

    	return view('client.pages.index_home')
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header)
        ->with('slide_show',$all_slide)
        ->with('slide_min',$thu_tu_slide);
    }

    public function MenuShowProductNow(){
        $all_product=DB::table('tbl_sanpham')->where('sanpham_trang_thai','1')->orderby('id','desc')->limit(10)->get();
        $all_product_type=DB::table('tbl_loaisanpham')->where('loaisanpham_trang_thai','1')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->where('thuonghieu_trang_thai','1')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->where('dongsanpham_trang_thai','1')->orderby('id','desc')->get();

        $all_header=DB::table('tbl_headerquangcao')->where('headerquangcao_trang_thai','1')->get();
        $hearder_asc=DB::table('tbl_headerquangcao')->select('headerquangcao_thu_tu')
        ->where('headerquangcao_trang_thai','1')->orderby('headerquangcao_thu_tu','asc')->first();

        foreach($hearder_asc as $key=>$value){
            $thu_tu=$value;
        }
        Session::put('pages_name','Shop Now');
    	return view('client.pages.products.product')
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu);
    }

    public function MenuShowProductType($product_type_id){
        $all_product=DB::table('tbl_sanpham')->where('sanpham_trang_thai','1')->where('loaisanpham_id',$product_type_id)->orderby('id','desc')->limit(10)->get();
        $all_product_type=DB::table('tbl_loaisanpham')->where('loaisanpham_trang_thai','1')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->where('thuonghieu_trang_thai','1')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->where('dongsanpham_trang_thai','1')->orderby('id','desc')->get();

        $all_header=DB::table('tbl_headerquangcao')->where('headerquangcao_trang_thai','1')->get();
        $hearder_asc=DB::table('tbl_headerquangcao')->select('headerquangcao_thu_tu')
        ->where('headerquangcao_trang_thai','1')->orderby('headerquangcao_thu_tu','asc')->first();

        foreach($hearder_asc as $key=>$value){
            $thu_tu=$value;
        }
        $name=DB::table('tbl_loaisanpham')->where('id',$product_type_id)->select('loaisanpham_ten')->get();
        Session::put('pages_name','Category'.'<li><i class="fa fa-angle-right"></i></li>'.'<li>'.$name[0]->loaisanpham_ten.'</li>');

    	return view('client.pages.products.product')
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu);
    }
    public function MenuShowProducBrand($product_brand_id){
        $all_product=DB::table('tbl_sanpham')->where('sanpham_trang_thai','1')->where('thuonghieu_id',$product_brand_id)->orderby('id','desc')->limit(10)->get();
        $all_product_type=DB::table('tbl_loaisanpham')->where('loaisanpham_trang_thai','1')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->where('thuonghieu_trang_thai','1')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->where('dongsanpham_trang_thai','1')->orderby('id','desc')->get();

        $all_header=DB::table('tbl_headerquangcao')->where('headerquangcao_trang_thai','1')->get();
        $hearder_asc=DB::table('tbl_headerquangcao')->select('headerquangcao_thu_tu')
        ->where('headerquangcao_trang_thai','1')->orderby('headerquangcao_thu_tu','asc')->first();

        foreach($hearder_asc as $key=>$value){
            $thu_tu=$value;
        }
        $name=DB::table('tbl_thuonghieu')->where('id',$product_brand_id)->select('thuonghieu_ten')->get();
        Session::put('pages_name','Brand'.'<li><i class="fa fa-angle-right"></i></li>'.'<li>'.$name[0]->thuonghieu_ten.'</li>');

    	return view('client.pages.products.product')
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu);
    }
    public function MenuShowProductCollection($product_collection_id){
        $all_product=DB::table('tbl_sanpham')->where('sanpham_trang_thai','1')->where('dongsanpham_id',$product_collection_id)->orderby('id','desc')->limit(10)->get();
        $all_product_type=DB::table('tbl_loaisanpham')->where('loaisanpham_trang_thai','1')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->where('thuonghieu_trang_thai','1')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->where('dongsanpham_trang_thai','1')->orderby('id','desc')->get();

        $all_header=DB::table('tbl_headerquangcao')->where('headerquangcao_trang_thai','1')->get();
        $hearder_asc=DB::table('tbl_headerquangcao')->select('headerquangcao_thu_tu')
        ->where('headerquangcao_trang_thai','1')->orderby('headerquangcao_thu_tu','asc')->first();

        foreach($hearder_asc as $key=>$value){
            $thu_tu=$value;
        }
        $name=DB::table('tbl_dongsanpham')->where('id',$product_collection_id)->select('dongsanpham_ten')->get();
        Session::put('pages_name','Collection'.'<li><i class="fa fa-angle-right"></i></li>'.'<li>'.$name[0]->dongsanpham_ten.'</li>');

    	return view('client.pages.products.product')
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu);
    }

}
