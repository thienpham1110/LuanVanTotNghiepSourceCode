<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use App\Models\ProductInStock;
use App\Models\Size;
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
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    public function Index(){
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        $city=City::orderby('id','ASC')->get();
        return view('client.pages.checkout.checkout')
        ->with('city',$city)
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function SelectTransportFeeHome(Request $request){
        $this->DeleteTransportFee();
        $data =$request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province=Province::where('tinhthanhpho_id',$data['ma_id'])->orderby('id','ASC')->get();
                $output.='<option>Choose Province</option>';
                foreach($select_province as $key =>$province){
                    $output.='<option value="'.$province->id.'">'.$province->quanhuyen_name.'</option>';
                }
            }else{
    			$select_wards = Wards::where('quanhuyen_id',$data['ma_id'])->orderby('id','ASC')->get();
    			$output.='<option>Choose Wards</option>';
    			foreach($select_wards as $k => $ward){
    				$output.='<option value="'.$ward->id.'">'.$ward->xaphuongthitran_name.'</option>';
    			}
    		}
            echo $output;
        }
    }
    public function DeleteTransportFee(){
        $feeship =Session::get('feeship');
        if($feeship){
            Session::forget('feeship');
        }
    }

    public function CheckTransportFee(Request $request){
        $data=$request->all();
        $feeship=TransportFee::where('tinhthanhpho_id',$data['city'])->where('quanhuyen_id',$data['province'])
        ->where('xaphuong_id',$data['wards'])->first();
        if($feeship==true){
            $fee[]=array(
                'fee_id'=>$feeship->id,
                'fee'=>$feeship->phivanchuyen_phi_van_chuyen,
                'fee_day'=>$feeship->phivanchuyen_ngay_giao_hang_du_kien,
            );
            $address[]=array(
                'city_id'=>$data['city'],
                'province_id'=>$data['province'],
                'wards_id'=>$data['wards'],
            );
            Session::put('feeship', $fee);
            Session::put('address', $address);
        }
        else{
            $fee[]=array(
                'fee_id'=>null,
                'fee'=>35000,
                'fee_day'=>3,
            );
            $address[]=array(
                'city_id'=>$data['city'],
                'province_id'=>$data['province'],
                'wards_id'=>$data['wards'],
            );
            Session::put('feeship', $fee);
            Session::put('address', $address);
        }
        Session::save();
    }

    public function OrderCheckoutSave(Request $request){
        $data=$request->all();
        $order_detail=Session::get('cart');
        $order_transport_fee=Session::get('feeship');
        $order_delivery_address=Session::get('address');
        $order_coupon=Session::get('coupon');
        $order_code=substr(str_shuffle(str_repeat("RGWUB", 5)), 0,2).substr(str_shuffle(str_repeat("0123456789", 5)), 0,6);
        $order_old=Order::where('dondathang_ma_don_dat_hang',$order_code)->first();
        foreach($order_delivery_address as $k=>$tran_deliv){
            $ci=City::find($tran_deliv['city_id']);
           print_r($ci->id);
           break;
        }

        // if($order_coupon){
        //     foreach($order_coupon as $co=>$cou){
        //         print_r($cou) ;
        //         // if($cou['coupon_type']==1){
        //         //     $discount=$cou['coupon_number'];
        //         // }else{
        //         //     $discount=$cou['coupon_number']/100;
        //         // }
        //         // break;
        //     }

        // }

        if (!$order_detail) {
            Session::put('message','Add Fail, No Products');
            return Redirect::to('/shop-now');
        }else{
            if (!$order_old) {
                $order_code = substr(str_shuffle(str_repeat("RGWUB", 5)), 0, 2).substr(str_shuffle(str_repeat("0123456789", 5)), 0, 6);
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                $order=new Order();
                $order->dondathang_ma_don_dat_hang=$order_code;
                $order->dondathang_ngay_dat_hang=$order_date;
                if ($data['order_checkout_note']) {
                    $order->dondathang_ghi_chu=$data['order_checkout_note'];
                } else {
                    $order->dondathang_ghi_chu='';
                }
                $order->dondathang_tinh_trang_giao_hang=0;
                $order->dondathang_tinh_trang_thanh_toan=0;//chưa thanh toán COD
                $order->dondathang_trang_thai=0;
                $order_delivery=new Delivery();
                foreach($order_delivery_address as $k=>$tran_deliv){
                    $ci=City::find($tran_deliv['city_id']);
                    $prov=Province::find($tran_deliv['province_id']);
                    $wards=Wards::find($tran_deliv['wards_id']);
                }
                if ($ci && $prov && $wards) {
                    $address=$data['order_checkout_address'].','.$wards->xaphuongthitran_name.','.$prov->quanhuyen_name.','.$ci->tinhthanhpho_name;
                    $order_delivery->giaohang_nguoi_nhan_dia_chi=$address;
                } else {
                    $order_delivery->giaohang_nguoi_nhan_dia_chi=$data['order_checkout_address'];
                }
                $order_delivery->giaohang_nguoi_nhan=$data['order_checkout_name'];
                $order_delivery->giaohang_nguoi_nhan_email=$data['order_checkout_email'];
                $order_delivery->giaohang_nguoi_nhan_so_dien_thoai=$data['order_checkout_phone_number'];
                $order_delivery->giaohang_phuong_thuc_thanh_toan=$data['order_checkout_pay_method'];
                $order_delivery->giaohang_trang_thai=0;
                $order_delivery->giaohang_ma_don_dat_hang=$order_code;
                $total=0;
                foreach($order_detail as $or=>$or_detail){
                    $order_detail=new OrderDetail();
                    $product_in_stock=ProductInStock::where('sanpham_id', $or_detail['product_id'])
                    ->where('size_id', $or_detail['product_size_id'])->first();
                    $product_in_stock_update=ProductInStock::find($product_in_stock->id);
                    $product_in_stock_update->sanphamtonkho_so_luong_ton = $product_in_stock_update->sanphamtonkho_so_luong_ton - $or_detail['product_quantity'];
                    $product_in_stock_update->sanphamtonkho_so_luong_da_ban=$or_detail['product_quantity'];
                    $order_detail->chitietdondathang_so_luong=$or_detail['product_quantity'];
                    $order_detail->sanpham_id=$or_detail['product_id'];
                    $order_detail->size_id=$or_detail['product_size_id'];
                    $order_detail->chitietdondathang_size=$or_detail['product_size_name'];
                    $order_detail->chitietdondathang_ma_don_dat_hang=$order_code;
                    $order_detail->chitietdondathang_don_gia=$or_detail['product_price'];
                    $total+=($or_detail['product_price']*$or_detail['product_quantity']);
                    $order_detail->save();
                    $product_in_stock_update->save();
                }
                foreach($order_transport_fee as $tran=>$fee){
                    if (isset($fee['fee_id'])){
                        $order->phivanchuyen_id=$fee['fee_id'];
                    }
                    $tran_fee=$fee['fee'];
                }
                if(isset($order_coupon)){
                    foreach($order_coupon as $co=>$cou){
                        $order->makhuyenmai_id= $cou['coupon_id'];
                        if($cou['coupon_type']==1){
                            $discount=$cou['coupon_number'];
                        }else{
                            $discount=$cou['coupon_number']/100;
                        }
                        break;
                    }
                    $order->dondathang_tong_tien=$total+$tran_fee-$discount;
                    $order->dondathang_giam_gia=$discount;
                }else{
                    $order->dondathang_tong_tien=$total+$tran_fee;
                }
                $order->dondathang_phi_van_chuyen=$tran_fee;
                $order->save();
                $order_delivery->save();
            }
        }
        if(isset($data['order_checkout_create_account'])){
            if($data['order_checkout_create_account']==1 && $data['checkout_order_password'] && $data['checkout_order_user_name']){
                $custommer=new Customer();
                $user=new UserAccount();
                $custommer->khachhang_ten=$data['order_checkout_name'];
                $custommer->khachhang_email=$data['order_checkout_email'];
                $custommer->khachhang_dia_chi=$data['order_checkout_address'];
                $custommer->khachhang_so_dien_thoai=$data['order_checkout_phone_number'];
                $custommer->khachhang_trang_thai=1;
                $user->user_ten=$data['checkout_order_user_name'];
                $user->user_email=$data['order_checkout_email'];
                $user->user_password=md5($data['checkout_order_password']);
                $user->loainguoidung_id=3;
                $user->save();
                $custommer->save();
            }
        }
        Session::forget('cart');
        Session::forget('coupon');
        Session::forget('feeship');
        return Redirect::to('/shop-now');
    }
}
