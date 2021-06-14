<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class SlideShowController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_slideshow=DB::table('tbl_slidequangcao')->get();
        $manager_slideshow =view('admin.pages.slideshow.slideshow')->with('all_slideshow',$all_slideshow);
    	return view('admin.index_layout_admin')->with('admin.pages.slideshow.slideshow',$manager_slideshow);
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
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
    	return view('admin.pages.slideshow.slideshow_add')->with('staff',$staff);
    }

    public function SlideShowSave(Request $request){
        $this->AuthLogin();
        $data =array();
        $data['slidequangcao_tieu_de']=$request->slideshow_title;
        $data['slidequangcao_noi_dung']=$request->slideshow_content;
        $data['slidequangcao_lien_ket']=$request->slideshow_link;
        $data['slidequangcao_thu_tu']=$request->slideshow_no;
        $data['slidequangcao_trang_thai']=$request->slideshow_status;
        $data['nhanvien_id']=$request->staff_id;

        $get_image = $request->file('slideshow_img');
        $path = 'public/uploads/admin/slideshow';

        //them hinh anh
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);

            $data['slidequangcao_anh'] = $new_image;
            DB::table('tbl_slidequangcao')->insert($data);
            Session::put('message','Add Success');
    	    return Redirect::to('/slideshow');
        }
        $data['slidequangcao_anh'] = '';

        DB::table('tbl_slidequangcao')->insert($data);
        Session::put('message','Add Success');
    	return Redirect::to('/slideshow');
    }

    public function UnactiveSlideShow($slideshow_id){
        $this->AuthLogin();
        DB::table('tbl_slidequangcao')->where('id',$slideshow_id)->update(['slidequangcao_trang_thai'=>0]);
        Session::put('message','Hide Success');
        return Redirect::to('/slideshow');
    }
    public function ActiveSlideShow($slideshow_id){
        $this->AuthLogin();
        DB::table('tbl_slidequangcao')->where('id',$slideshow_id)->update(['slidequangcao_trang_thai'=>1]);
        Session::put('message','Show Success');
        return Redirect::to('/slideshow');
    }

    public function SlideShowEdit($slideshow_id){
        $this->AuthLogin();
        $staff_id = Session::get('admin_id');
        $staff=DB::table('tbl_nhanvien')
        ->where('user_id',$staff_id)
        ->get();
        $edit_slideshow=DB::table('tbl_slidequangcao')->where('id',$slideshow_id)->get();
        $manager_slideshow =view('admin.pages.slideshow.slideshow_edit')
        ->with('edit_slideshow',$edit_slideshow)
        ->with('staff',$staff);
    	return view('admin.index_layout_admin')->with('admin.pages.slideshow.slideshow_edit',$manager_slideshow);
    }

    public function SlideShowSaveEdit(Request $request,$slideshow_id){
        $this->AuthLogin();
        $data =array();
        $data['slidequangcao_tieu_de']=$request->slideshow_title;
        $data['slidequangcao_noi_dung']=$request->slideshow_content;
        $data['slidequangcao_lien_ket']=$request->slideshow_link;
        $data['slidequangcao_thu_tu']=$request->slideshow_no;
        $data['slidequangcao_trang_thai']=$request->slideshow_status;
        $data['nhanvien_id']=$request->staff_id;

        $old_name=DB::table('tbl_slidequangcao')->select('slidequangcao_anh')->where('id',$slideshow_id)->get();

        $get_image = $request->file('slideshow_img');
        $path = 'public/uploads/admin/slideshow/';
       if($get_image){
                    unlink($path.$old_name[0]->slidequangcao_anh);
                   $get_name_image = $get_image->getClientOriginalName();
                   $name_image = current(explode('.',$get_name_image));
                   $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                   $get_image->move($path,$new_image);
                   $data['slidequangcao_anh'] = $new_image;
                   DB::table('tbl_slidequangcao')->where('id',$slideshow_id)->update($data);
                   Session::put('message','Update Success');
                   return Redirect::to('/slideshow');
       }
        $data['slidequangcao_anh'] = $old_name[0]->slidequangcao_anh;
        DB::table('tbl_slidequangcao')->where('id',$slideshow_id)->update($data);
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
