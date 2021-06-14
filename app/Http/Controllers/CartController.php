<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function AddToCart(Request $request){
        $product_id= $request->product_id;
        $product_quantity= $request->product_quantity;
    }
}
