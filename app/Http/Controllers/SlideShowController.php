<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use App\models\SlideShow;
use Illuminate\Support\Facades\Redirect;
session_start();

class SlideShowController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_slideshow=SlideShow::orderBy('id','DESC')->paginate(5);
        return view('admin.pages.slideshow.slideshow')->with('all_slideshow',$all_slideshow);
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function SlideShowAdd(){
        $this->AuthLogin();
    	return view('admin.pages.slideshow.slideshow_add');
    }

    public function SlideShowSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $slideshow=new SlideShow();
        $slideshow->slidequangcao_tieu_de = $data['slideshow_title'];
        $slideshow->slidequangcao_noi_dung = $data['slideshow_content'];
        $slideshow->slidequangcao_lien_ket = $data['slideshow_link'];
        $slideshow->slidequangcao_thu_tu = $data['slideshow_no'];
        $slideshow->slidequangcao_trang_thai = $data['slideshow_status'];
        $get_image = $request->file('slideshow_img');
        $path = 'public/uploads/admin/slideshow';
        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $slideshow->slidequangcao_anh = $new_image;
            $slideshow->save();
            Session::put('message','Add Success');
    	    return Redirect::to('/slideshow');
        }
        $slideshow->slidequangcao_anh = '';
        $slideshow->save();
        Session::put('message','Add Success');
    	return Redirect::to('/slideshow');
    }

    public function UnactiveSlideShow($slideshow_id){
        $this->AuthLogin();
        $unactive_slideshow=SlideShow::find($slideshow_id);
        $unactive_slideshow->slidequangcao_trang_thai=0;
        $unactive_slideshow->save();
        Session::put('message','Hide Success');
        return Redirect::to('/slideshow');
    }
    public function ActiveSlideShow($slideshow_id){
        $this->AuthLogin();
        $active_slideshow=SlideShow::find($slideshow_id);
        $active_slideshow->slidequangcao_trang_thai=1;
        $active_slideshow->save();
        Session::put('message','Show Success');
        return Redirect::to('/slideshow');
    }

    public function SlideShowEdit($slideshow_id){
        $this->AuthLogin();
        $edit_slideshow=SlideShow::find($slideshow_id);
        return view('admin.pages.slideshow.slideshow_edit')
        ->with('slideshow',$edit_slideshow);
    }

    public function SlideShowSaveEdit(Request $request,$slideshow_id){
        $this->AuthLogin();
        $data=$request->all();
        $slideshow=SlideShow::find($slideshow_id);
        $slideshow->slidequangcao_tieu_de = $data['slideshow_title'];
        $slideshow->slidequangcao_noi_dung = $data['slideshow_content'];
        $slideshow->slidequangcao_lien_ket = $data['slideshow_link'];
        $slideshow->slidequangcao_thu_tu = $data['slideshow_no'];
        $slideshow->slidequangcao_trang_thai = $data['slideshow_status'];
        $old_name=$slideshow->slidequangcao_anh;
        $get_image = $request->file('slideshow_img');
        $path = 'public/uploads/admin/slideshow/';
        if($get_image){
            unlink($path.$old_name);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $slideshow->slidequangcao_anh = $new_image;
            $slideshow->save();
            Session::put('message','Update Success');
            return Redirect::to('/slideshow');
        }
        $slideshow->slidequangcao_anh= $old_name;
        $slideshow->save();
        Session::put('message','Update Success');
        return Redirect::to('/slideshow');
    }
    public function SlideShowDelete($slideshow_id){
        $this->AuthLogin();
        DB::table('tbl_slidequangcao')->where('id',$slideshow_id)->delete();
        Session::put('message','Delete Success');
        return Redirect::to('/slideshow');
    }
}
