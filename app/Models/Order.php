<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'dondathang_ma_don_dat_hang', 'dondathang_ngay_dat_hang', 'dondathang_nguoi_nhan','dondathang_nguoi_nhan_email','dondathang_nguoi_nhan_so_dien_thoai',
        'dondathang_nguoi_nhan_dia_chi','dondathang_ghi_chu','dondathang_tong_tien','dondathang_tinh_trang_giao_hang',
        'dondathang_tinh_trang_thanh_toan','dondathang_trang_thai','khachhang_id','nhanvien_id','khuyenmai_id','phivanchuyen_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_dondathang';
}
