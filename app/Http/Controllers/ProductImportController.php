<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImport;
use App\Models\Supplier;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class ProductImportController extends Controller {
	public function Index() {
		$this->AuthLogin();
		$all_product_import = ProductImport::orderby('id', 'desc')
			->get();
		return view('admin.pages.product_import.product_import')->with('all_product_import', $all_product_import);
	}
	public function AuthLogin() {
		$admin_id = Session::get('admin_id');
		if ($admin_id) {
			return Redirect::to('/dashboard');
		} else {
			return Redirect::to('/admin')->send();
		}
	}
	public function ProductImportAdd() {
		$this->AuthLogin();
		$queue = Session::get('queue');
		if ($queue == true) {
			Session::put('queue', $queue);
            $queue = Session::get('queue');
            $output = '';
            foreach ($queue as $k => $product) {
                $output .= '
                <tr>
                <td scope="row">
                <button type="button" data-id_product="'. $product['session_id'].'" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                    <i class="mdi mdi-close mr-1"></i>
                </button>
                </td>
                <td>'. $product['product_name'] .'</td>
                <input type="hidden" class="product_session_id_'. $product['session_id'] .'" value="'. $product['session_id'] .'">
                <input type="hidden" name="product_id['. $product['session_id'].']" class="product_id_'. $product['session_id'].'" value="'. $product['product_id'] .'">
                <input type="hidden" name="product_name['. $product['session_id'].']" class="product_name_'.$product['session_id'].' " value="'. $product['product_name'] .'">
                <input type="hidden" data-id_product="['. $product['session_id'].']" class="refresh-queue">
                <td ><input type="number" min="1" value="'. $product['product_quantity'] .'" name="product_quantity['.$product['session_id'].']" class="product_quantity_'. $product['session_id'].' product_quantity form-control" ></td>
                <td><input type="number" min="1" value="'. $product['product_price'] .'" name="product_price['. $product['session_id'].']" class="product_price_'. $product['session_id'].' product_price form-control"></td>
                <td><input type="number" min="1" value="'. $product['product_price_retail'] .'" name="product_price_retail['. $product['session_id'].']" class="product_price_retail_'. $product['session_id'].' form-control"></td>
                <td><input type="number" min="1" value="'. $product['product_size'] .'" name="product_size['. $product['session_id'].']" class="product_size_'. $product['session_id'].' form-control" ></td>
                <td><input type="text" name="amount[]" class="form-control amount"></td>
            </tr>';
            }
		} else {
			Session::put('queue', []);
		}

		$all_product = Product::orderby('tbl_sanpham.id', 'desc')
			->get();
		$all_supplier = Supplier::orderby('id', 'desc')->get();
		return view('admin.pages.product_import.product_import_add')
			->with('all_product', $all_product)
			->with('all_supplier', $all_supplier);
            echo $output;
		Session::save();

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
	public function ProductImportAddQueue(Request $request) {
		$this->AuthLogin();
		$data = $request->all();
		$session_id = substr(md5(microtime()) . rand(0, 26), 5);
		$queue = Session::get('queue');
		if ($queue == true) {
			$queue[] = array(
				'session_id' => $session_id,
				'product_name' => $data['product_name'],
				'product_id' => $data['product_id'],
				'product_quantity' => 1,
				'product_price' => 1,
				'product_price_retail' => 1,
				'product_size' => 1,
			);
			Session::put('queue', $queue);
			Session::save();
		} else {
			$queue[] = array(
				'session_id' => $session_id,
				'product_name' => $data['product_name'],
				'product_id' => $data['product_id'],
				'product_quantity' => 1,
				'product_price' => 1,
				'product_price_retail' => 1,
				'product_size' => 1,
			);
		}
		$output = '';
		foreach ($queue as $k => $product) {
			$output .= '
            <tr>
            <td scope="row">
            <button type="button" data-id_product="'. $product['session_id'].'" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                <i class="mdi mdi-close mr-1"></i>
            </button>
            </td>
            <td>'. $product['product_name'] .'</td>
            <input type="hidden" class="product_session_id_'. $product['session_id'] .'" value="'. $product['session_id'] .'">
            <input type="hidden" name="product_id['. $product['session_id'].']" class="product_id_'. $product['session_id'].'" value="'. $product['product_id'] .'">
            <input type="hidden" name="product_name['. $product['session_id'].']" class="product_name_'.$product['session_id'].' " value="'. $product['product_name'] .'">
            <input type="hidden" data-id_product="['. $product['session_id'].']" class="refresh-queue">
            <td ><input type="number" min="1" value="'. $product['product_quantity'] .'" name="product_quantity['.$product['session_id'].']" class="product_quantity_'. $product['session_id'].' product_quantity form-control" ></td>
            <td><input type="number" min="1" value="'. $product['product_price'] .'" name="product_price['. $product['session_id'].']" class="product_price_'. $product['session_id'].' product_price form-control"></td>
            <td><input type="number" min="1" value="'. $product['product_price_retail'] .'" name="product_price_retail['. $product['session_id'].']" class="product_price_retail_'. $product['session_id'].' form-control"></td>
            <td><input type="number" min="1" value="'. $product['product_size'] .'" name="product_size['. $product['session_id'].']" class="product_size_'. $product['session_id'].' form-control" ></td>
            <td><input type="text" name="amount[]" class="form-control amount"></td>
        </tr>';
		}
		Session::put('queue', $queue);
		Session::save();
		echo $output;
	}

	public function ProductImportDeleteRowQueue(Request $request) {
		$this->AuthLogin();
		$data = $request->all();
		$queue = Session::get('queue');
		if ($queue == true) {
			foreach ($queue as $key => $value) {
				if ($value['session_id'] == $data['product_session_id']) {
					unset($queue[$key]);
				}
			}
			$output = '';
			foreach ($queue as $k => $product) {
				$output .= '
                <tr>
                    <td scope="row">
                    <button type="button" data-id_product="'. $product['session_id'].'" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                        <i class="mdi mdi-close mr-1"></i>
                    </button>
                    </td>
                    <td>'. $product['product_name'] .'</td>
                    <input type="hidden" class="product_session_id_'. $product['session_id'] .'" value="'. $product['session_id'] .'">
                    <input type="hidden" name="product_id['. $product['session_id'].']" class="product_id_'. $product['session_id'].'" value="'. $product['product_id'] .'">
                    <input type="hidden" name="product_name['. $product['session_id'].']" class="product_name_'.$product['session_id'].' " value="'. $product['product_name'] .'">
                    <input type="hidden" data-id_product="['. $product['session_id'].']" class="refresh-queue">
                    <td ><input type="number" min="1" value="'. $product['product_quantity'] .'" name="product_quantity['.$product['session_id'].']" class="product_quantity_'. $product['session_id'].' product_quantity form-control" ></td>
                    <td><input type="number" min="1" value="'. $product['product_price'] .'" name="product_price['. $product['session_id'].']" class="product_price_'. $product['session_id'].' product_price form-control"></td>
                    <td><input type="number" min="1" value="'. $product['product_price_retail'] .'" name="product_price_retail['. $product['session_id'].']" class="product_price_retail_'. $product['session_id'].' form-control"></td>
                    <td><input type="number" min="1" value="'. $product['product_size'] .'" name="product_size['. $product['session_id'].']" class="product_size_'. $product['session_id'].' form-control" ></td>
                    <td><input type="text" name="amount[]" class="form-control amount"></td>
                </tr>';
			}
			Session::put('queue', $queue);
			Session::save();
			echo $output;
		}

	}
	public function ProductImportRefresh(Request $request) {
		$this->AuthLogin();
		$data = $request->all();
		$queue = Session::get('queue');
		if ($queue == true) {
			foreach($data['product_name'] as $key => $qty){
			    echo $qty;

			}
            foreach($data['product_quantity'] as $ke => $qt){
			    echo $qt;

			}
            foreach($data['product_price'] as $k => $q){
			    echo $q;

			}
			// foreach($queue as $key =>$value){

			//     // if($value['session_id'] == $data['product_session_id']){
			//     //     $queue[$value['session_id']]['product_quantity'] = $data['product_quantity'];
			//     //     $queue[$value['session_id']]['product_price'] = $data['product_price'];
			//     //     $queue[$value['session_id']]['product_price_retail'] = $data['product_price_retail'];
			//     //     $queue[$value['session_id']]['product_size'] = $data['product_size'];
			//     // }
			// }
			// $output = '';
			// foreach ($queue as $k=> $product ){
			//     $output .='
			//     <tr>
			//     <td scope="row">
			//         <button type="button" data-id_product="'. $product['session_id'] .'" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
			//             <i class="mdi mdi-close mr-1"></i>
			//         </button>
			//     </td>
			//     <td>'. $product['product_name'] .'</td>
			//     <input type="hidden" class="product_session_id_'. $product['session_id'] .'" value="'. $product['session_id'] .'">
			//     <input type="hidden" class="product_id_'. $product['session_id'] .'" value="'. $product['product_id'] .'">
			//     <input type="hidden" class="product_name_'. $product['session_id'] .'" value="'. $product['product_name'] .'">
			//     <td ><input type="number" min="1" value="'. $product['product_quantity'] .'" name="product_quantity" class="product_quantity_'. $product['session_id'] .'"></td>
			//     <td><input type="number" min="1" value="'. $product['product_price'] .'" name="product_price" class="product_price_'. $product['session_id'] .'" ></td>
			//     <td><input type="number" min="1" value="'. $product['product_price_retail'] .'" name="product_price_retail" class="product_price_retail_'.$product['session_id'] .'"></td>
			//     <td><input type="number" min="1" value="'. $product['product_size'] .'" name="product_size" class="product_size_'. $product['session_id'] .'"></td>
			// </tr>
			//     ';
			// }
			// Session::put('queue',$queue);
			// Session::save();
			// echo $output;
		}
	}

	public function getSearch(Request $request) {
		return view('admin.pages.product_import.cart');
	}

	function getSearchAjax(Request $request) {
		if ($request->get('query')) {
			$query = $request->get('query');
			$data = DB::table('tbl_sanpham')
				->where('sanpham_ten', 'LIKE', "%{$query}%")
				->get();
			$output = '<ul class="dropdown-menu" style="display:block; position:relative">';
			foreach ($data as $row) {
				$output .= '
               <li><a href="data/' . $row->id . '">' . $row->sanpham_ten . '</a></li>
               ';
			}
			$output .= '</ul>';
			echo $output;
		}
	}
	public function home() {
		return view('admin.pages.product_import.demo');
	}

}
