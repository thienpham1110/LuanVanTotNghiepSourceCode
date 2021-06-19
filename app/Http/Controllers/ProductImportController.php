<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductImport;
use App\Models\ProductInstock;
use App\Models\ProductImportDetail;
use App\Models\Size;
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
	public function ProductImportAddMultiple(Request $request) {
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
                    <button type="button" data-id_product="' . $product['session_id'] . '" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                        <i class="mdi mdi-close mr-1"></i>
                    </button>
                    </td>
                    <td>' . $product['product_name'] . '</td>
                    <input type="hidden" name="session_id[' . $product['session_id'] . ']" class="product_session_id_' . $product['session_id'] . '" value="' . $product['session_id'] . '">
                    <input type="hidden" name="product_id[' . $product['session_id'] . ']" class="product_id_' . $product['session_id'] . '" value="' . $product['product_id'] . '">
                    <input type="hidden" name="product_name[' . $product['session_id'] . ']" class="product_name_' . $product['session_id'] . ' " value="' . $product['product_name'] . '">
                    <input type="hidden" data-id_product="[' . $product['session_id'] . ']" class="refresh-queue">
                    <td ><input type="number" min="1" value="' . $product['product_quantity'] . '" name="product_quantity[' . $product['session_id'] . ']" class="product_quantity_' . $product['session_id'] . ' product_quantity form-control" ></td>
                    <td><input type="number" min="1" value="' . $product['product_price'] . '" name="product_price[' . $product['session_id'] . ']" class="product_price_' . $product['session_id'] . ' product_price form-control"></td>
                    <td><input type="number" min="1" value="' . $product['product_price_retail'] . '" name="product_price_retail[' . $product['session_id'] . ']" class="product_price_retail_' . $product['session_id'] . ' form-control"></td>
                    <td>
                        <select name="product_size_id[' . $product['product_id'] . ']" required="" class="product_size_id_' . $product['session_id'] . ' form-control product_size_id">
                            @foreach ($all_size as $key => $size)
                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="product_total[]" class="form-control product_total"></td>
                </tr>';
			}
		} else {
			Session::put('queue', []);
		}
		$admin = Admin::where('user_id', Session::get('admin_id'))->get();
		$all_product = Product::orderby('tbl_sanpham.id', 'desc')->get();
		$all_supplier = Supplier::orderby('id', 'desc')->get();
		$all_size = Size::orderby('id', 'desc')->get();
		return view('admin.pages.product_import.product_import_add_multiple')
			->with('all_product', $all_product)
			->with('get_admin', $admin)
			->with('all_size', $all_size)
			->with('all_supplier', $all_supplier);
		echo $output;
		Session::save();

	}
	public function ProductImportAddQueue(Request $request) {
		$this->AuthLogin();
		$data = $request->all();
		$session_id = substr(md5(microtime()) . rand(0, 26), 5);
		$queue = Session::get('queue');
		$price = 1;
		$qty = 1;
		if ($queue == true) {

			$queue[] = array(
				'session_id' => $session_id,
				'product_name' => $data['product_name'],
				'product_id' => $data['product_id'],
				'product_quantity' => $qty,
				'product_price' => $price,
				'product_price_retail' => $price,
				'product_total' => $price * $qty,
			);
			Session::put('queue', $queue);
			Session::save();
		} else {
			$queue[] = array(
				'session_id' => $session_id,
				'product_name' => $data['product_name'],
				'product_id' => $data['product_id'],
				'product_quantity' => $qty,
				'product_price' => $price,
				'product_price_retail' => $price,
				'product_total' => $price * $qty,
			);
			Session::put('queue', $queue);
			Session::save();
		}
		$output = '';
		foreach ($queue as $k => $product) {
			$output .= '
            <tr>
                <td scope="row">
                <button type="button" data-id_product="' . $product['session_id'] . '" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                    <i class="mdi mdi-close mr-1"></i>
                </button>
                </td>
                <td>' . $product['product_name'] . '</td>
                <input type="hidden" name="session_id[' . $product['session_id'] . ']" class="product_session_id_' . $product['session_id'] . '" value="' . $product['session_id'] . '">
                <input type="hidden" name="product_id[' . $product['session_id'] . ']" class="product_id_' . $product['session_id'] . '" value="' . $product['product_id'] . '">
                <input type="hidden" name="product_name[' . $product['session_id'] . ']" class="product_name_' . $product['session_id'] . ' " value="' . $product['product_name'] . '">
                <input type="hidden" data-id_product="[' . $product['session_id'] . ']" class="refresh-queue">
                <td ><input type="number" min="1" value="' . $product['product_quantity'] . '" name="product_quantity[' . $product['session_id'] . ']" class="product_quantity_' . $product['session_id'] . ' product_quantity form-control" ></td>
                <td><input type="number" min="1" value="' . $product['product_price'] . '" name="product_price[' . $product['session_id'] . ']" class="product_price_' . $product['session_id'] . ' product_price form-control"></td>
                <td><input type="number" min="1" value="' . $product['product_price_retail'] . '" name="product_price_retail[' . $product['session_id'] . ']" class="product_price_retail_' . $product['session_id'] . ' form-control"></td>
                <td>
                    <select name="product_size_id[' . $product['product_id'] . ']" required="" class="product_size_id_' . $product['session_id'] . ' form-control product_size_id">
                        @foreach ($all_size as $key => $size)
                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="product_total[]" class="form-control product_total"></td>
            </tr>';
		}
		Session::put('queue', $queue);
		echo $output;
		Session::save();
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
                    <button type="button" data-id_product="' . $product['session_id'] . '" name="delete-row-queue" class="delete-row-queue btn btn-danger waves-effect waves-light btn-sm">
                        <i class="mdi mdi-close mr-1"></i>
                    </button>
                    </td>
                    <td>' . $product['product_name'] . '</td>
                    <input type="hidden" name="session_id[' . $product['session_id'] . ']" class="product_session_id_' . $product['session_id'] . '" value="' . $product['session_id'] . '">
                    <input type="hidden" name="product_id[' . $product['session_id'] . ']" class="product_id_' . $product['session_id'] . '" value="' . $product['product_id'] . '">
                    <input type="hidden" name="product_name[' . $product['session_id'] . ']" class="product_name_' . $product['session_id'] . ' " value="' . $product['product_name'] . '">
                    <input type="hidden" data-id_product="[' . $product['session_id'] . ']" class="refresh-queue">
                    <td ><input type="number" min="1" value="' . $product['product_quantity'] . '" name="product_quantity[' . $product['session_id'] . ']" class="product_quantity_' . $product['session_id'] . ' product_quantity form-control" ></td>
                    <td><input type="number" min="1" value="' . $product['product_price'] . '" name="product_price[' . $product['session_id'] . ']" class="product_price_' . $product['session_id'] . ' product_price form-control"></td>
                    <td><input type="number" min="1" value="' . $product['product_price_retail'] . '" name="product_price_retail[' . $product['session_id'] . ']" class="product_price_retail_' . $product['session_id'] . ' form-control"></td>
                    <td>
                        <select name="product_size_id[' . $product['product_id'] . ']" required="" class="product_size_id_' . $product['session_id'] . ' form-control product_size_id">
                            @foreach ($all_size as $key => $size)
                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="product_total[]" class="form-control product_total"></td>
                </tr>';
			}
			Session::put('queue', $queue);
			echo $output;
			Session::save();
		}
	}

	public function ProductImportAddMultipleSave(Request $request) {
		$this->AuthLogin();
		$data = $request->all();
		$admin = Admin::where('user_id', Session::get('admin_id'))->get();
		foreach ($admin as $k => $v) {
			$id = $v->id;
		}
		$all_product_import = ProductImport::where('donnhaphang_ma_don_nhap_hang', '=', $data['product_import_no'])->exists();
		if ($all_product_import) {
			Session::put('message', 'Add Fail, Already Exist');
			return Redirect::to('/product-import-add');
		} else {
			$product_import = new ProductImport();
			$product_import->donnhaphang_ma_don_nhap_hang = $data['product_import_no'];
			$product_import->donnhaphang_ngay_nhap = $data['product_import_delivery_day'];
			$product_import->donnhaphang_trang_thai = $data['product_import_status'];
			$product_import->nhacungcap_id = $data['product_import_supplier'];
			$product_import->admin_id = $id;
			$queue = Session::get('queue');
			foreach ($data['product_id'] as $key => $value) {
				foreach ($queue as $k => $v) {
					if ($v['product_id'] == $key) {
						$size = Size::find($data['product_size_id'][$key]);
						$queue[$k]['product_quantity'] = $data['product_quantity'][$key];
						$queue[$k]['product_price'] = $data['product_price'][$key];
						$queue[$k]['product_price_retail'] = $data['product_price_retail'][$key];
						$queue[$k]['product_size'] = $size->size;
						$queue[$k]['product_size_id'] = $data['product_size_id'][$key];
						$queue[$k]['product_total'] = $data['product_total'][$key];
					}
				}
			}
			$total = 0;
			foreach ($queue as $key => $value) {
				$get_product_import_detail = ProductImportDetail::where('sanpham_id', '=', $value['product_id'])
					->where('size_id', '=', $value['product_size_id'])->first();
				if (!$get_product_import_detail) {
					$import_product_detail = new ProductImportDetail();
					$import_product_detail->chitietnhap_so_luong_nhap = $value['product_quantity'];
					$import_product_detail->chitietnhap_so_luong_da_ban = 0;
					$import_product_detail->chitietnhap_so_luong_con_lai = $value['product_quantity'];
					$import_product_detail->chitietnhap_gia_nhap = $value['product_price'];
					$import_product_detail->chitietnhap_gia_ban = $value['product_price_retail'];
					$import_product_detail->chitietnhap_size = $value['product_size'];
					$import_product_detail->size_id = $value['product_size_id'];
					$import_product_detail->sanpham_id = $value['product_id'];
					$import_product_detail->chitietnhap_ma_don_nhap_hang = $data['product_import_no'];
					$import_product_detail->save();
					$total += $value['product_total'];
				} else {
					$product_import_detail_old = DB::table('tbl_chitietnhap')->where('sanpham_id', $value['product_id'])
						->where('size_id', $value['product_size_id'])->get();
					foreach ($product_import_detail_old as $k => $old) {
						$import_product_detail = new ProductImportDetail();
						$product_import_detail_update = array();
						$import_product_detail->chitietnhap_so_luong_nhap = $value['product_quantity'];
						$import_product_detail->chitietnhap_so_luong_da_ban = $old->chitietnhap_so_luong_da_ban;
						$import_product_detail->chitietnhap_so_luong_con_lai = $value['product_quantity'] + $old->chitietnhap_so_luong_con_lai;
						$import_product_detail->chitietnhap_gia_nhap = $value['product_price'];
						$import_product_detail->chitietnhap_gia_ban = $value['product_price_retail'];
						$import_product_detail->chitietnhap_size = $old->chitietnhap_size;
						$import_product_detail->size_id = $old->size_id;
						$import_product_detail->sanpham_id = $old->sanpham_id;
						$import_product_detail->chitietnhap_ma_don_nhap_hang = $data['product_import_no'];
						$product_import_detail_update['chitietnhap_so_luong_con_lai'] = $value['product_quantity'] + $old->chitietnhap_so_luong_con_lai;
						$product_import_detail_update['chitietnhap_gia_ban'] = $value['product_price_retail'];
						DB::table('tbl_chitietnhap')->where('sanpham_id', $value['product_id'])
							->where('size_id', $old->size_id)->update($product_import_detail_update);
						$import_product_detail->save();
						$total += $value['product_total'];
						break;
					}
				}

			}
			$product_import->donnhaphang_tong_tien = $total;
			$product_import->save();
			Session::put('queue', '');
			Session::put('message', 'Add Success');
			return Redirect::to('/product-import');
		}
	}

	public function UnactiveProductImport($product_import_id) {
		$this->AuthLogin();
		$active_product_import = ProductImport::find($product_import_id);
		$active_product_import->donnhaphang_trang_thai = 0;
		$active_product_import->save();
		Session::put('message', 'Unpaid Success');
		return Redirect::to('/product-import');
	}
	public function ActiveProductImport($product_import_id) {
		$this->AuthLogin();
		$active_product_import = ProductImport::find($product_import_id);
		$active_product_import->donnhaphang_trang_thai = 1;
		$active_product_import->save();
		Session::put('message', 'Paid Success');
		return Redirect::to('/product-import');
	}

    public function ProductImportAdd(){
        $this->AuthLogin();
        $admin = Admin::where('user_id', Session::get('admin_id'))->get();
		$all_supplier = Supplier::orderby('id', 'desc')->get();
        $all_product_import = ProductImport::all();
		return view('admin.pages.product_import.product_import_add')
		->with('get_admin', $admin)
        ->with('all_product_import', $all_product_import)
		->with('all_supplier', $all_supplier);
    }

    public function ProductImportAddSave(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $admin = Admin::where('user_id', Session::get('admin_id'))->get();
		foreach ($admin as $k => $v) {
			$id = $v->id;
		}
        $all_product_import = ProductImport::where('donnhaphang_ma_don_nhap_hang', '=', $data['product_import_no'])->exists();
		if ($all_product_import) {
			Session::put('message', 'Add Fail, Already Exist');
			return Redirect::to('/product-import-add');
		} else {
            $product_import = new ProductImport();
			$product_import->donnhaphang_ma_don_nhap_hang = $data['product_import_no'];
			$product_import->donnhaphang_ngay_nhap = $data['product_import_delivery_day'];
			$product_import->donnhaphang_trang_thai = $data['product_import_status'];
			$product_import->nhacungcap_id = $data['product_import_supplier'];
			$product_import->admin_id = $id;
            $product_import->donnhaphang_tong_tien = 0;
			$product_import->save();
        }
        Session::put('message', 'Add Success');
        return Redirect::to('/product-import-add');
    }


	public function ProductImportShowDetail($product_import_id) {
		$this->AuthLogin();
		$admin = Admin::where('user_id', Session::get('admin_id'))->get();
		$all_product = Product::orderby('tbl_sanpham.id', 'desc')->get();
		$all_supplier = Supplier::orderby('id', 'desc')->get();
		$all_size = Size::orderby('id', 'desc')->get();
		$product_import = ProductImport::find($product_import_id);
		$get_product_import_detail = ProductImportDetail::where('chitietnhap_ma_don_nhap_hang', $product_import->donnhaphang_ma_don_nhap_hang)->get();
		return view('admin.pages.product_import.product_import_show_detail')
			->with('all_product', $all_product)
			->with('get_admin', $admin)
			->with('all_size', $all_size)
			->with('product_import', $product_import)
			->with('get_product_import_detail', $get_product_import_detail)
			->with('all_supplier', $all_supplier);
	}

	public function ProductImportEditSave(Request $request, $product_import_id) {
		$this->AuthLogin();
		$data = $request->all();
		$product_import = ProductImport::find($product_import_id);
		$product_import->donnhaphang_ngay_nhap = $data['product_import_delivery_day'];
		$product_import->donnhaphang_trang_thai = $data['product_import_status'];
		$product_import->nhacungcap_id = $data['product_import_supplier'];
		$product_import->save();
		Session::put('message', 'Update Success');
		return Redirect::to('/product-import');
	}


    public function ProductImportAddDetail($product_import_id){
        $this->AuthLogin();
		$all_size = Size::all();
		$all_product = Product::orderBy('id', 'DESC')->get();
		$product_import = ProductImport::find($product_import_id);
		return view('admin.pages.product_import.product_import_add_detail')
		->with('product_import', $product_import)
		->with('all_size', $all_size)
		->with('all_product', $all_product);
    }

    public function ProductImportAddDetailSave(Request $request,$product_import_id){
        $this->AuthLogin();
        $data=$request->all();
        $get_product_import_detail = ProductImportDetail::where('sanpham_id', '=', $data['product_import_detail_product_id'])
        ->where('size_id', '=', $data['product_import_detail_size_id'])->first();
        $product_in_stock=ProductInstock::where('sanpham_id', '=', $data['product_import_detail_product_id'])
        ->where('size_id', '=', $data['product_import_detail_size_id'])->first();
        $total=0;
        if (!$get_product_import_detail && !$product_in_stock) {//thêm sản phẩm mới
            $size=Size::find($data['product_import_detail_size_id']);
            $import_product_detail = new ProductImportDetail();
            $import_product_in_stock= new ProductInStock();
            $import_product_in_stock->sanphamtonkho_so_luong_ton = $data['product_import_detail_quantity'];
            $import_product_in_stock->sanphamtonkho_gia_ban = $data['product_import_detail_price_retail'];
            $import_product_in_stock->sanphamtonkho_so_luong_da_ban = 0;
            $import_product_in_stock->sanpham_id = $data['product_import_detail_product_id'];
            $import_product_in_stock->size_id = $data['product_import_detail_size_id'];
            $import_product_in_stock->save();//save in stock
            $import_product_detail->chitietnhap_so_luong_nhap = $data['product_import_detail_quantity'];
            $import_product_detail->chitietnhap_gia_nhap = $data['product_import_detail_price'];
            $import_product_detail->chitietnhap_size = $size->size;
            $import_product_detail->size_id = $data['product_import_detail_size_id'];
            $import_product_detail->sanpham_id = $data['product_import_detail_product_id'];
            $import_product_detail->chitietnhap_ma_don_nhap_hang = $data['product_import_no'];
            $import_product_detail->donnhaphang_id = $data['product_import_id'];
            $import_product=ProductImport::find($product_import_id);
            $import_product->donnhaphang_tong_tien =  $import_product->donnhaphang_tong_tien + ($data['product_import_detail_price']*$data['product_import_detail_quantity']);
            $import_product->save();
            $import_product_detail->save();//save detail
        }
        else { //thêm sản phẩm cũ
            $import_product_detail = new ProductImportDetail();
            $size=Size::find($data['product_import_detail_size_id']);
            $import_product_detail->chitietnhap_so_luong_nhap = $data['product_import_detail_quantity'];
            $import_product_detail->chitietnhap_gia_nhap = $data['product_import_detail_price'];
            $import_product_detail->chitietnhap_size = $size->size;
            $import_product_detail->chitietnhap_size = $size->size;
            $import_product_detail->size_id = $data['product_import_detail_size_id'];
            $import_product_detail->sanpham_id = $data['product_import_detail_product_id'];
            $import_product_detail->chitietnhap_ma_don_nhap_hang = $data['product_import_no'];
            $import_product_detail->donnhaphang_id = $data['product_import_id'];
            $import_product_detail->save();
            $import_product_in_stock_update=ProductInstock::find($product_in_stock->id);
            $import_product_in_stock_update->sanphamtonkho_so_luong_ton = $data['product_import_detail_quantity'] + $product_in_stock->sanphamtonkho_so_luong_ton;
            $import_product_in_stock_update->sanphamtonkho_gia_ban=$data['product_import_detail_price_retail'];
            $import_product_in_stock_update->save();
            $import_product=ProductImport::find($product_import_id);
            $import_product->donnhaphang_tong_tien =  $import_product->donnhaphang_tong_tien + ($data['product_import_detail_price']*$data['product_import_detail_quantity']);
            $import_product->save();
        }
        return Redirect::to('/product-import-show-detail/'.$product_import_id);
    }

	public function ProductImportEditDetail($product_import_detail_id) {
		$this->AuthLogin();
		$all_size = Size::all();
		$all_product = Product::orderBy('id', 'DESC')->get();
		$product_import_detail = ProductImportDetail::find($product_import_detail_id);
		$get_product_in_stock = ProductInstock::where('sanpham_id', '=', $product_import_detail->sanpham_id)
        ->where('size_id', '=',$product_import_detail->size_id)->first();
		return view('admin.pages.product_import.product_import_edit_detail')
			->with('product_import_detail', $product_import_detail)
			->with('all_size', $all_size)
			->with('product_in_stock', $get_product_in_stock)
			->with('all_product', $all_product);
	}

	public function ProductImportEditDetailSave(Request $request, $product_import_detail_id) {
		$this->AuthLogin();
		$data = $request->all();
        $get_product_import_detail= ProductImportDetail::where('sanpham_id','=', $data['product_import_detail_product_id'])
        ->where('size_id','=', $data['product_import_detail_size_id'])->first();
        $product_in_stock=ProductInstock::where('sanpham_id', '=', $data['product_import_detail_product_id'])
        ->where('size_id', '=', $data['product_import_detail_size_id'])->first();
        $get_product_in_stock_old= ProductInstock::where('sanpham_id','=', $data['product_import_detail_product_id'])
        ->where('size_id','=', $data['product_import_detail_size_id_old'])->first();
        $size=Size::find($data['product_import_detail_size_id']);
        $import_product_detail = ProductImportDetail::find( $product_import_detail_id);
        $import_product=ProductImport::find($data['product_import_id']);
        $import_product_in_stock_old=ProductInstock::find($get_product_in_stock_old->id);
        if(( $import_product_in_stock_old->sanphamtonkho_so_luong_ton - $data['product_import_detail_quantity_old']) < 0){
            Session::put('message', 'Updete Fail, Quantity Invalid');
            return Redirect::to('/product-import-show-detail/'.$import_product_detail->donnhaphang_id);
        }
        else if(!$get_product_import_detail && !$product_in_stock){//sản phẩm cũ size mới chưa có tồn kho
            $import_product_in_stock= new ProductInstock();//tạo tồn kho mới
            $import_product_in_stock->sanphamtonkho_so_luong_ton = $data['product_import_detail_quantity'];
            $import_product_in_stock->sanphamtonkho_gia_ban = $data['product_import_detail_price_retail'];
            $import_product_in_stock->sanphamtonkho_so_luong_da_ban = 0;
            $import_product_in_stock->sanpham_id = $data['product_import_detail_product_id'];
            $import_product_in_stock->size_id = $data['product_import_detail_size_id'];
            $import_product_in_stock->save();//save in stock
            $import_product_in_stock_old->sanphamtonkho_so_luong_ton = $import_product_in_stock_old->sanphamtonkho_so_luong_ton - $data['product_import_detail_quantity_old'];
            $import_product_in_stock_old->save();//update in stock old old
            $import_product_detail->chitietnhap_so_luong_nhap = $data['product_import_detail_quantity'];
            $import_product_detail->chitietnhap_gia_nhap = $data['product_import_detail_price'];
            $import_product_detail->chitietnhap_size = $size->size;
            $import_product_detail->size_id = $data['product_import_detail_size_id'];
            $import_product_detail->save();//update detail
            $import_product->donnhaphang_tong_tien = $import_product->donnhaphang_tong_tien +
            (($data['product_import_detail_price']*$data['product_import_detail_quantity'])-($data['product_import_detail_quantity_old']*$data['product_import_detail_price_old']));
            $import_product->save();//update total
        }else{//sửa sản phẩm cũ size mới đã có tồn kho
            $import_product_in_stock= ProductInstock::find($product_in_stock->id);
            $import_product_in_stock->sanphamtonkho_so_luong_ton = $import_product_in_stock->sanphamtonkho_so_luong_ton + $data['product_import_detail_quantity'];
            $import_product_in_stock->sanphamtonkho_gia_ban = $data['product_import_detail_price_retail'];
            $import_product_in_stock->save();//update in stock old new
            $import_product_in_stock_old->sanphamtonkho_so_luong_ton = $import_product_in_stock_old->sanphamtonkho_so_luong_ton -$data['product_import_detail_quantity_old'];
            $import_product_in_stock_old->save();//update in stock old old
            $import_product_detail->chitietnhap_so_luong_nhap = $data['product_import_detail_quantity'];
            $import_product_detail->chitietnhap_gia_nhap = $data['product_import_detail_price'];
            $import_product_detail->chitietnhap_size = $size->size;
            $import_product_detail->size_id = $data['product_import_detail_size_id'];
            $import_product_detail->save();//update detail
            $import_product->donnhaphang_tong_tien = $import_product->donnhaphang_tong_tien +
            (($data['product_import_detail_price']*$data['product_import_detail_quantity'])-($data['product_import_detail_quantity_old']*$data['product_import_detail_price_old']));
            $import_product->save();//update total
        }
        return Redirect::to('/product-import-show-detail/'.$data['product_import_id']);
	}

    public function ProductImportDeletetDetail($product_import_detail_id){
        $this->AuthLogin();
        $product_import_detail=ProductImportDetail::find($product_import_detail_id);
        $product_in_stock=ProductInstock::where('sanpham_id','=', $product_import_detail->sanpham_id)
        ->where('size_id','=',$product_import_detail->size_id)->first();
        if(($product_in_stock->sanphamtonkho_so_luong_ton-$product_import_detail->chitietnhap_so_luong_nhap ) < 0){
            Session::put('message', 'Delete Fail, Quantity Invalid');
            return Redirect::to('/product-import-show-detail/'.$product_import_detail->donnhaphang_id);
        }else if(($product_in_stock->sanphamtonkho_so_luong_ton - $product_import_detail->chitietnhap_so_luong_nhap ) == 0){
            $product_import_update=ProductImport::find($product_import_detail->donnhaphang_id);
            $product_import_update->donnhaphang_tong_tien=$product_import_update->donnhaphang_tong_tien -($product_import_detail->chitietnhap_so_luong_nhap*$product_import_detail->chitietnhap_gia_nhap);
            $product_import_update->save();
            $product_in_stock->sanphamtonkho_so_luong_ton=0;
            $product_in_stock->save();
            $product=Product::find($product_import_detail->sanpham_id);
            $product->sanpham_trang_thai=2;//tạm hết hàng
            $product->save();
        }else{
            $product_import_update=ProductImport::find($product_import_detail->donnhaphang_id);
            $product_import_update->donnhaphang_tong_tien=$product_import_update->donnhaphang_tong_tien -($product_import_detail->chitietnhap_so_luong_nhap*$product_import_detail->chitietnhap_gia_nhap);
            $product_import_update->save();
            $product_in_stock->sanphamtonkho_so_luong_ton =$product_in_stock->sanphamtonkho_so_luong_ton - $product_import_detail->chitietnhap_so_luong_nhap;
            $product_in_stock->save();
            print_r($product_in_stock->sanphamtonkho_so_luong_ton);
        }
        $product_import_detail->delete();
        return Redirect::to('/product-import-show-detail/'.$product_import_detail->donnhaphang_id);
    }

	// public function getSearch(Request $request) {
	// 	return view('admin.pages.product_import.cart');
	// }

	// function getSearchAjax(Request $request) {
	// 	if ($request->get('query')) {
	// 		$query = $request->get('query');
	// 		$data = DB::table('tbl_sanpham')
	// 			->where('sanpham_ten', 'LIKE', "%{$query}%")
	// 			->get();
	// 		$output = '<ul class="dropdown-menu" style="display:block; position:relative">';
	// 		foreach ($data as $row) {
	// 			$output .= '
	//            <li><a href="data/' . $row->id . '">' . $row->sanpham_ten . '</a></li>
	//            ';
	// 		}
	// 		$output .= '</ul>';
	// 		echo $output;
	// 	}
	// }
	// public function home() {
	// 	return view('admin.pages.product_import.demo');
	// }

}
