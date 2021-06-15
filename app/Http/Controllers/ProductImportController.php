<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductImportController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $all_product_import=DB::table('tbl_donnhaphang')->orderby('tbl_donnhaphang.id','desc')
        ->get();
        return view('admin.pages.product_import.product_import')->with('all_product_import',$all_product_import);
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function ProductImportAdd(){
        $this->AuthLogin();
        $queue = Session::get('queue');

        if($queue){
            Session::put('queue',$queue);
        }else{
            Session::put('queue',[]);
        }

        $output = '';
        foreach (Session::get('queue') as $key=> $product ){
            $output .='
            <tr>
                <td scope="row">
                    <button type="button" data-id_product="'. $product['session_id'] .'" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                        <i class="mdi mdi-close mr-1"></i>
                    </button>
                </td>
                <td>'. $product['product_name'] .'</td>
                <input type="hidden" class="product_session_id_'. $product['session_id'] .'" value="'. $product['session_id'] .'">
                <input type="hidden" class="product_id_'. $product['session_id'] .'" value="'. $product['product_id'] .'">
                <input type="hidden" class="product_name_'. $product['session_id'] .'" value="'. $product['product_name'] .'">
                <td ><input type="number" min="1" name="product_quantity" class="total quantity" id="product_quantity"></td>
                <td><input type="number" min="1" name="product_price" class="total price" id="product_price"></td>
                <td><input type="number" min="1" name="product_price_retail" id="product_price_retail"></td>
                <td><input type="number" min="1" name="product_size" id="product_size"></td>
            </tr>
            ';
        }
        $all_product=DB::table('tbl_sanpham')
        // ->join('tbl_thuonghieu','tbl_thuonghieu.id','=','tbl_sanpham.thuonghieu_id')
        // ->join('tbl_loaisanpham','tbl_loaisanpham.id','=','tbl_sanpham.loaisanpham_id')
        // ->join('tbl_dongsanpham','tbl_dongsanpham.id','=','tbl_sanpham.dongsanpham_id')
        ->orderby('tbl_sanpham.id','desc')
        ->get();
        $all_supplier=DB::table('tbl_nhacungcap')->orderby('id','desc')->get();
    	return view('admin.pages.product_import.product_import_add')
        ->with('all_product',$all_product)
        ->with('all_supplier',$all_supplier);


        Session::save();
        echo $output;
        // Session::put('queue',null);
    }

    // public function ProductImportAddQueue($product_id){
    //     $all_product=DB::table('tbl_sanpham')
    //     ->orderby('tbl_sanpham.id','desc')
    //     ->get();

    //     $pro =DB::table('tbl_sanpham')->where('id',$product_id)->first();


    //     // $data['id']=$product_id;
    //     // $data['qty']=1;
    //     // $data['name']=$pro->sanpham_ten;
    //     // $data['price']=1;
    //     // $data['weight']=12;
    //     // $data['option']['image']=$pro->sanpham_tinh_nang;

    //     // Cart::add($data);
    //     // Cart::destroy();

    //    return Redirect::to('/product-import-add');
    // }
    public function ProductImportAddQueue(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $session_id=substr(md5(microtime()).rand(0,26),5);
        $queue = Session::get('queue');

        if($queue==true){
            $queue[] = array(
                'session_id'=>$session_id,
                'product_name'=>$data['product_name'],
                'product_id'=>$data['product_id'],
            );
            Session::put('queue',$queue);
        }else{
            $queue[] = array(
                'session_id'=>$session_id,
                'product_name'=>$data['product_name'],
                'product_id'=>$data['product_id'],
            );
        }
        $output = '';
        foreach ($queue as $key=> $product ){
            $output .='
            <tr>
            <td scope="row">
                <button type="button" data-id_product="'. $product['session_id'] .'" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                    <i class="mdi mdi-close mr-1"></i>
                </button>
            </td>
            <td>'. $product['product_name'] .'</td>
            <input type="hidden" class="product_session_id_'. $product['session_id'] .'" value="'. $product['session_id'] .'">
            <input type="hidden" class="product_id_'. $product['session_id'] .'" value="'. $product['product_id'] .'">
            <input type="hidden" class="product_name_'. $product['session_id'] .'" value="'. $product['product_name'] .'">
            <td ><input type="number" min="1" name="product_quantity" class="total quantity" id="product_quantity"></td>
            <td><input type="number" min="1" name="product_price" class="total price" id="product_price"></td>
            <td><input type="number" min="1" name="product_price_retail" id="product_price_retail"></td>
            <td><input type="number" min="1" name="product_size" id="product_size"></td>
        </tr>
            ';
        }
        Session::put('queue',$queue);
        Session::save();
        echo $output;
    }

    public function ProductImportDeleteRowQueue(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $queue = Session::get('queue');

        if($queue==true){
            foreach($queue as $key =>$value){
                if($value['session_id'] == $data['product_session_id']){
                    unset($queue[$key]);
                }
            }
            $output = '';
            foreach ($queue as $k=> $product ){
                $output .='
                <tr>
                <td scope="row">
                    <button type="button" data-id_product="'. $product['session_id'] .'" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                        <i class="mdi mdi-close mr-1"></i>
                    </button>
                </td>
                <td>'. $product['product_name'] .'</td>
                <input type="hidden" class="product_session_id_'. $product['session_id'] .'" value="'. $product['session_id'] .'">
                <input type="hidden" class="product_id_'. $product['session_id'] .'" value="'. $product['product_id'] .'">
                <input type="hidden" class="product_name_'. $product['session_id'] .'" value="'. $product['product_name'] .'">
                <td ><input type="number" min="1" name="product_quantity" class="total quantity" id="product_quantity"></td>
                <td><input type="number" min="1" name="product_price" class="total price" id="product_price"></td>
                <td><input type="number" min="1" name="product_price_retail" id="product_price_retail"></td>
                <td><input type="number" min="1" name="product_size" id="product_size"></td>
            </tr>
                ';
            }
            Session::put('queue',$queue);
            Session::save();
            echo $output;
        }

    }


    public function getSearch(Request $request)
    {
        return view('admin.pages.product_import.cart');
    }

    function getSearchAjax(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('tbl_sanpham')
            ->where('sanpham_ten', 'LIKE', "%{$query}%")
            ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row)
            {
               $output .= '
               <li><a href="data/'. $row->id .'">'.$row->sanpham_ten.'</a></li>
               ';
           }
           $output .= '</ul>';
           echo $output;
       }
    }

}
