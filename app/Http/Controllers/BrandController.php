<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use App\Models\Brand;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_brand = Brand::orderBy('id','DESC')->paginate(5);
        // $all_brand = Brand::orderBy('id','DESC')->get();
        return view('admin.pages.brand.brand')->with('all_brand',$all_brand);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function BrandAdd(){
        $this->AuthLogin();
    	return view('admin.pages.brand.brand_add');
    }

    public function BrandSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $brand=new Brand();
        $brand->thuonghieu_ten = $data['brand_name'];
        $brand->thuonghieu_mo_ta = $data['brand_description'];
        $brand->thuonghieu_trang_thai = $data['brand_status'];
        $get_image = $request->file('brand_img');
        $path = 'public/uploads/admin/brand';
        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $brand->thuonghieu_anh = $new_image;
            $brand->save();
            Session::put('message','Add Success');
    	    return Redirect::to('/brand');
        }
        $brand->thuonghieu_anh = '';
        $brand->save();
        Session::put('message','Add Success');
    	return Redirect::to('/brand');
    }

    public function UnactiveBrand($brand_id){
        $this->AuthLogin();
        $unactive_brand=Brand::find($brand_id);
        $unactive_brand->thuonghieu_trang_thai=0;
        $unactive_brand->save();
        Session::put('message','Hide Success');
        return Redirect::to('/brand');
    }
    public function ActiveBrand($brand_id){
        $this->AuthLogin();
        $active_brand=Brand::find($brand_id);
        $active_brand->thuonghieu_trang_thai=1;
        $active_brand->save();
        Session::put('message','Show Success');
        return Redirect::to('/brand');
    }

    public function BrandEdit($brand_id){
        $this->AuthLogin();
        $edit_brand=Brand::find($brand_id);
        return view('admin.pages.brand.brand_edit')->with('brand',$edit_brand);
    }

    public function BrandSaveEdit(Request $request,$brand_id){
        $this->AuthLogin();
        $data=$request->all();
        $brand= Brand::find($brand_id);
        $brand->thuonghieu_ten = $data['brand_name'];
        $brand->thuonghieu_mo_ta = $data['brand_description'];
        $brand->thuonghieu_trang_thai = $data['brand_status'];
        $old_name_img=$brand->thuonghieu_anh;
        $get_image = $request->file('brand_img');
        $path = 'public/uploads/admin/brand/';
        if($get_image){
            unlink($path.$old_name_img);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $brand->thuonghieu_anh  = $new_image;
            $brand->save();
            Session::put('message','Update Success');
            return Redirect::to('/brand');
        }
        $brand->thuonghieu_anh = $old_name_img;
        $brand->save();
        Session::put('message','Update Success');
        return Redirect::to('/brand');
    }
}
