<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\HeaderShow;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_product=Product::orderby('id','desc')->get();
        return view('admin.pages.products.product')
        ->with('all_product',$all_product);
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }

    public function ProductAdd(){
        $this->AuthLogin();
        $all_product_type=ProductType::orderby('id','desc')->get();
        $all_brand=Brand::orderby('id','desc')->get();
        $all_collection=Collection::orderby('id','desc')->get();
    	return view('admin.pages.products.product_add')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection);
    }

    public function ProductSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $product= new Product();
        $product->sanpham_ma_san_pham = $data['product_code'];
        $product->sanpham_ten = $data['product_name'];
        $product->sanpham_mo_ta = $data['product_description'];
        $product->sanpham_nguoi_su_dung = $data['product_gender'];
        $product->sanpham_mau_sac = $data['product_color'];
        $product->sanpham_tinh_nang = $data['product_feature'];
        $product->sanpham_noi_san_xuat = $data['product_production'];
        $product->sanpham_phu_kien = $data['product_accessories'];
        $product->sanpham_chat_lieu = $data['product_material'];
        $product->sanpham_bao_hanh = $data['product_guarantee'];
        $product->sanpham_khuyen_mai = $data['product_discount'];
        $product->sanpham_trang_thai = $data['product_status'];
        $product->loaisanpham_id = $data['product_type'];
        $product->thuonghieu_id = $data['brand'];
        $product->dongsanpham_id = $data['collection'];

        $get_image = $request->file('product_img');
        $path = 'public/uploads/admin/product';
        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $product->sanpham_anh = $new_image;
            $product->save();
            Session::put('message','Add Success');
    	    return Redirect::to('/product');
        }
        $product->sanpham_anh = '';
        $product->save();
        Session::put('message','Add Success');
    	return Redirect::to('/product');
    }

    public function UnactiveProduct($product_id){
        $this->AuthLogin();
        $unactive_product=Product::find($product_id);
        $unactive_product->sanpham_trang_thai=0;
        $unactive_product->save();
        Session::put('message','Hide Success');
        return Redirect::to('/product');
    }
    public function ActiveProduct($product_id){
        $this->AuthLogin();
        $active_product=Product::find($product_id);
        $active_product->sanpham_trang_thai=1;
        $active_product->save();
        Session::put('message','Show Success');
        return Redirect::to('/product');
    }

    public function ProductEdit($product_id){
        $this->AuthLogin();
        $edit_product=Product::find($product_id);
        $all_product_type=ProductType::orderby('id','desc')->get();
        $all_brand=Brand::orderby('id','desc')->get();
        $all_collection=Collection::orderby('id','desc')->get();
        $manager_product =view('admin.pages.products.product_edit')
        ->with('product',$edit_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection);
    	return view('admin.index_layout_admin')
        ->with('admin.pages.products.product_edit',$manager_product);
    }

    public function ProductSaveEdit(Request $request,$product_id){
        $this->AuthLogin();
        $data=$request->all();
        $product= Product::find($product_id);
        $product->sanpham_ma_san_pham = $data['product_code'];
        $product->sanpham_ten = $data['product_name'];
        $product->sanpham_mo_ta = $data['product_description'];
        $product->sanpham_nguoi_su_dung = $data['product_gender'];
        $product->sanpham_mau_sac = $data['product_color'];
        $product->sanpham_tinh_nang = $data['product_feature'];
        $product->sanpham_noi_san_xuat = $data['product_production'];
        $product->sanpham_phu_kien = $data['product_accessories'];
        $product->sanpham_chat_lieu = $data['product_material'];
        $product->sanpham_bao_hanh = $data['product_guarantee'];
        $product->sanpham_khuyen_mai = $data['product_discount'];
        $product->sanpham_trang_thai = $data['product_status'];
        $product->loaisanpham_id = $data['product_type'];
        $product->thuonghieu_id = $data['brand'];
        $product->dongsanpham_id = $data['collection'];
        $old_name=$product->sanpham_anh;
        $get_image = $request->file('product_img');
        $path = 'public/uploads/admin/product/';
        if($get_image){
            unlink($path.$old_name);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $product->sanpham_anh = $new_image;
            $product->save();
            Session::put('message','Update Success');
            return Redirect::to('/product');
        }
        $product->sanpham_anh = $old_name;
        $product->save();
        Session::put('message','Update Success');
        return Redirect::to('/product');
    }

    public function ProductDetail($product_id){
        $get_product=Product::find($product_id);
        $all_product=Product::where('sanpham_trang_thai','1')->get();
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
        $related_product=Product::where('loaisanpham_id',$product_type_id)
        ->where('sanpham_trang_thai','1')
        ->whereNotIn('tbl_sanpham.id',[$product_id])
        ->get();
    	return view('client.pages.products.product_detail')
        ->with('product',$get_product)
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('related_product',$related_product)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

}
