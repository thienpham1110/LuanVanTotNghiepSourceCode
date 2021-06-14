<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class SizeController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_size=DB::table('tbl_size')->get();
        $manager_size =view('admin.pages.size.size')->with('all_size',$all_size);
    	return view('admin.index_layout_admin')->with('admin.pages.size.size',$manager_size);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function SizeAdd(){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
    	return view('admin.pages.size.size_add')->with('staff',$staff);
    }

    public function SizeSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['size']=$request->size;
        $data['size_trang_thai']=$request->size_status;

        DB::table('tbl_size')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/size');
    }

    public function UnactiveSize($size_id){
        $this->AuthLogin();
        DB::table('tbl_size')->where('id',$size_id)->update(['size_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/size');
    }
    public function ActiveSize($size_id){
        $this->AuthLogin();
        DB::table('tbl_size')->where('id',$size_id)->update(['size_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/size');
    }

    public function SizeEdit($size_id){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
        $edit_size=DB::table('tbl_size')->where('id',$size_id)->get();
        $manager_size =view('admin.pages.size.size_edit')->with('edit_size',$edit_size)->with('staff',$staff);
    	return view('admin.index_layout_admin')->with('admin.pages.size.size_edit',$manager_size);
    }

    public function SizeSaveEdit(Request $request,$size_id){
        $this->AuthLogin();
        $data =array();
        $data['size']=$request->size;
        $data['size_trang_thai']=$request->size_status;

        DB::table('tbl_size')->where('id',$size_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/size');
    }
    public function SizeDelete($size_id){
        $this->AuthLogin();
        DB::table('tbl_size')->where('id',$size_id)->delete();
        Session::put('message','Delete Success');
        return Redirect::to('/size');
    }
}
