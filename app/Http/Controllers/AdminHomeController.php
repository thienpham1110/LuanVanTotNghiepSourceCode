<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
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
            if($result->loainguoidung_id ==2 || $result->loainguoidung_id ==1){
                Session::put('admin_name',$result->user_ten);
                Session::put('admin_id',$result->id);
                return Redirect::to('/dashboard');
            }
        }else{
            Session::put('message','Sai tài khoản hoặc mật khẩu');
            return Redirect::to('/admin');
        }
    }

    public function Logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }

    public function ResetPassword(){

    	return view('admin.pages.auth.reset_password');
    }

    public function Login_Admin(){
    	return view('admin.pages.auth.login_admin');
    }
}
