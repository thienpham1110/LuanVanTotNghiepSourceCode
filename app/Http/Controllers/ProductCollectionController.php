<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Collection;
use Illuminate\Support\Facades\Redirect;
session_start();
class ProductCollectionController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_collection = Collection::orderBy('id','DESC')->paginate(5);
        return view('admin.pages.product_collection.collection')->with('all_collection',$all_collection);
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
        $data=$request->all();
        $collection=new Collection();
        $collection->dongsanpham_ten = $data['collection_name'];
        $collection->dongsanpham_mo_ta = $data['collection_description'];
        $collection->dongsanpham_trang_thai = $data['collection_status'];
        $get_image = $request->file('collection_img');
        $path = 'public/uploads/admin/collection';
        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $collection->dongsanpham_anh = $new_image;
            $collection->save();
            Session::put('message','Add Success');
            return Redirect::to('/collection');

        }
        $collection->dongsanpham_anh = '';
        $collection->save();
        Session::put('message','Add Success');
    	return Redirect::to('/collection');
    }

    public function UnactiveCollection($collection_id){
        $this->AuthLogin();
        $unactive_collection=Collection::find($collection_id);
        $unactive_collection->dongsanpham_trang_thai=0;
        $unactive_collection->save();
        Session::put('message','Hide Success');
        return Redirect::to('/collection');
    }
    public function ActiveCollection($collection_id){
        $this->AuthLogin();
        $active_collection=Collection::find($collection_id);
        $active_collection->dongsanpham_trang_thai=1;
        $active_collection->save();
        Session::put('message','Show Success');
        return Redirect::to('/collection');
    }

    public function CollectionEdit($collection_id){
        $this->AuthLogin();
        $edit_collection=Collection::find($collection_id);
        return view('admin.pages.product_collection.collection_edit')->with('collection',$edit_collection);
    }

    public function CollectionSaveEdit(Request $request,$collection_id){
        $this->AuthLogin();
        $data=$request->all();
        $collection=Collection::find($collection_id);
        $collection->dongsanpham_ten = $data['collection_name'];
        $collection->dongsanpham_mo_ta = $data['collection_description'];
        $collection->dongsanpham_trang_thai = $data['collection_status'];
        $old_name=$collection->dongsanpham_anh;
        $get_image = $request->file('collection_img');
        $path = 'public/uploads/admin/collection/';
        if($get_image){
            unlink($path.$old_name);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $collection->dongsanpham_anh = $new_image;
            $collection->save();
            Session::put('message','Update Success');
            return Redirect::to('/collection');
        }
        $collection->dongsanpham_anh = $old_name;
        $collection->save();
        Session::put('message','Update Success');
        return Redirect::to('/collection');
    }
}
