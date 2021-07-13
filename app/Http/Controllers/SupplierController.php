<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use App\models\Supplier;
use Illuminate\Support\Facades\Redirect;
session_start();

class SupplierController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        // $all_supplier=DB::table('tbl_nhacungcap')->get();
        $all_supplier=Supplier::orderBy('id','DESC')->paginate(5);
        return view('admin.pages.supplier.supplier')->with('all_supplier',$all_supplier);
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
        $data=$request->all();
        $supplier= new Supplier();
        $supplier->nhacungcap_ten = $data['supplier_name'];
        $supplier->nhacungcap_dia_chi = $data['supplier_address'];
        $supplier->nhacungcap_so_dien_thoai = $data['supplier_phone_number'];
        $supplier->nhacungcap_email = $data['supplier_email'];
        $supplier->nhacungcap_trang_thai = $data['supplier_status'];
        $supplier->save();
        Session::put('message','Add Success');
    	return Redirect::to('/supplier');
    }

    public function UnactiveSupplier($supplier_id){
        $this->AuthLogin();
        $unactive_supplier=Supplier::find($supplier_id);
        $unactive_supplier->nhacungcap_trang_thai=0;
        $unactive_supplier->save();
        Session::put('message','Hide Success');
        return Redirect::to('/supplier');
    }
    public function ActiveSupplier($supplier_id){
        $this->AuthLogin();
        $active_supplier=Supplier::find($supplier_id);
        $active_supplier->nhacungcap_trang_thai=1;
        $active_supplier->save();
        Session::put('message','Show Success');
        return Redirect::to('/supplier');
    }

    public function SupplierEdit($supplier_id){
        $this->AuthLogin();
        $edit_supplier=Supplier::find($supplier_id);
        return view('admin.pages.supplier.supplier_edit')->with('supplier',$edit_supplier);
    }

    public function SupplierSaveEdit(Request $request,$supplier_id){
        $this->AuthLogin();
        $data=$request->all();
        $supplier= Supplier::find($supplier_id);
        $supplier->nhacungcap_ten = $data['supplier_name'];
        $supplier->nhacungcap_dia_chi = $data['supplier_address'];
        $supplier->nhacungcap_so_dien_thoai = $data['supplier_phone_number'];
        $supplier->nhacungcap_email = $data['supplier_email'];
        $supplier->nhacungcap_trang_thai = $data['supplier_status'];
        $supplier->save();
        Session::put('message','Update Success');
        return Redirect::to('/supplier');
    }
    public function SupplierDelete($supplier_id){
        $this->AuthLogin();
        $delete_supplier=Supplier::find($supplier_id);
        $delete_supplier->nhacungcap_trang_thai=2;
        $delete_supplier->save();
        Session::put('message','Delete Success');
        return Redirect::to('/supplier');
    }
}
