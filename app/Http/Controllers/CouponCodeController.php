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
        if (Session::get('admin_role')==3) {
            return Redirect::to('/dashboard');
        } else {
            $all_coupon_code=Coupon::orderBy('id', 'DESC')->paginate(5);
            return view('admin.pages.coupon_code.coupon_code')->with('all_coupon_code', $all_coupon_code);
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
    public function CouponCodeAdd(){
        $this->AuthLogin();
        if (Session::get('admin_role')==3) {
            return Redirect::to('/dashboard');
        } else {
            return view('admin.pages.coupon_code.coupon_code_add');
        }
    }

    public function CouponCodeSave(Request $request){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $data=$request->all();
            $this->validate($request,[
                'coupon_code_name' => 'bail|required|max:255|min:6',
                'coupon_code_code' => 'bail|required|max:255|min:5',
                'coupon_code_quantity' => 'bail|required'
            ],
            [
                'required' => 'Field is not empty',
                'min' => 'Too short',
                'max' => 'Too long'
            ]);
            if (empty($data['coupon_code_from_day']) && empty($data['coupon_code_to_day'])) {
                return Redirect::to('/coupon-code-add')->with('error', 'Add Fail, Please select a date');
            } else {
                $get_code=Coupon::where('makhuyenmai_ma', $data['coupon_code_code'])->first();
                if ($get_code) {
                    return Redirect::to('/coupon-code-add')->with('error', 'Add Fail, Coupon already exists');
                } else {
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
                    return Redirect::to('/coupon-code')->with('message', 'Add Success');
                }
            }
        }
    }

    public function UnactiveCouponCode($coupon_code_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $unactive_coupon_code=Coupon::find($coupon_code_id);
            if (!$unactive_coupon_code) {
                return Redirect::to('/coupon-code')->with('error', 'Not found');
            } else {
                $unactive_coupon_code->makhuyenmai_trang_thai=0;
                $unactive_coupon_code->save();
                return Redirect::to('/product-type')->with('message', 'Hide Success');
            }
        }
    }
    public function ActiveCouponCode($coupon_code_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $active_coupon_code=Coupon::find($coupon_code_id);
            if (!$active_coupon_code) {
                return Redirect::to('/coupon-code')->with('error', 'Not found');
            } else {
                $active_coupon_code->makhuyenmai_trang_thai=1;
                $active_coupon_code->save();
                return Redirect::to('/product-type')->with('message', 'Show Success');
            }
        }
    }

    public function CouponCodeEdit($coupon_code_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $edit_coupon_code=Coupon::find($coupon_code_id);
            if (!$edit_coupon_code) {
                return Redirect::to('/coupon-code')->with('error', 'Not found');
            } else {
                return view('admin.pages.coupon_code.coupon_code_edit')
            ->with('coupon_code', $edit_coupon_code);
            }
        }
    }

    public function CouponCodeSaveEdit(Request $request,$coupon_code_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $coupon=Coupon::find($coupon_code_id);
            if (!$coupon) {
                return Redirect::to('/coupon-code')->with('error', 'Not found');
            } else {
                $data=$request->all();
                $this->validate($request,[
                    'coupon_code_name' => 'bail|required|max:255|min:6',
                    'coupon_code_code' => 'bail|required|max:255|min:5',
                    'coupon_code_quantity' => 'bail|required'
                ],
                [
                    'required' => 'Field is not empty',
                    'min' => 'Too short',
                    'max' => 'Too long'
                ]);
                if (empty($data['coupon_code_from_day']) && empty($data['coupon_code_to_day'])) {
                    return Redirect::to('/coupon-code-edit')->with('error', 'Fail ,Please select a date');
                } else {
                    $get_code=Coupon::where('makhuyenmai_ma', $data['coupon_code_code'])->whereNotIn('id', [$coupon_code_id])->first();
                    if ($get_code) {
                        return Redirect::to('/coupon-code-edit')->with('error', 'Update Fail, Coupon already exists');
                    } else {
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
                        return Redirect::to('/coupon-code')->with('message', 'Update Success');
                    }
                }
            }
        }
    }
    public function CouponCodeDelete($coupon_code_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $delete_coupon=Coupon::find($coupon_code_id);
            if (!$delete_coupon) {
                return Redirect::to('/coupon-code')->with('error', 'Not found');
            } else {
                $delete_coupon->delete();
                return Redirect::to('/coupon-code')->with('message', 'Delete Success');
            }
        }
    }
}
