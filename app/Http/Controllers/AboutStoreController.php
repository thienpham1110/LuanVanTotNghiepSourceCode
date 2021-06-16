<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use App\models\AboutStore;
use Illuminate\Support\Facades\Redirect;
session_start();


class AboutStoreController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_about_store=AboutStore::all();
        return view('admin.pages.aboutstore.about_store')->with('all_about_store',$all_about_store);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function AboutStoreAdd(){
        $this->AuthLogin();
    	return view('admin.pages.aboutstore.about_store_add');
    }

    public function AboutStoreSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $aboutstore=new AboutStore();
        $aboutstore->cuahang_tieu_de = $data['about_store_title'];
        $aboutstore->cuahang_mo_ta = $data['about_store_description'];
        $aboutstore->cuahang_dia_chi = $data['about_store_address'];
        $aboutstore->cuahang_so_dien_thoai = $data['about_store_phone_number'];
        $aboutstore->cuahang_trang_thai = $data['about_store_status'];
        $get_image = $request->file('about_store_img');
        $path = 'public/uploads/admin/aboutstore';
        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $aboutstore->cuahang_anh = $new_image;
            $aboutstore->savs();
            Session::put('message','Add Success');
    	    return Redirect::to('/about-store');
        }
        $aboutstore->cuahang_anh = '';
        $aboutstore->savs();
        Session::put('message','Add Success');
    	return Redirect::to('/about-store');
    }

    public function UnactiveAboutStore($about_store_id){
        $this->AuthLogin();
        $unactive_about_store=AboutStore::find($about_store_id);
        $unactive_about_store->cuahang_trang_thai=0;
        $unactive_about_store->save();
        Session::put('message','Hide Success');
        return Redirect::to('/about-store');
    }
    public function ActiveAboutStore($about_store_id){
        $this->AuthLogin();
        $active_about_store=AboutStore::find($about_store_id);
        $active_about_store->cuahang_trang_thai=1;
        $active_about_store->save();
        Session::put('message','Show Success');
        return Redirect::to('/about-store');
    }

    public function AboutStoreEdit($about_store_id){
        $this->AuthLogin();
        $edit_about_store=AboutStore::find($about_store_id);
        return view('admin.pages.aboutstore.about_store_edit')
        ->with('about_store',$edit_about_store);
    }

    public function AboutStoreSaveEdit(Request $request,$about_store_id){
        $this->AuthLogin();
        $data=$request->all();
        $aboutstore=AboutStore::find($about_store_id);
        $aboutstore->cuahang_tieu_de = $data['about_store_title'];
        $aboutstore->cuahang_mo_ta = $data['about_store_description'];
        $aboutstore->cuahang_dia_chi = $data['about_store_address'];
        $aboutstore->cuahang_so_dien_thoai = $data['about_store_phone_number'];
        $aboutstore->cuahang_trang_thai = $data['about_store_status'];
        $old_name=$aboutstore->cuahang_anh;
        $get_image = $request->file('about_store_img');
        $path = 'public/uploads/admin/aboutstore/';
        if($get_image){
            unlink($path.$old_name);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $aboutstore->cuahang_anh= $new_image;
            $aboutstore->save();
            Session::put('message','Update Success');
            return Redirect::to('/about-store');
        }
        $aboutstore->cuahang_anh = $old_name;
        $aboutstore->save();
        Session::put('message','Update Success');
        return Redirect::to('/about-store');
    }
    public function AboutStoreDelete($about_store_id){
        $this->AuthLogin();
        DB::table('tbl_cuahang')->where('id',$about_store_id)->delete();
        Session::put('message','Delete Success');
        return Redirect::to('/aboutstore');
    }
}
