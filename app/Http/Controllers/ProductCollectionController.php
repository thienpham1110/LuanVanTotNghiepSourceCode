<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Collection;
use App\Models\Product;
use Collator;
use Illuminate\Support\Facades\Redirect;
session_start();
class ProductCollectionController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        if (Session::get('admin_role')==3) {
            return Redirect::to('/dashboard');
        } else {
            $all_collection = Collection::orderBy('id', 'DESC')->paginate(5);
            return view('admin.pages.product_collection.collection')->with('all_collection', $all_collection);
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
    public function CollectionAdd(){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            return view('admin.pages.product_collection.collection_add');
        }
    }

    public function CollectionSave(Request $request){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $data=$request->all();
            $this->validate($request,[
                'collection_name' => 'bail|required|max:255|min:6',
                'collection_description' => 'bail|required|max:255|min:6',
                'collection_img' => 'bail|mimes:jpeg,jpg,png,gif|required|max:10000'
            ],
            [
                'required' => 'Field is not empty',
                'min' => 'Too short',
                'max' => 'Too long',
                'mimes' => 'Wrong image format'
            ]);
            $get_brand=Collection::where('dongsanpham_ten', $data['collection_name'])->first();
            if ($get_brand) {
                return Redirect::to('/collection-add')->with('error', 'Collection already exists');
            } else {
                $collection=new Collection();
                $collection->dongsanpham_ten = $data['collection_name'];
                $collection->dongsanpham_mo_ta = $data['collection_description'];
                $collection->dongsanpham_trang_thai = $data['collection_status'];
                $get_image = $request->file('collection_img');
                $path = 'public/uploads/admin/collection';
                //them hinh anh
                if ($get_image) {
                    if($path.$get_image){
                        return Redirect::to('/collection-add')->with('error', 'Add Fail, Please choose another photo');
                    }else{
                        $get_name_image = $get_image->getClientOriginalName();
                        $name_image = current(explode('.', $get_name_image));
                        $new_image =  $name_image.'.'.$get_image->getClientOriginalExtension();
                        $get_image->move($path, $new_image);
                        $collection->dongsanpham_anh = $new_image;
                        $collection->save();
                        return Redirect::to('/collection')->with('message', 'Add Success');
                    }
                } else {
                    return Redirect::to('/collection')->with('error', 'Add Fail, Choose Image');
                }
            }
        }
    }

    public function UnactiveCollection($collection_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $unactive_collection=Collection::find($collection_id);
            if (!$unactive_collection) {
                return Redirect::to('/collection')->with('error', 'Not found');
            } else {
                $unactive_collection->dongsanpham_trang_thai=0;
                $unactive_collection->save();
                return Redirect::to('/collection')->with('message', 'Hide Success');
            }
        }
    }
    public function ActiveCollection($collection_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $active_collection=Collection::find($collection_id);
            if (!$active_collection) {
                return Redirect::to('/collection')->with('error', 'Not found');
            } else {
                $active_collection->dongsanpham_trang_thai=1;
                $active_collection->save();
                return Redirect::to('/collection')->with('message', 'Show Success');
            }
        }
    }

    public function CollectionEdit($collection_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $edit_collection=Collection::find($collection_id);
            if (!$edit_collection) {
                return Redirect::to('/collection')->with('error', 'Not found');
            } else {
                return view('admin.pages.product_collection.collection_edit')->with('collection', $edit_collection);
            }
        }
    }

    public function CollectionSaveEdit(Request $request,$collection_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $collection=Collection::find($collection_id);
            if (!$collection) {
                return Redirect::to('/collection')->with('error', 'Not found');
            } else {
                $data=$request->all();
                $this->validate($request,[
                    'collection_name' => 'bail|required|max:255|min:6',
                    'collection_description' => 'bail|required|max:255|min:6',
                    'collection_img' => 'bail|mimes:jpeg,jpg,png,gif|required|max:10000'
                ],
                [
                    'required' => 'Field is not empty',
                    'min' => 'Too short',
                    'max' => 'Too long',
                    'mimes' => 'Wrong image format'
                ]);
                $get_brand=Collection::where('dongsanpham_ten', $data['collection_name'])->whereNotIn('id', [$collection_id])->first();
                if ($get_brand) {
                    return Redirect::to('/collection-edit/'.$collection_id)->with('error', 'Collection already exists');
                } else {
                    $collection=Collection::find($collection_id);
                    $collection->dongsanpham_ten = $data['collection_name'];
                    $collection->dongsanpham_mo_ta = $data['collection_description'];
                    $collection->dongsanpham_trang_thai = $data['collection_status'];
                    $old_name=$collection->dongsanpham_anh;
                    $get_image = $request->file('collection_img');
                    $path = 'public/uploads/admin/collection/';
                    if ($get_image) {
                        if($path.$get_image && $path.$get_image!=$path.$old_name){
                            return Redirect::to('/collection-edit/'.$collection_id)->with('error', 'Update Fail, Please choose another photo');
                        }else{
                            if ($old_name!=null) {
                                unlink($path.$old_name);
                            }
                            $get_name_image = $get_image->getClientOriginalName();
                            $name_image = current(explode('.', $get_name_image));
                            $new_image =  $name_image.'.'.$get_image->getClientOriginalExtension();
                            $get_image->move($path, $new_image);
                            $collection->dongsanpham_anh = $new_image;
                            $collection->save();
                            return Redirect::to('/collection')->with('message', 'Update Success');
                        }
                    } else {
                        if ($old_name!=null) {
                            $collection->dongsanpham_anh = $old_name;
                            $collection->save();
                            return Redirect::to('/collection')->with('message', 'Update Success');
                        } else {
                            return Redirect::to('/collection-edit/'.$collection_id)->with('error', 'Update Fail,Please Choose Image');
                        }
                    }
                }
            }
        }
    }

    public function DeleteCollection($collection_id){
        $this->AuthLogin();
        if(Session::get('admin_role')==3){
            return Redirect::to('/dashboard');
        }else{
            $collection=Collection::find($collection_id);
            if (!$collection) {
                return Redirect::to('/collection')->with('error', 'Not found');
            } else {
                $get_collection=Product::where('dongsanpham_id', $collection_id)->first();
                if ($get_collection) {
                    return Redirect::to('/collection')->with('error', 'Delete Fail');
                } else {
                    $delete_collection=Collection::find($collection_id);
                    $delete_collection->delete();
                    return Redirect::to('/collection')->with('message', 'Delete Success');
                }
            }
        }
    }
}
