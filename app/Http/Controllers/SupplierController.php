<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class SupplierController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_supplier=DB::table('tbl_nhacungcap')->get();
        $manager_supplier =view('admin.pages.supplier.supplier')->with('all_supplier',$all_supplier);
    	return view('admin.index_layout_admin')->with('admin.pages.supplier.supplier',$manager_supplier);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function SupplierAdd(){
        $this->AuthLogin();
    	return view('admin.pages.supplier.supplier_add');
    }

    public function SupplierSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['nhacungcap_ten']=$request->supplier_name;
        $data['nhacungcap_dia_chi']=$request->supplier_address;
        $data['nhacungcap_so_dien_thoai']=$request->supplier_phone_number;
        $data['nhacungcap_email']=$request->supplier_email;
        $data['nhacungcap_trang_thai']=$request->supplier_status;

        DB::table('tbl_nhacungcap')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/supplier');
    }

    public function UnactiveSupplier($supplier_id){
        $this->AuthLogin();
        DB::table('tbl_nhacungcap')->where('id',$supplier_id)->update(['nhacungcap_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/supplier');
    }
    public function ActiveSupplier($supplier_id){
        $this->AuthLogin();
        DB::table('tbl_nhacungcap')->where('id',$supplier_id)->update(['nhacungcap_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/supplier');
    }

    public function SupplierEdit($supplier_id){
        $this->AuthLogin();
        $edit_supplier=DB::table('tbl_nhacungcap')->where('id',$supplier_id)->get();
        $manager_supplier =view('admin.pages.supplier.supplier_edit')->with('edit_supplier',$edit_supplier);
    	return view('admin.index_layout_admin')->with('admin.pages.supplier.supplier_edit',$manager_supplier);
    }

    public function SupplierSaveEdit(Request $request,$supplier_id){
        $this->AuthLogin();
        $data =array();
        $data['nhacungcap_ten']=$request->supplier_name;
        $data['nhacungcap_dia_chi']=$request->supplier_address;
        $data['nhacungcap_so_dien_thoai']=$request->supplier_phone_number;
        $data['nhacungcap_email']=$request->supplier_email;
        $data['nhacungcap_trang_thai']=$request->supplier_status;

        DB::table('tbl_nhacungcap')->where('id',$supplier_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/supplier');
    }
    public function SupplierDelete($supplier_id){
        $this->AuthLogin();
        DB::table('tbl_nhacungcap')->where('id',$supplier_id)->update(['nhacungcap_trang_thai'=>2]);
        Session::put('message','Delete Success');
        return Redirect::to('/supplier');
    }
}
