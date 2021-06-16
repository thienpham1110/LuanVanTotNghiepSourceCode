<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use App\models\HeaderShow;
use Illuminate\Support\Facades\Redirect;
session_start();

class HeaderShowController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_headershow=HeaderShow::all();
        return view('admin.pages.headershow.headershow')->with('all_headershow',$all_headershow);
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
    	return view('admin.pages.headershow.headershow_add');
    }

    public function HeaderShowSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $headershow=new HeaderShow();
        $headershow->headerquangcao_noi_dung = $data['header_content'];
        $headershow->headerquangcao_lien_ket = $data['header_link'];
        $headershow->headerquangcao_thu_tu = $data['header_no'];
        $headershow->headerquangcao_trang_thai = $data['header_status'];
        $headershow->save();
        Session::put('message','Add Success');
    	return Redirect::to('/headershow');
    }

    public function UnactiveHeaderShow($headershow_id){
        $this->AuthLogin();
        $unactive_headershow=HeaderShow::find($headershow_id);
        $unactive_headershow->headerquangcao_trang_thai=0;
        $unactive_headershow->save();
        Session::put('message','Hide Success');
        return Redirect::to('/headershow');
    }
    public function ActiveHeaderShow($headershow_id){
        $this->AuthLogin();
        $active_headershow=HeaderShow::find($headershow_id);
        $active_headershow->headerquangcao_trang_thai=1;
        $active_headershow->save();
        Session::put('message','Show Success');
        return Redirect::to('/headershow');
    }

    public function HeaderShowEdit($headershow_id){
        $this->AuthLogin();
        $edit_headershow=HeaderShow::find($headershow_id);
        return view('admin.pages.headershow.headershow_edit')
        ->with('headershow',$edit_headershow);
    }

    public function HeaderShowSaveEdit(Request $request,$headershow_id){
        $this->AuthLogin();
        $data=$request->all();
        $headershow=HeaderShow::find($headershow_id);
        $headershow->headerquangcao_noi_dung = $data['header_content'];
        $headershow->headerquangcao_lien_ket = $data['header_link'];
        $headershow->headerquangcao_thu_tu = $data['header_no'];
        $headershow->headerquangcao_trang_thai = $data['header_status'];
        $headershow->save();
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
