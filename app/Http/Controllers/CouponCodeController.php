<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use App\Models\Coupon;
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponCodeController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_coupon_code=Coupon::orderBy('id','DESC')->paginate(5);
        return view('admin.pages.coupon_code.coupon_code')->with('all_coupon_code',$all_coupon_code);
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
    	return view('admin.pages.coupon_code.coupon_code_add');
    }

    public function CouponCodeSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        if(empty($data['coupon_code_from_day']) && empty($data['coupon_code_to_day'])){
            return redirect()->back()->with('error','Fail, Please select a date');
        }else{
            $coupon_code=new Coupon();
            $coupon_code->makhuyenmai_ten_ma = $data['coupon_code_name'];
            $coupon_code->makhuyenmai_ma = $data['coupon_code_code'];
            $coupon_code->makhuyenmai_so_luong = $data['coupon_code_quantity'];
            $coupon_code->makhuyenmai_loai_ma = $data['coupon_code_type'];
            $coupon_code->makhuyenmai_gia_tri = $data['coupon_code_value'];
            $coupon_code->makhuyenmai_trang_thai = $data['coupon_code_status'];
            $coupon_code->makhuyenmai_ngay_bat_dau = $data['coupon_code_from_day'];
            $coupon_code->makhuyenmai_ngay_ket_thuc = $data['coupon_code_to_day'];
            $coupon_code->save();
            Session::put('message','Add Success');
            return Redirect::to('/coupon-code');
        }

    }

    public function UnactiveCouponCode($coupon_code_id){
        $this->AuthLogin();
        $unactive_coupon_code=Coupon::find($coupon_code_id);
        $unactive_coupon_code->makhuyenmai_trang_thai=0;
        $unactive_coupon_code->save();
        Session::put('message','Hide Success');
        return Redirect::to('/coupon-code');
    }
    public function ActiveCouponCode($coupon_code_id){
        $this->AuthLogin();
        $active_coupon_code=Coupon::find($coupon_code_id);
        $active_coupon_code->makhuyenmai_trang_thai=1;
        $active_coupon_code->save();
        Session::put('message','Show Success');
        return Redirect::to('/coupon-code');
    }

    public function CouponCodeEdit($coupon_code_id){
        $this->AuthLogin();
        $edit_coupon_code=Coupon::find($coupon_code_id);
        return view('admin.pages.coupon_code.coupon_code_edit')
        ->with('coupon_code',$edit_coupon_code);
    }

    public function CouponCodeSaveEdit(Request $request,$coupon_code_id){
        $this->AuthLogin();
        $data=$request->all();
        if(empty($data['coupon_code_from_day']) && empty($data['coupon_code_to_day'])){
            return redirect()->back()->with('error','Fail ,Please select a date');
        }else{
            $coupon_code=Coupon::find($coupon_code_id);
            $coupon_code->makhuyenmai_ten_ma = $data['coupon_code_name'];
            $coupon_code->makhuyenmai_ma = $data['coupon_code_code'];
            $coupon_code->makhuyenmai_so_luong = $data['coupon_code_quantity'];
            $coupon_code->makhuyenmai_loai_ma = $data['coupon_code_type'];
            $coupon_code->makhuyenmai_gia_tri = $data['coupon_code_value'];
            $coupon_code->makhuyenmai_trang_thai = $data['coupon_code_status'];
            $coupon_code->makhuyenmai_ngay_bat_dau = $data['coupon_code_from_day'];
            $coupon_code->makhuyenmai_ngay_ket_thuc = $data['coupon_code_to_day'];
            $coupon_code->save();
            Session::put('message', 'Update Success');
            return Redirect::to('/coupon-code');
        }
    }
}
