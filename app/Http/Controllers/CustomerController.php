<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use App\Models\ProductInStock;
use App\Models\AboutStore;
use App\Models\City;
use App\Models\Province;
use App\Models\TransportFee;
use App\Models\Wards;
use App\Models\Coupon;
use App\Models\Delivery;
use App\Models\Customer;
use App\Models\UserAccount;
use App\Models\Order;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\ProductType;
use App\Models\HeaderShow;
use App\Models\OrderDetail;
use Session;
use Mail;
use Carbon\Carbon;
use Illuminate\Mail\Transport\Transport;

session_start();
use Illuminate\Support\Facades\Redirect;
class CustomerController extends Controller
{
    public function Showlogin(){
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.customer.login')
        ->with('product_type',$all_product_type)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    //register
    public function ShowVerificationEmail(){
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.customer.verification_email')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function VerificationEmailCustomer(Request $request){
        $data=$request->all();
        $now=time();
        $get_email=Customer::where('khachhang_email',$data['verification_email'])->first();
        $get_email_user=UserAccount::where('user_email',$data['verification_email'])->first();
        if($get_email && $get_email_user){
            return redirect()->back()->with('error','Account already exists');
        }else{
            $verification_code=substr(str_shuffle(str_repeat("QWERTYUIOPLKJHGFDSAZXCVBNMqwertyuioplkjhgfdsazxcvbnm", 5)), 0,5).substr(str_shuffle(str_repeat("0123456789", 5)), 0,5);
            $to_name="RGUWB";
            $to_mail=$data['verification_email'];
            $data=array("name"=>"RGUWB Shop","body"=>$verification_code);
            $verification[] = array(
                'verification_time' => $now + 300,
                'verification_code' => $verification_code,
                'verification_email' => $to_mail,
            );
            Session::put('verification_email_customer',$verification);
            Mail::send('layout.verification_email',  $data, function($message) use ($to_name,$to_mail){
                $message->to($to_mail)->subject('Verification Code');//send this mail with subject
                $message->from($to_mail, $to_name);//send from this mail
            });
            return Redirect::to('/register-customer')->with('message','We have sent the verification code to your email, enter the verification code to register');
        }
    }

    public function ShowRegister(){
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.customer.register')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    public function RegisterCustomer(Request $request){
        $data=$request->all();
        $now=time();
        $verification=Session::get('verification_email_customer');
        if($data['customer_password_register']!= $data['customer_confirm_password_register']){
            return Redirect::to('/register-customer')->with('error','Confirmation password is incorrect');
        }else{
            if(!isset($verification)){
                return Redirect::to('/show-verification-email-customer')->with('error','Enter your email to register');
            }else{
                foreach($verification as $key=>$value){
                    $verification_time=$value['verification_time'];
                    $verification_code=$value['verification_code'];
                    $verification_email=$value['verification_email'];
                    break;
                }
                if($verification_code != $data['customer_verification_code_register'] || $verification_email != $data['customer_email_register']){
                    return Redirect::to('/register-customer')->with('error','Verification code or email is incorrect');
                }elseif($now > $verification_time){
                    Session::forget('verification_email_customer');
                    return Redirect::to('/show-verification-email-customer')->with('error','The verification code has expired');
                }else{
                    $user_acc=new UserAccount();
                    $customer=new Customer();
                    $customer->khachhang_ten=$data['customer_user_name_register'];
                    $customer->khachhang_email=$data['customer_email_register'];
                    $customer->khachhang_trang_thai=1;
                    $user_acc->user_ten=$data['customer_user_name_register'];
                    $user_acc->user_email=$data['customer_email_register'];
                    $user_acc->user_password=md5($data['customer_password_register']);
                    $user_acc->remember_token=$verification_code;
                    $user_acc->user_login_fail=0;
                    $user_acc->loainguoidung_id=4;
                    $customer->save();
                    $user_acc->save();
                    Session::forget('verification_email_customer');
                    return Redirect::to('/login-customer')->with('message','Register Success, Login Now');
                }
            }
        }
    }
    //reset password
    public function ShowVerificationResetPassword(){
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.customer.verification_password')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function VerificationResetPasswordCustomer(Request $request){
        $data=$request->all();
        $now=time();
        $get_email=Customer::where('khachhang_email',$data['verification_password'])->first();
        $get_email_user=UserAccount::where('user_email',$data['verification_password'])->first();
        if(!$get_email && !$get_email_user){
            return redirect()->back()->with('error','Account does not exist');
        }else{
            $verification_code=substr(str_shuffle(str_repeat("QWERTYUIOPLKJHGFDSAZXCVBNMqwertyuioplkjhgfdsazxcvbnm", 5)), 0,5).substr(str_shuffle(str_repeat("0123456789", 5)), 0,5);
            $to_name="RGUWB";
            $to_mail=$data['verification_password'];
            $data=array("name"=>"RGUWB Shop","body"=>$verification_code);
            $verification[] = array(
                'verification_pass_time' => $now + 300,
                'verification_pass_code' => $verification_code,
                'verification_pass_email' => $to_mail,
            );
            Session::put('verification_password_customer',$verification);
            Mail::send('layout.verification_email',  $data, function($message) use ($to_name,$to_mail){
                $message->to($to_mail)->subject('Verification Code');//send this mail with subject
                $message->from($to_mail, $to_name);//send from this mail
            });
            return Redirect::to('/reset-password-customer')->with('message','We have sent the verification code to your email, enter the verification code to reset password');
        }
    }

    public function ShowResetPassword(){
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.customer.reset_password')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }
    public function ResetPasswordCustomer(Request $request){
        $data=$request->all();
        $now=time();
        $verification=Session::get('verification_password_customer');
        if($data['customer_password_reset_password']!= $data['customer_confirm_password_reset_password']){
            return Redirect::to('/reset-password-customer')->with('error','Confirmation password is incorrect');
        }else{
            if(!isset($verification)){
                return Redirect::to('/show-verification-password-customer')->with('error','Enter your email to reset password');
            }else{
                foreach($verification as $key=>$value){
                    $verification_time=$value['verification_pass_time'];
                    $verification_code=$value['verification_pass_code'];
                    $verification_email=$value['verification_pass_email'];
                    break;
                }
                if($verification_code != $data['customer_verification_code_reset_password'] || $verification_email != $data['customer_email_reset_password']){
                    return Redirect::to('/reset-password-customer')->with('error','Verification code or email is incorrect');
                }elseif($now > $verification_time){
                    Session::forget('verification_password_customer');
                    return Redirect::to('/show-verification-password-customer')->with('error','The verification code has expired');
                }else{
                    $get_email_user=UserAccount::where('user_email',$verification_email)->first();
                    $user_acc= UserAccount::find($get_email_user->id);
                    $user_acc->user_password=md5($data['customer_password_reset_password']);
                    $user_acc->user_login_fail=0;
                    $user_acc->remember_token=$verification_code;
                    $user_acc->save();
                    Session::forget('verification_password_customer');
                    return Redirect::to('/login-customer')->with('message','Reset Password Success, Login Now');
                }
            }
        }
    }
    //Change Password

    public function ChangePasswordCustomer(Request $request, $customer_email){
        $this->CheckLogin();
        $user_account=UserAccount::where('user_email',$customer_email)->first();
        $user_account_update_password=UserAccount::find($user_account->id);
        $data=$request->all();
        if(md5($data['change_old_password']) != $user_account_update_password->user_password){
            return redirect()->back()->with('error','Old password is not correct');
        }elseif($data['change_new_password'] != $data['change_confirm_new_password']){
            return redirect()->back()->with('error','Confirmation password is incorrect');
        }else{
            $user_account_update_password->user_password=md5($data['change_new_password']);
            $user_account_update_password->save();
            Session::forget('customer_id');
            Session::forget('customer_name');
            Session::forget('user_id');
            return Redirect::to('/login-customer')->with('message','Changed password successfully, please login again');
        }
    }
    //login
    public function CheckLoginCustomer(Request $request){
        $customer_email=$request->customer_email_login;
        $customer_password=md5($request->customer_password_login);
        $email=UserAccount::where('user_email',$customer_email)->first();
        if(!$email){
            return Redirect::to('/login-customer')->with('error','Account does not exist');
        }else{
            if($email->user_password != $customer_password){
                $user_login_fail=UserAccount::find($email->id);
                $user_login_fail->user_login_fail +=1;
                $user_login_fail->save();
                return Redirect::to('/login-customer')->with('error','Incorrect password');
            }else{
                if($email->user_login_fail >= 5){
                    return Redirect::to('/show-verification-password-customer')->with('error','You have logged in incorrectly more times than specified');
                }else{
                    if($email->loainguoidung_id !=4){
                        return Redirect::to('/login-customer')->with('error','Access is not allowed');
                    }else{
                        $user_login_fail=UserAccount::find($email->id);
                        $user_login_fail->user_login_fail = 0;
                        $user_login_fail->save();
                        $customer=Customer::where('khachhang_email',$email->user_email)->first();
                        $customer_update=Customer::find($customer->id);
                        $customer_update->user_id=$email->id;
                        $customer_update->save();
                        Session::put('customer_name',$email->user_ten);
                        Session::put('user_id',$email->id);
                        Session::put('customer_id',$customer->id);
                        if(redirect()->back()==Redirect::to('/login-customer')){
                            return Redirect::to('/');
                        }else{
                            return redirect()->back();
                        }
                    }
                }
            }
        }
    }

    public function CheckLogin(){
        $login=Session::get('customer_id');
        if($login){
            return redirect()->back();
        }else{
            return Redirect::to('/login-customer')->with('error','Please Login')->send();
        }
    }
    public function ShowMyAccount(){
        $this->CheckLogin();
        $get_customer=Customer::find(Session::get('customer_id'));
        $customer_order=Order::where('khachhang_id',$get_customer->id)->orderby('id','DESC')->get();
        foreach($customer_order as $key=>$value){
            $customer_order_detail=OrderDetail::where('chitietdondathang_ma_don_dat_hang',$value->dondathang_ma_don_dat_hang)->get();
            $customer_order_delivery=Delivery::where('giaohang_ma_don_dat_hang',$value->dondathang_ma_don_dat_hang)->first();
            $customer_order_delivery_update=Delivery::find($customer_order_delivery->id);
            $customer_order_delivery_update->dondathang_id=$value->id;
            $customer_order_delivery_update->save();
            foreach($customer_order_detail as $k=>$v){
                if($value->dondathang_ma_don_dat_hang==$v->chitietdondathang_ma_don_dat_hang){
                    $customer_order_detail_update=OrderDetail::find($v->id);
                    $customer_order_detail_update->dondathang_id=$value->id;
                    $customer_order_detail_update->save();
                }
            }
        }
        // $customer_delivery_email=Delivery::where('giaohang_nguoi_nhan_email',$get_customer->khachhang_email)->orderby('id','DESC')->get();
        // if($customer_delivery_email->count()>0){
        //     foreach($customer_delivery_email as $key =>$value){
        //         $order_id[]=$value->dondathang_id;
        //     }
        //     $customer_order_email=Order::whereIn('id',$order_id)->get();
        // }else{
        //     $customer_order_email=null;
        // }
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.customer.show_account')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('header_min',$thu_tu_header)
        ->with('customer',$get_customer)
        // ->with('customer_all_order_email',$customer_order_email)
        ->with('customer_all_order',$customer_order);
    }

    public function CustomerEditSave(Request $request, $customer_id){
        $this->CheckLogin();
        $data=$request->all();
        $customer=Customer::find($customer_id);
        $customer->khachhang_ho=$data['customer_first_name'];
        $customer->khachhang_ten=$data['customer_last_name'];
        $customer->khachhang_gioi_tinh=$data['customer_gender'];
        $customer->khachhang_so_dien_thoai=$data['customer_phone_number'];
        $customer->khachhang_dia_chi=$data['customer_address'];
        $old_name_img=$customer->khachhang_anh;
        $get_image = $request->file('customer_img');
        $path = 'public/uploads/client/customer/';
        if($old_name_img){
            if($get_image){
                unlink($path.$old_name_img);
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move($path,$new_image);
                $customer->khachhang_anh  = $new_image;
                $customer->save();
                return Redirect::to('/my-account')->with('message','Update Success');
            }
            $customer->khachhang_anh = $old_name_img;
            $customer->save();
            Session::put('message','Update Success');
            return Redirect::to('/my-account');
        }else{
            if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move($path,$new_image);
                $customer->khachhang_anh = $new_image;
                $customer->save();
                return Redirect::to('/my-account')->with('message','Update Success');
            }
            $customer->khachhang_anh = '';
            $customer->save();
            return Redirect::to('/my-account')->with('message','Update Success');
        }
    }

    public function LogoutCustomer(){
        $this->CheckLogin();
        Session::forget('customer_id');
        Session::forget('customer_name');
        Session::forget('user_id');
        return Redirect::to('/login-customer');
    }


    public function ShowCustomerOrderDetail($order_id){
        $this->CheckLogin();
        $get_all_order_detail=OrderDetail::where('dondathang_id',$order_id)->get();
        $get_customer=Customer::find(Session::get('customer_id'));
        $customer_order=Order::find($order_id);
        $customer_delivery=Delivery::where('dondathang_id',$order_id)
        ->where('giaohang_ma_don_dat_hang',$customer_order->dondathang_ma_don_dat_hang)->first();
        $city=City::orderby('id','ASC')->get();
        $get_about_us_bottom=AboutStore::orderby('cuahang_thu_tu','ASC')->first();
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.customer.order_show_detail')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('get_about_us_bottom',$get_about_us_bottom)
        ->with('header_min',$thu_tu_header)
        ->with('customer',$get_customer)
        ->with('customer_order',$customer_order)
        ->with('all_order_detail',$get_all_order_detail)
        ->with('customer_delivery',$customer_delivery)
        ->with('city',$city);
    }

    public function CustomerCancelOrder($order_id){
        $this->CheckLogin();
        $order=Order::find($order_id);
        $order_delivery=Delivery::where('giaohang_ma_don_dat_hang',$order->dondathang_ma_don_dat_hang)
        ->where('dondathang_id',$order_id)->first();
        $order_delivery_update=Delivery::find($order_delivery->id);
        $order_delivery_update->giaohang_trang_thai=3;
        $order->dondathang_trang_thai=4;
        $order_detail=OrderDetail::where('chitietdondathang_ma_don_dat_hang',$order->dondathang_ma_don_dat_hang)
        ->where('dondathang_id',$order_id)->get();
        if($order->dondathang_tinh_trang_thanh_toan==1){
            foreach($order_detail as $key => $value){
                $product_in_stock=ProductInStock::where('sanpham_id',$value->sanpham_id)
                ->where('size_id',$value->size_id)->first();
                $product_in_stock_update=ProductInStock::find($product_in_stock->id);
                $product_in_stock_update->sanphamtonkho_so_luong_ton += $value->chitietdondathang_so_luong;
                $product_in_stock_update->sanphamtonkho_so_luong_da_ban -= $value->chitietdondathang_so_luong;
                $product_in_stock_update->save();
            }
            $order->dondathang_tinh_trang_thanh_toan=2;//đã hủy hoàn tiền lại đã thanh toán
        }elseif($order->dondathang_tinh_trang_thanh_toan==0){
            $order->dondathang_tinh_trang_thanh_toan=3;//đã hủy k hoàn tiền lại chưa thanh toán
        }
        $order->save();
        $order_delivery_update->save();
        return redirect()->back();
    }
}
