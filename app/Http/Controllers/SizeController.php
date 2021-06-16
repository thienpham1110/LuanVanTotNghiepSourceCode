<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use App\models\Size;
use Illuminate\Support\Facades\Redirect;
session_start();

class SizeController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_size=Size::all();
        return view('admin.pages.size.size')->with('all_size',$all_size);
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
    	return view('admin.pages.size.size_add');
    }

    public function SizeSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $size= new Size();
        $size->size = $data['size'];
        $size->size_trang_thai = $data['size_status'];
        $size->save();
        Session::put('message','Add Success');
    	return Redirect::to('/size');
    }

    public function UnactiveSize($size_id){
        $this->AuthLogin();
        $unactive_size=Size::find($size_id);
        $unactive_size->size_trang_thai=0;
        $unactive_size->save();
        Session::put('message','Hide Success');
        return Redirect::to('/size');
    }
    public function ActiveSize($size_id){
        $this->AuthLogin();
        $active_size=Size::find($size_id);
        $active_size->size_trang_thai=1;
        $active_size->save();
        Session::put('message','Show Success');
        return Redirect::to('/size');
    }

    public function SizeEdit($size_id){
        $this->AuthLogin();
        $edit_size= Size::find($size_id);
        return view('admin.pages.size.size_edit')->with('size',$edit_size);
    }

    public function SizeSaveEdit(Request $request,$size_id){
        $this->AuthLogin();
        $data=$request->all();
        $size= Size::find($size_id);
        $size->size = $data['size'];
        $size->size_trang_thai = $data['size_status'];
        $size->save();
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
