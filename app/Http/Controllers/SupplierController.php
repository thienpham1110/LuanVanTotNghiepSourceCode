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
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            // $all_supplier=DB::table('tbl_nhacungcap')->get();
            $all_supplier=Supplier::orderBy('id', 'DESC')->paginate(5);
            return view('admin.pages.supplier.supplier')->with('all_supplier', $all_supplier);
        }
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
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            return view('admin.pages.supplier.supplier_add');
        }
    }

    public function SupplierSave(Request $request){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $data=$request->all();
            $this->validate($request,[
                'supplier_name' => 'bail|required|max:255|min:6',
                'supplier_address' => 'bail|required|max:255|min:6',
                'supplier_phone_number' => 'bail|required|max:15|min:10',
                'supplier_email' => 'bail|required|email',
                'supplier_img' => 'bail|mimes:jpeg,jpg,png,gif|required|max:10000'
            ],
            [
                'required' => 'Field is not empty',
                'min' => 'Too short',
                'max' => 'Too long',
                'mimes' => 'Wrong image format'
            ]);
            $supplier= new Supplier();
            $supplier->nhacungcap_ten = $data['supplier_name'];
            $supplier->nhacungcap_dia_chi = $data['supplier_address'];
            $supplier->nhacungcap_so_dien_thoai = $data['supplier_phone_number'];
            $supplier->nhacungcap_email = $data['supplier_email'];
            $supplier->nhacungcap_trang_thai = $data['supplier_status'];
            $get_image = $request->file('supplier_img');
            $path = 'public/uploads/admin/supplier';
            if ($get_image) {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image =  $name_image.'.'.$get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);
                $supplier->nhacungcap_anh = $new_image;
                $supplier->save();
                return Redirect::to('/supplier')->with('message', 'Add Success');
            } else {
                return Redirect::to('/supplier-add')->with('error', 'Add Fail,Please Choose Image');
            }
        }
    }

    public function UnactiveSupplier($supplier_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $unactive_supplier=Supplier::find($supplier_id);
            if (!$unactive_supplier) {
                return Redirect::to('/supplier')->with('error', 'Not found');
            } else {
                $unactive_supplier->nhacungcap_trang_thai=0;
                $unactive_supplier->save();
                return Redirect::to('/supplier')->with('message', 'Hide Success');
            }
        }
    }
    public function ActiveSupplier($supplier_id){
        $this->AuthLogin();
        if (Session::get('admin_role')==3) {
            return Redirect::to('/dashboard');
        } else {
            $active_supplier=Supplier::find($supplier_id);
            if (!$active_supplier) {
                return Redirect::to('/supplier')->with('error', 'Not found');
            } else {
                $active_supplier->nhacungcap_trang_thai=1;
                $active_supplier->save();
                return Redirect::to('/supplier')->with('message', 'Show Success');
            }
        }
    }

    public function SupplierEdit($supplier_id){
        $this->AuthLogin();
        if (Session::get('admin_role')==3) {
            return Redirect::to('/dashboard');
        } else {
            $edit_supplier=Supplier::find($supplier_id);
            if (!$edit_supplier) {
                return Redirect::to('/supplier')->with('error', 'Not found');
            } else {
                return view('admin.pages.supplier.supplier_edit')->with('supplier', $edit_supplier);
            }
        }
    }

    public function SupplierSaveEdit(Request $request,$supplier_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $edit_supplier=Supplier::find($supplier_id);
            if (!$edit_supplier) {
                return Redirect::to('/supplier')->with('error', 'Not found');
            } else {
                $data=$request->all();
                $this->validate($request,[
                    'supplier_name' => 'bail|required|max:255|min:6',
                    'supplier_address' => 'bail|required|max:255|min:6',
                    'supplier_phone_number' => 'bail|required|max:15|min:10',
                    'supplier_email' => 'bail|required|email',
                    'supplier_img' => 'bail|mimes:jpeg,jpg,png,gif|required|max:10000'
                ],
                [
                    'required' => 'Field is not empty',
                    'min' => 'Too short',
                    'max' => 'Too long',
                    'mimes' => 'Wrong image format'
                ]);
                $supplier= Supplier::find($supplier_id);
                $supplier->nhacungcap_ten = $data['supplier_name'];
                $supplier->nhacungcap_dia_chi = $data['supplier_address'];
                $supplier->nhacungcap_so_dien_thoai = $data['supplier_phone_number'];
                $supplier->nhacungcap_email = $data['supplier_email'];
                $supplier->nhacungcap_trang_thai = $data['supplier_status'];
                $old_name_img=$supplier->nhacungcap_anh;
                $get_image = $request->file('supplier_img');
                $path = 'public/uploads/admin/supplier/';
                if ($get_image) {
                    if ($old_name_img!=null) {
                        unlink($path.$old_name_img);
                    }
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image =  $name_image.'.'.$get_image->getClientOriginalExtension();
                    $get_image->move($path, $new_image);
                    $supplier->nhacungcap_anh  = $new_image;
                    $supplier->save();
                    return Redirect::to('/supplier')->with('message', 'Update Success');
                } else {
                    if ($old_name_img!=null) {
                        $supplier->nhacungcap_anh = $old_name_img;
                        $supplier->save();
                        return Redirect::to('/supplier')->with('message', 'Update Success');
                    } else {
                        return Redirect::to('/supplier-edit/'.$supplier_id)->with('error', 'Update Fail,Please Choose Image');
                    }
                }
            }
        }
    }
    public function SupplierDelete($supplier_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $delete_supplier=Supplier::find($supplier_id);
            if (!$delete_supplier) {
                return Redirect::to('/supplier')->with('error', 'Not found');
            } else {
                $delete_supplier->nhacungcap_trang_thai=2;
                $delete_supplier->save();
                return Redirect::to('/supplier')->with('message', 'Delete Success');
            }
        }
    }
}
