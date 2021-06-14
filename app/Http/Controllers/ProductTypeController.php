<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductTypeController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_product_type=DB::table('tbl_loaisanpham')->get();
        $manager_product_type =view('admin.pages.product_type.product_type')->with('all_product_type',$all_product_type);
    	return view('admin.index_layout_admin')->with('admin.pages.product_type.product_type',$manager_product_type);
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
        $data =array();
        $data['loaisanpham_ten']=$request->product_type_name;
        $data['loaisanpham_mo_ta']=$request->product_type_description;
        $data['loaisanpham_anh']=$request->product_type_img;
        $data['loaisanpham_trang_thai']=$request->product_type_status;

        $get_image = $request->file('product_type_img');
        $path = 'public/uploads/admin/producttype';

        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $data['loaisanpham_anh'] = $new_image;
            DB::table('tbl_loaisanpham')->insert($data);
            Session::put('message','Add Success');
    	    return Redirect::to('/product-type');
        }
        $data['loaisanpham_anh'] = '';
        DB::table('tbl_loaisanpham')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/product-type');
    }

    public function UnactiveProductType($pro_type_id){
        $this->AuthLogin();
        DB::table('tbl_loaisanpham')->where('id',$pro_type_id)->update(['loaisanpham_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/product-type');
    }
    public function ActiveProductType($pro_type_id){
        $this->AuthLogin();
        DB::table('tbl_loaisanpham')->where('id',$pro_type_id)->update(['loaisanpham_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/product-type');
    }

    public function ProductTypeEdit($pro_type_id){
        $this->AuthLogin();
        $edit_product_type=DB::table('tbl_loaisanpham')->where('id',$pro_type_id)->get();
        $manager_product_type =view('admin.pages.product_type.product_type_edit')->with('edit_product_type',$edit_product_type);
    	return view('admin.index_layout_admin')->with('admin.pages.product_type.product_type_edit',$manager_product_type);
    }

    public function ProductTypeSaveEdit(Request $request,$pro_type_id){
        $this->AuthLogin();
       $data=array();

       $data['loaisanpham_ten']=$request->product_type_name;
        $data['loaisanpham_mo_ta']=$request->product_type_description;
        $data['loaisanpham_anh']=$request->product_type_img;
        $data['loaisanpham_trang_thai']=$request->product_type_status;

        $old_name=DB::table('tbl_loaisanpham')->select('loaisanpham_anh')->where('id',$pro_type_id)->get();

       $get_image = $request->file('product_type_img');
       $path = 'public/uploads/admin/producttype/';
       if($get_image){
                    unlink($path.$old_name[0]->loaisanpham_anh);
                   $get_name_image = $get_image->getClientOriginalName();
                   $name_image = current(explode('.',$get_name_image));
                   $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                   $get_image->move($path,$new_image);
                   $data['loaisanpham_anh'] = $new_image;
                   DB::table('tbl_loaisanpham')->where('id',$pro_type_id)->update($data);
                   Session::put('message','Update Success');
                   return Redirect::to('/product-type');
       }
        $data['loaisanpham_anh'] = $old_name[0]->loaisanpham_anh;
        DB::table('tbl_loaisanpham')->where('id',$pro_type_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/product-type');

    }
}
