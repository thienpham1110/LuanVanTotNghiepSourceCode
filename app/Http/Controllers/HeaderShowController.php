<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HeaderShowController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_headershow=DB::table('tbl_headerquangcao')->get();
        $manager_headershow =view('admin.pages.headershow.headershow')->with('all_headershow',$all_headershow);
    	return view('admin.index_layout_admin')->with('admin.pages.headershow.headershow',$manager_headershow);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function HeaderShowAdd(){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
    	return view('admin.pages.headershow.headershow_add')->with('staff',$staff);
    }

    public function HeaderShowSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['headerquangcao_noi_dung']=$request->header_content;
        $data['headerquangcao_lien_ket']=$request->header_link;
        $data['headerquangcao_thu_tu']=$request->header_no;
        $data['headerquangcao_trang_thai']=$request->header_status;
        $data['nhanvien_id']=$request->staff_id;

        DB::table('tbl_headerquangcao')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/headershow');
    }

    public function UnactiveHeaderShow($headershow_id){
        $this->AuthLogin();
        DB::table('tbl_headerquangcao')->where('id',$headershow_id)->update(['headerquangcao_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/headershow');
    }
    public function ActiveHeaderShow($headershow_id){
        $this->AuthLogin();
        DB::table('tbl_headerquangcao')->where('id',$headershow_id)->update(['headerquangcao_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/headershow');
    }

    public function HeaderShowEdit($headershow_id){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
        $edit_headershow=DB::table('tbl_headerquangcao')->where('id',$headershow_id)->get();
        $manager_headershow =view('admin.pages.headershow.headershow_edit')
        ->with('edit_headershow',$edit_headershow)
        ->with('staff',$staff);
    	return view('admin.index_layout_admin')->with('admin.pages.headershow.headershow_edit',$manager_headershow);
    }

    public function HeaderShowSaveEdit(Request $request,$headershow_id){
        $this->AuthLogin();
        $data =array();
        $data['headerquangcao_noi_dung']=$request->header_content;
        $data['headerquangcao_lien_ket']=$request->header_link;
        $data['headerquangcao_thu_tu']=$request->header_no;
        $data['headerquangcao_trang_thai']=$request->header_status;
        $data['nhanvien_id']=$request->staff_id;

        DB::table('tbl_headerquangcao')->where('id',$headershow_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/headershow');
    }
    public function HeaderShowDelete($headershow_id){
        $this->AuthLogin();
        DB::table('tbl_headerquangcao')->where('id',$headershow_id)->delete();
        Session::put('message','Delete Success');
        return Redirect::to('/headershow');
    }
}
