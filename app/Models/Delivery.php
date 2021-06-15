<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
    	'giaohang_ma_van_chuyen', 'giaohang_ngay_giao_hang', 'giaohang_nguoi_giao_hang','giaohang_so_dien_thoai','giaohang_trang_thai','dondathang_id','nhanvien_id'
    ];
 	protected $table = 'tbl_giaohang';
}
