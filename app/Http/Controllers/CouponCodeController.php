<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponCodeController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_coupon_code=DB::table('tbl_makhuyenmai')->get();
        $manager_coupon_code =view('admin.pages.coupon_code.coupon_code')->with('all_coupon_code',$all_coupon_code);
    	return view('admin.index_layout_admin')->with('admin.pages.coupon_code.coupon_code',$manager_coupon_code);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function CouponCodeAdd(){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
    	return view('admin.pages.coupon_code.coupon_code_add')->with('staff',$staff);
    }

    public function CouponCodeSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['makhuyenmai_ten_ma']=$request->coupon_code_name;
        $data['makhuyenmai_ma']=$request->coupon_code_code;
        $data['makhuyenmai_so_luong']=$request->coupon_code_quantity;
        $data['makhuyenmai_loai_ma']=$request->coupon_code_type;
        $data['makhuyenmai_gia_tri']=$request->coupon_code_value;
        $data['makhuyenmai_trang_thai']=$request->coupon_code_status;
        $data['nhanvien_id']=$request->staff_id;

        DB::table('tbl_makhuyenmai')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/coupon-code');
    }

    public function UnactiveCouponCode($coupon_code_id){
        $this->AuthLogin();
        DB::table('tbl_makhuyenmai')->where('id',$coupon_code_id)->update(['makhuyenmai_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/coupon-code');
    }
    public function ActiveCouponCode($coupon_code_id){
        $this->AuthLogin();
        DB::table('tbl_makhuyenmai')->where('id',$coupon_code_id)->update(['makhuyenmai_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/coupon-code');
    }

    public function CouponCodeEdit($coupon_code_id){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
        $edit_coupon_code=DB::table('tbl_makhuyenmai')->where('id',$coupon_code_id)->get();
        $manager_coupon_code =view('admin.pages.coupon_code.coupon_code_edit')
        ->with('edit_coupon_code',$edit_coupon_code)
        ->with('staff',$staff);
    	return view('admin.index_layout_admin')
        ->with('admin.pages.coupon_code.coupon_code_edit',$manager_coupon_code);
    }

    public function CouponCodeSaveEdit(Request $request,$coupon_code_id){
        $this->AuthLogin();
        $data =array();
        $data['makhuyenmai_ma']=$request->coupon_code_code;
        $data['makhuyenmai_ten_ma']=$request->coupon_code_name;
        $data['makhuyenmai_so_luong']=$request->coupon_code_quantity;
        $data['makhuyenmai_loai_ma']=$request->coupon_code_type;
        $data['makhuyenmai_gia_tri']=$request->coupon_code_value;
        $data['makhuyenmai_trang_thai']=$request->coupon_code_status;
        $data['nhanvien_id']=$request->staff_id;

        DB::table('tbl_makhuyenmai')->where('id',$coupon_code_id)->update($data);
        Session::put('message','Update Success');
         return Redirect::to('/coupon-code');
    }
}
