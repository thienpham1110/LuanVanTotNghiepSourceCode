<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_brand=DB::table('tbl_thuonghieu')->get();
        $manager_brand =view('admin.pages.brand.brand')->with('all_brand',$all_brand);
    	return view('admin.index_layout_admin')->with('admin.pages.brand.brand',$manager_brand);
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
        $data =array();
        $data['thuonghieu_ten']=$request->brand_name;
        $data['thuonghieu_mo_ta']=$request->brand_description;
        $data['thuonghieu_trang_thai']=$request->brand_status;

        $get_image = $request->file('brand_img');
        $path = 'public/uploads/admin/brand';

        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);

            $data['thuonghieu_anh'] = $new_image;
            DB::table('tbl_thuonghieu')->insert($data);
            Session::put('message','Add Success');
    	    return Redirect::to('/brand');
        }
        $data['thuonghieu_anh'] = '';
        DB::table('tbl_thuonghieu')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/brand');
    }

    public function UnactiveBrand($brand_id){
        $this->AuthLogin();
        DB::table('tbl_thuonghieu')->where('id',$brand_id)->update(['thuonghieu_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/brand');
    }
    public function ActiveBrand($brand_id){
        $this->AuthLogin();
        DB::table('tbl_thuonghieu')->where('id',$brand_id)->update(['thuonghieu_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/brand');
    }

    public function BrandEdit($brand_id){
        $this->AuthLogin();
        $edit_brand=DB::table('tbl_thuonghieu')->where('id',$brand_id)->get();
        $manager_brand =view('admin.pages.brand.brand_edit')->with('edit_brand',$edit_brand);
    	return view('admin.index_layout_admin')->with('admin.pages.brand.brand_edit',$manager_brand);
    }

    public function BrandSaveEdit(Request $request,$brand_id){
        $this->AuthLogin();
       $data=array();

       $data['thuonghieu_ten']=$request->brand_name;
       $data['thuonghieu_mo_ta']=$request->brand_description;
       $data['thuonghieu_anh']=$request->brand_img;
       $data['thuonghieu_trang_thai']=$request->brand_status;
       $old_name=DB::table('tbl_thuonghieu')->select('thuonghieu_anh')->where('id',$brand_id)->get();

       $get_image = $request->file('brand_img');
       $path = 'public/uploads/admin/brand/';
       if($get_image){
                    unlink($path.$old_name[0]->thuonghieu_anh);
                   $get_name_image = $get_image->getClientOriginalName();
                   $name_image = current(explode('.',$get_name_image));
                   $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                   $get_image->move($path,$new_image);
                   $data['thuonghieu_anh'] = $new_image;
                   DB::table('tbl_thuonghieu')->where('id',$brand_id)->update($data);
                   Session::put('message','Update Success');
                   return Redirect::to('/brand');
       }
        $data['thuonghieu_anh'] = $old_name[0]->thuonghieu_anh;
        DB::table('tbl_thuonghieu')->where('id',$brand_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/brand');
    }
}
