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
use Session;
use Carbon\Carbon;
use Illuminate\Mail\Transport\Transport;

session_start();
use Illuminate\Support\Facades\Redirect;
class CustomerController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_customer = Customer::orderBy('id','DESC')->get();
        return view('admin.pages.customer.customer') ->with(compact('all_customer'));
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
}
