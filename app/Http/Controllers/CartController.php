<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductImportDetail;
use App\Models\ProductInStock;
use App\Models\Size;
use App\Models\City;
use App\Models\Province;
use App\Models\TransportFee;
use App\Models\Wards;
use App\Models\Coupon;
use App\Models\Admin;
use App\Models\Delivery;
use App\Models\Customer;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\ProductType;
use App\Models\ProductImage;
use App\Models\ProductDiscount;
use App\Models\Discount;
use App\Models\HeaderShow;
use App\Models\SlideShow;
use Session;
use Carbon\Carbon;
use Illuminate\Mail\Transport\Transport;

session_start();
use Illuminate\Support\Facades\Redirect;
class CartController extends Controller
{
    public function ShowCart(){
        $all_product_type=ProductType::where('loaisanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_brand=Brand::where('thuonghieu_trang_thai','1')->orderBy('id','DESC')->get();
        $all_collection=Collection::where('dongsanpham_trang_thai','1')->orderBy('id','DESC')->get();
        $all_header=HeaderShow::where('headerquangcao_trang_thai','1')
        ->orderby('headerquangcao_thu_tu','ASC')->get();
        foreach($all_header as $key=>$value){
            $thu_tu_header=$value->headerquangcao_thu_tu;
            break;
        }
        return view('client.pages.cart.cart')
        ->with('product_type',$all_product_type)
        ->with('product_brand',$all_brand)
        ->with('product_collection',$all_collection)
        ->with('header_show',$all_header)
        ->with('header_min',$thu_tu_header);
    }

    public function AddToCart(Request $request){
        $data = $request->all();
		$session_id = substr(md5(microtime()) . rand(0, 26), 5);
        $size=Size::find($data['product_size_id']);
		$cart = Session::get('cart');
        $pro_in_stock=ProductInStock::where('sanpham_id',$data['product_id'])->where('size_id',$data['product_size_id'])->first();
		if($cart) {
            $is_ava=0;
            foreach($cart as $key => $value){
                if($value['product_size_id']==$data['product_size_id'] && $value['product_id']==$data['product_id']){
                    $is_ava++;
                }
            }
            if($is_ava==0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_size_name' =>$size->size,
                    'product_size_id' => $data['product_size_id'],
                    'product_name' => $data['product_name'],
                    'product_img' => $data['product_img'],
                    'product_id' => $data['product_id'],
                    'product_quantity' => $data['product_quantity'],
                    'product_price' => $data['product_price'],
                    'product_in_stock' => $pro_in_stock->sanphamtonkho_so_luong_ton,
                );
            }
            else{
                return Redirect::to('/product-detail/'.$data['product_id']);
            }
		} else {
			$cart[] = array(
				'session_id' => $session_id,
                'product_size_name' =>$size->size,
				'product_size_id' => $data['product_size_id'],
                'product_name' => $data['product_name'],
                'product_img' => $data['product_img'],
				'product_id' => $data['product_id'],
                'product_price' => $data['product_price'],
				'product_quantity' => $data['product_quantity'],
				'product_in_stock' => $pro_in_stock->sanphamtonkho_so_luong_ton,
			);
		}
		Session::put('cart', $cart);
		Session::save();
    }

    public function DeleteCartRow(Request $request) {
		$data = $request->all();
		$cart = Session::get('cart');
		if ($cart == true) {
			foreach ($cart as $key => $value) {
				if ($value['session_id'] == $data['product_session_id']) {
					unset($cart[$key]);
				}
			}
			Session::put('cart', $cart);
			Session::save();
		}
	}
}
