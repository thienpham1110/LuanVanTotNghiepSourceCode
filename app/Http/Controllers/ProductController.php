<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_product=DB::table('tbl_sanpham')
        // ->join('tbl_thuonghieu','tbl_thuonghieu.id','=','tbl_sanpham.thuonghieu_id')
        // ->join('tbl_loaisanpham','tbl_loaisanpham.id','=','tbl_sanpham.loaisanpham_id')
        // ->join('tbl_dongsanpham','tbl_dongsanpham.id','=','tbl_sanpham.dongsanpham_id')
        ->orderby('tbl_sanpham.id','desc')
        ->get();

        $all_product_type=DB::table('tbl_loaisanpham')->get();
        $all_brand=DB::table('tbl_thuonghieu')->get();
        $all_collection=DB::table('tbl_dongsanpham')->get();

        return view('admin.pages.products.product')
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection);
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }

    public function ProductAdd(){
        $this->AuthLogin();
        $all_product_type=DB::table('tbl_loaisanpham')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->orderby('id','desc')->get();

    	return view('admin.pages.products.product_add')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection);
    }

    public function ProductSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['sanpham_ma_san_pham']=$request->product_code;
        $data['sanpham_ten']=$request->product_name;
        $data['sanpham_mo_ta']=$request->product_description;
        $data['sanpham_nguoi_su_dung']=$request->product_gender;
        $data['sanpham_mau_sac']=$request->product_color;
        $data['sanpham_tinh_nang']=$request->product_feature;
        $data['sanpham_noi_san_xuat']=$request->product_production;
        $data['sanpham_phu_kien']=$request->product_accessories;
        $data['sanpham_chat_lieu']=$request->product_material;
        $data['sanpham_bao_hanh']=$request->product_guarantee;
        $data['sanpham_khuyen_mai']=$request->product_discount;
        $data['sanpham_trang_thai']=$request->product_status;
        $data['loaisanpham_id']=$request->product_type;
        $data['thuonghieu_id']=$request->brand;
        $data['dongsanpham_id']=$request->collection;

        $get_image = $request->file('product_img');
        $path = 'public/uploads/admin/product';

        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);

            $data['sanpham_anh'] = $new_image;
            DB::table('tbl_sanpham')->insert($data);
            Session::put('message','Add Success');
    	    return Redirect::to('/product');
        }
        $data['sanpham_anh'] = '';
        DB::table('tbl_sanpham')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/product');
    }

    public function UnactiveProduct($product_id){
        $this->AuthLogin();
        DB::table('tbl_sanpham')->where('id',$product_id)->update(['sanpham_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/product');
    }
    public function ActiveProduct($product_id){
        $this->AuthLogin();
        DB::table('tbl_sanpham')->where('id',$product_id)->update(['sanpham_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/product');
    }

    public function ProductEdit($product_id){
        $this->AuthLogin();
        $edit_product=DB::table('tbl_sanpham')->where('id',$product_id)->get();

        $all_product_type=DB::table('tbl_loaisanpham')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->orderby('id','desc')->get();

        $manager_product =view('admin.pages.products.product_edit')->with('edit_pro',$edit_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection);

    	return view('admin.index_layout_admin')->with('admin.pages.products.product_edit',$manager_product);
    }

    public function ProductSaveEdit(Request $request,$product_id){
        $this->AuthLogin();
        $data =array();
        $data['sanpham_ma_san_pham']=$request->product_code;
        $data['sanpham_ten']=$request->product_name;
        $data['sanpham_mo_ta']=$request->product_description;
        $data['sanpham_nguoi_su_dung']=$request->product_gender;
        $data['sanpham_mau_sac']=$request->product_color;
        $data['sanpham_tinh_nang']=$request->product_feature;
        $data['sanpham_noi_san_xuat']=$request->product_production;
        $data['sanpham_phu_kien']=$request->product_accessories;
        $data['sanpham_chat_lieu']=$request->product_material;
        $data['sanpham_bao_hanh']=$request->product_guarantee;
        $data['sanpham_khuyen_mai']=$request->product_discount;
        $data['sanpham_trang_thai']=$request->product_status;
        $data['loaisanpham_id']=$request->product_type;
        $data['thuonghieu_id']=$request->brand;
        $data['dongsanpham_id']=$request->collection;

        $old_name=DB::table('tbl_sanpham')->select('sanpham_anh')->where('id',$product_id)->get();

       $get_image = $request->file('product_img');
       $path = 'public/uploads/admin/product/';
       if($get_image){
                    unlink($path.$old_name[0]->sanpham_anh);
                   $get_name_image = $get_image->getClientOriginalName();
                   $name_image = current(explode('.',$get_name_image));
                   $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                   $get_image->move($path,$new_image);
                   $data['sanpham_anh'] = $new_image;
                   DB::table('tbl_sanpham')->where('id',$product_id)->update($data);
                   Session::put('message','Update Success');
                   return Redirect::to('/product');
       }
        $data['sanpham_anh'] = $old_name[0]->sanpham_anh;
        DB::table('tbl_sanpham')->where('id',$product_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/product');
    }

    public function ProductDetail($product_id){

        $get_product=DB::table('tbl_sanpham')->where('id',$product_id)->get();

        $all_product=DB::table('tbl_sanpham')
        ->where('sanpham_trang_thai','1')
        ->get();

        $all_product_type=DB::table('tbl_loaisanpham')->where('loaisanpham_trang_thai','1')->orderby('id','desc')->get();
        $all_brand=DB::table('tbl_thuonghieu')->where('thuonghieu_trang_thai','1')->orderby('id','desc')->get();
        $all_collection=DB::table('tbl_dongsanpham')->where('dongsanpham_trang_thai','1')->orderby('id','desc')->get();

        $all_header=DB::table('tbl_headerquangcao')->where('headerquangcao_trang_thai','1')->get();
        $hearder_asc=DB::table('tbl_headerquangcao')->select('headerquangcao_thu_tu')
        ->where('headerquangcao_trang_thai','1')->orderby('headerquangcao_thu_tu','asc')->first();

        foreach($hearder_asc as $key=>$value){
            $thu_tu=$value;
        }
        foreach($get_product as $key => $value){
            $product_type_id= $value->loaisanpham_id;
        }

        $related_product=DB::table('tbl_sanpham')
        // ->join('tbl_thuonghieu','tbl_thuonghieu.id','=','tbl_sanpham.thuonghieu_id')
        // ->join('tbl_loaisanpham','tbl_loaisanpham.id','=','tbl_sanpham.loaisanpham_id')
        // ->join('tbl_dongsanpham','tbl_dongsanpham.id','=','tbl_sanpham.dongsanpham_id')
        ->where('loaisanpham_id',$product_type_id)
        ->where('sanpham_trang_thai','1')
        ->whereNotIn('tbl_sanpham.id',[$product_id])
        ->get();

    	return view('client.pages.products.product_detail')
        ->with('get_product',$get_product)
        ->with('all_product',$all_product)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('related_product',$related_product)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu);
    }


}
