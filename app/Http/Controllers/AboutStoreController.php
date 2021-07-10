<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use App\Models\AboutStore;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\Delivery;
use App\Models\ProductType;
use App\Models\ProductInStock;
use App\Models\ProductImportDetail;
use App\Models\ProductImage;
use App\Models\ProductDiscount;
use App\Models\Discount;
use App\Models\Customer;
use App\Models\HeaderShow;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Comment;
use App\Models\SlideShow;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Mail;
session_start();


class AboutStoreController extends Controller
{
    public function ShowAboutUS(){
        $all_about_us=AboutStore::orderby('cuahang_thu_tu','ASC')->get();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
    	return view('client.pages.about_us.about_us')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('all_about_us',$all_about_us)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    public function Index(){
        $this->AuthLogin();
        $all_about_store=AboutStore::all();
        return view('admin.pages.aboutstore.about_store')->with('all_about_store',$all_about_store);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function AboutStoreAdd(){
        $this->AuthLogin();
    	return view('admin.pages.aboutstore.about_store_add');
    }

    public function AboutStoreSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $about_store=new AboutStore();
        $about_store->cuahang_tieu_de = $data['about_store_title'];
        $about_store->cuahang_mo_ta = $data['about_store_description'];
        $about_store->cuahang_dia_chi = $data['about_store_address'];
        $about_store->cuahang_so_dien_thoai = $data['about_store_phone_number'];
        $about_store->cuahang_trang_thai = $data['about_store_status'];
        $get_image = $request->file('about_store_img');
        $path = 'public/uploads/admin/aboutstore';
        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $about_store->cuahang_anh = $new_image;
            $about_store->save();
            Session::put('message','Add Success');
    	    return Redirect::to('/about-store');
        }
        $about_store->cuahang_anh = '';
        $about_store->save();
        Session::put('message','Add Success');
    	return Redirect::to('/about-store');
    }

    public function UnactiveAboutStore($about_store_id){
        $this->AuthLogin();
        $unactive_about_store=AboutStore::find($about_store_id);
        $unactive_about_store->cuahang_trang_thai=0;
        $unactive_about_store->save();
        Session::put('message','Hide Success');
        return Redirect::to('/about-store');
    }
    public function ActiveAboutStore($about_store_id){
        $this->AuthLogin();
        $active_about_store=AboutStore::find($about_store_id);
        $active_about_store->cuahang_trang_thai=1;
        $active_about_store->save();
        Session::put('message','Show Success');
        return Redirect::to('/about-store');
    }

    public function AboutStoreEdit($about_store_id){
        $this->AuthLogin();
        $edit_about_store=AboutStore::find($about_store_id);
        return view('admin.pages.aboutstore.about_store_edit')
        ->with('about_store',$edit_about_store);
    }

    public function AboutStoreSaveEdit(Request $request,$about_store_id){
        $this->AuthLogin();
        $data=$request->all();
        $about_store=AboutStore::find($about_store_id);
        $about_store->cuahang_tieu_de = $data['about_store_title'];
        $about_store->cuahang_mo_ta = $data['about_store_description'];
        $about_store->cuahang_dia_chi = $data['about_store_address'];
        $about_store->cuahang_so_dien_thoai = $data['about_store_phone_number'];
        $about_store->cuahang_trang_thai = $data['about_store_status'];
        $old_name=$about_store->cuahang_anh;
        $get_image = $request->file('about_store_img');
        $path = 'public/uploads/admin/aboutstore/';
        if($get_image){
            unlink($path.$old_name);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $about_store->cuahang_anh= $new_image;
            $about_store->save();
            Session::put('message','Update Success');
            return Redirect::to('/about-store');
        }
        $about_store->cuahang_anh = $old_name;
        $about_store->save();
        Session::put('message','Update Success');
        return Redirect::to('/about-store');
    }
    public function AboutStoreDelete($about_store_id){
        $this->AuthLogin();
        DB::table('tbl_cuahang')->where('id',$about_store_id)->delete();
        Session::put('message','Delete Success');
        return Redirect::to('/aboutstore');
    }
}
