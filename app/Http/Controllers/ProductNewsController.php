<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();


class ProductNewsController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_productnews=DB::table('tbl_baiviet')->get();
        $manager_productnews =view('admin.pages.productnews.productnews')->with('all_productnews',$all_productnews);
    	return view('admin.index_layout_admin')->with('admin.pages.productnews.productnews',$manager_productnews);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function productnewsAdd(){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
    	return view('admin.pages.productnews.productnews_add')->with('staff',$staff);
    }

    public function productnewsSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['slidequangcao_tieu_de']=$request->productnews_title;
        $data['slidequangcao_noi_dung']=$request->productnews_content;
        $data['slidequangcao_lien_ket']=$request->productnews_link;
        $data['slidequangcao_thu_tu']=$request->productnews_no;
        $data['slidequangcao_trang_thai']=$request->productnews_status;
        $data['nhanvien_id']=$request->staff_id;

        $get_image = $request->file('productnews_img');
        $path = 'public/uploads/admin/productnews';

        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);

            $data['slidequangcao_anh'] = $new_image;
            DB::table('tbl_baiviet')->insert($data);
            Session::put('message','Add Success');
    	    return Redirect::to('/productnews');
        }
        $data['slidequangcao_anh'] = '';

        DB::table('tbl_baiviet')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/productnews');
    }

    public function Unactiveproductnews($productnews_id){
        $this->AuthLogin();
        DB::table('tbl_baiviet')->where('id',$productnews_id)->update(['slidequangcao_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/productnews');
    }
    public function Activeproductnews($productnews_id){
        $this->AuthLogin();
        DB::table('tbl_baiviet')->where('id',$productnews_id)->update(['slidequangcao_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/productnews');
    }

    public function productnewsEdit($productnews_id){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
        $edit_productnews=DB::table('tbl_baiviet')->where('id',$productnews_id)->get();
        $manager_productnews =view('admin.pages.productnews.productnews_edit')
        ->with('edit_productnews',$edit_productnews)
        ->with('staff',$staff);
    	return view('admin.index_layout_admin')->with('admin.pages.productnews.productnews_edit',$manager_productnews);
    }

    public function productnewsSaveEdit(Request $request,$productnews_id){
        $this->AuthLogin();
        $data =array();
        $data['slidequangcao_tieu_de']=$request->productnews_title;
        $data['slidequangcao_noi_dung']=$request->productnews_content;
        $data['slidequangcao_lien_ket']=$request->productnews_link;
        $data['slidequangcao_thu_tu']=$request->productnews_no;
        $data['slidequangcao_trang_thai']=$request->productnews_status;
        $data['nhanvien_id']=$request->staff_id;

        $old_name=DB::table('tbl_baiviet')->select('slidequangcao_anh')->where('id',$productnews_id)->get();

        $get_image = $request->file('productnews_img');
        $path = 'public/uploads/admin/productnews/';
       if($get_image){
                    unlink($path.$old_name[0]->slidequangcao_anh);
                   $get_name_image = $get_image->getClientOriginalName();
                   $name_image = current(explode('.',$get_name_image));
                   $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                   $get_image->move($path,$new_image);
                   $data['slidequangcao_anh'] = $new_image;
                   DB::table('tbl_baiviet')->where('id',$productnews_id)->update($data);
                   Session::put('message','Update Success');
                   return Redirect::to('/productnews');
       }
        $data['slidequangcao_anh'] = $old_name[0]->slidequangcao_anh;
        DB::table('tbl_baiviet')->where('id',$productnews_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/productnews');
    }
    public function productnewsDelete($productnews_id){
        $this->AuthLogin();
        DB::table('tbl_baiviet')->where('id',$productnews_id)->delete();
        Session::put('message','Delete Success');
        return Redirect::to('/productnews');
    }
}
