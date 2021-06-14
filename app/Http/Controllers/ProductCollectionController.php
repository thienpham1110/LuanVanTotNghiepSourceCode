<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class ProductCollectionController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_collection=DB::table('tbl_dongsanpham')->get();
        $manager_collection =view('admin.pages.product_collection.collection')->with('all_collection',$all_collection);
    	return view('admin.index_layout_admin')->with('admin.pages.product_collection.collection',$manager_collection);
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function CollectionAdd(){
        $this->AuthLogin();
    	return view('admin.pages.product_collection.collection_add');
    }

    public function CollectionSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['dongsanpham_ten']=$request->collection_name;
        $data['dongsanpham_mo_ta']=$request->collection_description;
        $data['dongsanpham_anh']=$request->collection_img;
        $data['dongsanpham_trang_thai']=$request->collection_status;

        $get_image = $request->file('collection_img');
        $path = 'public/uploads/admin/collection';

        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $data['dongsanpham_anh'] = $new_image;
            DB::table('tbl_dongsanpham')->insert($data);
            Session::put('message','Add Success');
            return Redirect::to('/collection');

        }
        $data['dongsanpham_anh'] = '';
        DB::table('tbl_dongsanpham')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/collection');
    }

    public function UnactiveCollection($collection_id){
        $this->AuthLogin();
        DB::table('tbl_dongsanpham')->where('id',$collection_id)->update(['dongsanpham_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/collection');
    }
    public function ActiveCollection($collection_id){
        $this->AuthLogin();
        DB::table('tbl_dongsanpham')->where('id',$collection_id)->update(['dongsanpham_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/collection');
    }

    public function CollectionEdit($collection_id){
        $this->AuthLogin();
        $edit_collection=DB::table('tbl_dongsanpham')->where('id',$collection_id)->get();
        $manager_collection =view('admin.pages.product_collection.collection_edit')->with('edit_collection',$edit_collection);
    	return view('admin.index_layout_admin')->with('admin.pages.product_collection.collection_edit',$manager_collection);
    }

    public function CollectionSaveEdit(Request $request,$collection_id){
        $this->AuthLogin();
       $data=array();

       $data['dongsanpham_ten']=$request->collection_name;
       $data['dongsanpham_mo_ta']=$request->collection_description;
       $data['dongsanpham_anh']=$request->collection_img;
       $data['dongsanpham_trang_thai']=$request->collection_status;

       $old_name=DB::table('tbl_dongsanpham')->select('dongsanpham_anh')->where('id',$collection_id)->get();

       $get_image = $request->file('collection_img');
       $path = 'public/uploads/admin/collection/';
       if($get_image){
                    unlink($path.$old_name[0]->dongsanpham_anh);
                   $get_name_image = $get_image->getClientOriginalName();
                   $name_image = current(explode('.',$get_name_image));
                   $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                   $get_image->move($path,$new_image);
                   $data['dongsanpham_anh'] = $new_image;
                   DB::table('tbl_dongsanpham')->where('id',$collection_id)->update($data);
                   Session::put('message','Update Success');
                   return Redirect::to('/collection');
       }
        $data['dongsanpham_anh'] = $old_name[0]->dongsanpham_anh;
        DB::table('tbl_dongsanpham')->where('id',$collection_id)->update($data);
        Session::put('message','Update Success');
        return Redirect::to('/collection');

    }
}
