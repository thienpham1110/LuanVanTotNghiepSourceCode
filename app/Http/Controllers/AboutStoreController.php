<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();


class AboutStoreController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_about_store=DB::table('tbl_cuahang')->get();
        $manager_about_store =view('admin.pages.aboutstore.about_store')->with('all_about_store',$all_about_store);
    	return view('admin.index_layout_admin')->with('admin.pages.aboutstore.about_store',$manager_about_store);
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
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
    	return view('admin.pages.aboutstore.about_store_add')->with('staff',$staff);
    }

    public function AboutStoreSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['cuahang_tieu_de']=$request->about_store_title;
        $data['cuahang_mo_ta']=$request->about_store_description;
        $data['cuahang_dia_chi']=$request->about_store_address;
        $data['cuahang_so_dien_thoai']=$request->about_store_phone_number;
        $data['cuahang_trang_thai']=$request->about_store_status;
        $data['nhanvien_id']=$request->staff_id;

        $get_image = $request->file('about_store_img');
        $path = 'public/uploads/admin/aboutstore';

        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);

            $data['cuahang_anh'] = $new_image;
            DB::table('tbl_cuahang')->insert($data);
            Session::put('message','Add Success');
    	    return Redirect::to('/about-store');
        }
        $data['cuahang_anh'] = '';

        DB::table('tbl_cuahang')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/about-store');
    }

    public function UnactiveAboutStore($about_store_id){
        $this->AuthLogin();
        DB::table('tbl_cuahang')->where('id',$about_store_id)->update(['cuahang_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/about-store');
    }
    public function ActiveAboutStore($about_store_id){
        $this->AuthLogin();
        DB::table('tbl_cuahang')->where('id',$about_store_id)->update(['cuahang_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/about-store');
    }

    public function AboutStoreEdit($about_store_id){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
        $edit_about_store=DB::table('tbl_cuahang')->where('id',$about_store_id)->get();
        $manager_about_store =view('admin.pages.aboutstore.about_store_edit')
        ->with('edit_about_store',$edit_about_store)
        ->with('staff',$staff);
    	return view('admin.index_layout_admin')->with('admin.pages.aboutstore.about_store_edit',$manager_about_store);
    }

    public function AboutStoreSaveEdit(Request $request,$about_store_id){
        $this->AuthLogin();
        $data =array();
        $data['cuahang_tieu_de']=$request->about_store_title;
        $data['cuahang_mo_ta']=$request->about_store_description;
        $data['cuahang_dia_chi']=$request->about_store_address;
        $data['cuahang_so_dien_thoai']=$request->about_store_phone_number;
        $data['cuahang_trang_thai']=$request->about_store_status;
        $data['nhanvien_id']=$request->staff_id;

        $old_name=DB::table('tbl_cuahang')->select('cuahang_anh')->where('id',$about_store_id)->get();

        $get_image = $request->file('about_store_img');
        $path = 'public/uploads/admin/aboutstore/';
       if($get_image){
                    unlink($path.$old_name[0]->cuahang_anh);
                   $get_name_image = $get_image->getClientOriginalName();
                   $name_image = current(explode('.',$get_name_image));
                   $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                   $get_image->move($path,$new_image);
                   $data['cuahang_anh'] = $new_image;
                   DB::table('tbl_cuahang')->where('id',$about_store_id)->update($data);
                   Session::put('message','Update Success');
                   return Redirect::to('/about-store');
       }
        $data['cuahang_anh'] = $old_name[0]->cuahang_anh;
        DB::table('tbl_cuahang')->where('id',$about_store_id)->update($data);
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
