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
    public function show_dashboard(){
    	return view('admin.pages.dashboard');
    }
    public function dashboard(Request $request){

        $admin_email=$request->admin_email;
        $admin_password=md5($request->admin_password);
        $result = DB::table('tbl_users')->where('user_email',$admin_email)->where('user_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->user_ten);
            Session::put('admin_id',$result->id);
            return view('admin.pages.dashboard');
        }else{
            Session::put('message','Sai tài khoản hoặc mật khẩu');
            return Redirect::to('/admin');
        }
    }

    public function logout(){
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }

    public function reset_password(){
    	return view('admin.pages.auth.reset_password');
    }

    public function login_admin(){
    	return view('admin.pages.auth.login_admin');
    }
}
