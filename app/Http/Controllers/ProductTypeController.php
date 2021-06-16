<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\models\ProductType;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductTypeController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        // $all_product_type=DB::table('tbl_loaisanpham')->get();
        $all_product_type=ProductType::orderBy('id','DESC')->get();
        return view('admin.pages.product_type.product_type')->with('all_product_type',$all_product_type);
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function ProductTypeAdd(){
        $this->AuthLogin();
    	return view('admin.pages.product_type.product_type_add');
    }

    public function ProductTypeSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $producttype=new ProductType();
        $producttype->loaisanpham_ten = $data['product_type_name'];
        $producttype->loaisanpham_mo_ta = $data['product_type_description'];
        $producttype->loaisanpham_trang_thai = $data['product_type_status'];
        $get_image = $request->file('product_type_img');
        $path = 'public/uploads/admin/producttype';
        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $producttype->loaisanpham_anh = $new_image;
            $producttype->save();
            Session::put('message','Add Success');
    	    return Redirect::to('/product-type');
        }
        $producttype->loaisanpham_anh = '';
        $producttype->save();
        Session::put('message','Add Success');
    	return Redirect::to('/product-type');
    }

    public function UnactiveProductType($pro_type_id){
        $this->AuthLogin();
        $unactive_product_type=ProductType::find($pro_type_id);
        $unactive_product_type->loaisanpham_trang_thai=0;
        $unactive_product_type->save();
        Session::put('message','Hide Success');
        return Redirect::to('/product-type');
    }
    public function ActiveProductType($pro_type_id){
        $this->AuthLogin();
        $active_product_type=ProductType::find($pro_type_id);
        $active_product_type->loaisanpham_trang_thai=1;
        $active_product_type->save();
        Session::put('message','Show Success');
        return Redirect::to('/product-type');
    }

    public function ProductTypeEdit($pro_type_id){
        $this->AuthLogin();
        $edit_product_type=ProductType::find($pro_type_id);
        return view('admin.pages.product_type.product_type_edit')->with('product_type',$edit_product_type);
    }

    public function ProductTypeSaveEdit(Request $request,$pro_type_id){
        $this->AuthLogin();
        $data=$request->all();
        $producttype=ProductType::find($pro_type_id);
        $producttype->loaisanpham_ten = $data['product_type_name'];
        $producttype->loaisanpham_mo_ta = $data['product_type_description'];
        $producttype->loaisanpham_trang_thai = $data['product_type_status'];
        $old_name_img=$producttype->loaisanpham_anh;
        $get_image = $request->file('product_type_img');
        $path = 'public/uploads/admin/producttype/';
        if($get_image){
            unlink($path.$old_name_img);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $producttype->loaisanpham_anh = $new_image;
            $producttype->save();
            Session::put('message','Update Success');
            return Redirect::to('/product-type');
        }
        $producttype->loaisanpham_anh = $old_name_img;
        $producttype->save();
        Session::put('message','Update Success');
        return Redirect::to('/product-type');

    }
}
