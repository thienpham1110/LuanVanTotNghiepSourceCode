<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\UserAccount;
use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
session_start();
class AdminHomeController extends Controller
{

    public function index(){
    	return view('admin.pages.auth.login');
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function ShowDashboard(){
        $this->AuthLogin();
    	return view('admin.pages.dashboard');
    }
    public function Login(Request $request){
        $admin_email=$request->admin_email;
        $admin_password=md5($request->admin_password);

        $result = DB::table('tbl_users')->where('user_email',$admin_email)
        ->where('user_password',$admin_password)->first();
        if($result){
            if($result->loainguoidung_id ==2 || $result->loainguoidung_id ==1 ||$result->loainguoidung_id ==3){
                Session::put('admin_name',$result->user_ten);
                Session::put('admin_id',$result->id);
                Session::put('admin_role',$result->loainguoidung_id);
                return Redirect::to('/dashboard');
            }
        }else{
            Session::put('message','User account or password incorrect');
            return Redirect::to('/admin');
        }
    }

    public function Logout(){
        $this->AuthLogin();
        Session::forget('admin_name');
        Session::forget('admin_id');
        Session::forget('admin_role');
        return Redirect::to('/admin');
    }

    public function ResetPassword(){

    	return view('admin.pages.auth.reset_password');
    }

    public function Login_Admin(){
    	return view('admin.pages.auth.login_admin');
    }

    public function ShowStaff(){
        $this->AuthLogin();
        // $all_staff = Brand::orderBy('id','DESC')->paginate(5);
        $user=UserAccount::all();
        $staff=Admin::all();
        foreach($user as $key=>$value){
            foreach($staff as $k =>$v){
                if($value->user_email==$v->admin_email){
                    $staff_update=Admin::find($v->id);
                    $staff_update->user_id=$value->id;
                    $staff_update->save();
                }
            }
        }
        $all_staff = Admin::orderBy('id','DESC')->get();
        return view('admin.pages.staff.staff')->with('all_staff',$all_staff);
    }
    public function ShowStaffAdd(){
        $this->AuthLogin();
        return view('admin.pages.staff.staff_add');
    }

    public function StaffAddSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        if($data['staff_password']!=$data['staff_password_confirm']){
            Session::put('message','Confirmation password is incorrect');
            return Redirect::to('/staff-add');
        }else{
            $staff=new Admin();
            $user_acc=new UserAccount();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $staff->admin_ten=$data['staff_name'];
            $staff->admin_email=$data['staff_email'];
            $staff->admin_trang_thai=1;
            $staff->admin_ngay_vao_lam=$date;
            $user_acc->user_ten=$data['staff_name'];
            $user_acc->user_email=$data['staff_email'];
            $user_acc->user_password=md5($data['staff_password']);
            $user_acc->loainguoidung_id=$data['admin_role'];
            $staff->save();
            $user_acc->save();
            Session::put('message','Create Success');
            return Redirect::to('/staff-add');
        }
    }

    public function ShowStaffEdit($staff_id){
        $this->AuthLogin();
        $staff=Admin::find($staff_id);
        return view('admin.pages.staff.staff_edit')->with('staff',$staff);
    }

    public function StaffEditSave(Request $request, $staff_id){
        $this->AuthLogin();
        $staff=Admin::find($staff_id);
        $data=$request->all();
        $staff->admin_ho=$data['staff_first_name'];
        $staff->admin_ten=$data['staff_last_name'];
        $staff->admin_so_dien_thoai=$data['staff_phone_number'];
        $staff->admin_dia_chi=$data['staff_address'];
        $staff->admin_id=$data['staff_admin_id'];
        $staff->admin_gioi_tinh=$data['staff_gender'];
        $staff->admin_trang_thai=$data['staff_status'];
        $old_name_img=$staff->admin_anh;
        $get_image = $request->file('staff_img');
        $path = 'public/uploads/admin/staff/';
        if($old_name_img){
            if($get_image){
                unlink($path.$old_name_img);
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move($path,$new_image);
                $staff->admin_anh  = $new_image;
                $staff->save();
                Session::put('message','Update Success');
                return Redirect::to('/staff-edit/'.$staff_id);
            }
            $staff->admin_anh = $old_name_img;
            $staff->save();
            Session::put('message','Update Success');
            return Redirect::to('/staff-edit/'.$staff_id);
        }else{
            if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move($path,$new_image);
                $staff->admin_anh = $new_image;
                $staff->save();
                Session::put('message','Update Success');
                return Redirect::to('/staff-edit/'.$staff_id);
            }
            $staff->admin_anh = '';
            $staff->save();
            Session::put('message','Update Success');
            return Redirect::to('/staff-edit/'.$staff_id);
        }
    }
}
