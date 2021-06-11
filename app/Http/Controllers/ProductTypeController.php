<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductTypeController extends Controller
{
    public function index(){
        $all_product_type=DB::table('tbl_loaisanpham')->get();
        $manager_product_type =view('admin.pages.product_type.product_type')->with('all_product_type',$all_product_type);
    	return view('admin.index_layout_admin')->with('admin.pages.product_type.product_type',$manager_product_type);
    }
    public function product_type_add(){

    	return view('admin.pages.product_type.product_type_add');
    }
    public function product_type_edit(){

    	return view('admin.pages.product_type.product_type_edit');
    }

    public function product_type_save(Request $request){
        $data =array();
        $data['loaisanpham_ten']=$request->product_type_name;
        $data['loaisanpham_mo_ta']=$request->product_type_description;
        $data['loaisanpham_anh']=$request->product_type_img;
        $data['loaisanpham_trang_thai']=$request->product_type_status;

        DB::table('tbl_loaisanpham')->insert($data);
        Session::put('message','Add Success');

    	return Redirect::to('/product-type');
    }
}
