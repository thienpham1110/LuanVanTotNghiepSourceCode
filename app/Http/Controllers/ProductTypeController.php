<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\models\ProductType;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductTypeController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        if (Session::get('admin_role')==3) {
            return Redirect::to('/dashboard');
        } else {
            // $all_product_type=DB::table('tbl_loaisanpham')->get();
            $all_product_type=ProductType::orderBy('id', 'DESC')->paginate(5);
            return view('admin.pages.product_type.product_type')->with('all_product_type', $all_product_type);
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
    public function ProductTypeAdd(){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            return view('admin.pages.product_type.product_type_add');
        }
    }

    public function ProductTypeSave(Request $request){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $data=$request->all();
            $this->validate($request,[
                'product_type_name' => 'bail|required|max:255|min:6',
                'product_type_description' => 'bail|required|max:255|min:6',
                'product_type_img' => 'bail|mimes:jpeg,jpg,png,gif|required|max:10000'
            ],
            [
                'required' => 'Field is not empty',
                'min' => 'Too short',
                'max' => 'Too long',
                'mimes' => 'Wrong image format'
            ]);
            $product_type=new ProductType();
            if ($data['product_type_img']==null) {
                return Redirect::to('/product-type-add')->with('error', 'Add Fail, Please choose picture');
            } else {
                $product_type->loaisanpham_ten = $data['product_type_name'];
                $product_type->loaisanpham_mo_ta = $data['product_type_description'];
                $product_type->loaisanpham_trang_thai = $data['product_type_status'];
                $get_image = $request->file('product_type_img');
                $path = 'public/uploads/admin/producttype';
                //them hinh anh
                if ($get_image) {
                    if($path.$get_image){
                        return Redirect::to('/product-type')->with('error', 'Add Fail, Please choose another photo');
                    }else{
                        $get_name_image = $get_image->getClientOriginalName();
                        $name_image = current(explode('.', $get_name_image));
                        $new_image =  $name_image.'.'.$get_image->getClientOriginalExtension();
                        $get_image->move($path, $new_image);
                        $product_type->loaisanpham_anh = $new_image;
                        $product_type->save();
                        return Redirect::to('/product-type')->with('message', 'Add Success');
                    }
                } else {
                    return Redirect::to('/product-type')->with('error', 'Add Fail, Choose Image');
                }
            }
        }
    }

    public function UnactiveProductType($pro_type_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $unactive_product_type=ProductType::find($pro_type_id);
            if (!$unactive_product_type) {
                return Redirect::to('/product-type')->with('error', 'Not found');
            } else {
                $unactive_product_type->loaisanpham_trang_thai=0;
                $unactive_product_type->save();
                return Redirect::to('/product-type')->with('message', 'Hide Success');
            }
        }
    }
    public function ActiveProductType($pro_type_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $active_product_type=ProductType::find($pro_type_id);
            if (!$active_product_type) {
                return Redirect::to('/product-type')->with('error', 'Not found');
            } else {
                $active_product_type->loaisanpham_trang_thai=1;
                $active_product_type->save();
                return Redirect::to('/product-type')->with('message', 'Show Success');
            }
        }
    }

    public function ProductTypeEdit($pro_type_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $edit_product_type=ProductType::find($pro_type_id);
            if (!$edit_product_type) {
                return Redirect::to('/product-type')->with('error', 'Not found');
            } else {
                return view('admin.pages.product_type.product_type_edit')->with('product_type', $edit_product_type);
            }
        }
    }

    public function ProductTypeSaveEdit(Request $request,$pro_type_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $product_type=ProductType::find($pro_type_id);
            if (!$product_type) {
                return Redirect::to('/product-type')->with('error', 'Not found');
            } else {
                $data=$request->all();
                $this->validate($request,[
                    'product_type_name' => 'bail|required|max:255|min:6',
                    'product_type_description' => 'bail|required|max:255|min:6',
                    'product_type_img' => 'bail|mimes:jpeg,jpg,png,gif|required|max:10000'
                ],
                [
                    'required' => 'Field is not empty',
                    'min' => 'Too short',
                    'max' => 'Too long',
                    'mimes' => 'Wrong image format'
                ]);
                $product_type=ProductType::find($pro_type_id);
                $product_type->loaisanpham_ten = $data['product_type_name'];
                $product_type->loaisanpham_mo_ta = $data['product_type_description'];
                $product_type->loaisanpham_trang_thai = $data['product_type_status'];
                $old_name_img=$product_type->loaisanpham_anh;
                $get_image = $request->file('product_type_img');
                $path = 'public/uploads/admin/producttype/';
                if ($get_image) {
                    if($path.$get_image && $path.$get_image!=$path.$old_name_img){
                        return Redirect::to('/product-type-edit/'.$pro_type_id)->with('error', 'Update Fail, Please choose another photo');
                    }else{
                        if ($old_name_img!=null) {
                            unlink($path.$old_name_img);
                        }
                        $get_name_image = $get_image->getClientOriginalName();
                        $name_image = current(explode('.', $get_name_image));
                        $new_image =  $name_image.'.'.$get_image->getClientOriginalExtension();
                        $get_image->move($path, $new_image);
                        $product_type->loaisanpham_anh = $new_image;
                        $product_type->save();
                        return Redirect::to('/product-type')->with('message', 'Update Success');
                    }
                } else {
                    if ($old_name_img!=null) {
                        $product_type->loaisanpham_anh = $old_name_img;
                        $product_type->save();
                        return Redirect::to('/product-type')->with('message', 'Update Success');
                    } else {
                        return Redirect::to('/product-type-edit/'.$pro_type_id)->with('error', 'Update Fail,Please Choose Image');
                    }
                }
            }
        }
    }

    public function DeleteProductType($product_type_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $product_type=ProductType::find($product_type_id);
            if (!$product_type) {
                return Redirect::to('/product-type')->with('error', 'Not found');
            } else {
                $get_product_type=Product::where('loaisanpham_id', $product_type_id)->first();
                if ($get_product_type) {
                    return Redirect::to('/product-type')->with('error', 'Delete Fail, Can not delete');
                } else {
                    $delete_product_type=ProductType::find($product_type_id);
                    $delete_product_type->delete();
                    return Redirect::to('/product-type')->with('message', 'Delete Success');
                }
            }
        }
    }
}
