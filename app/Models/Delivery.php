<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'giaohang_ngay_giao_hang', 'giaohang_nguoi_nhan','giaohang_nguoi_nhan_email','giaohang_nguoi_nhan_so_dien_thoai',
        'giaohang_nguoi_nhan_dia_chi','giaohang_so_dien_thoai','giaohang_trang_thai','dondathang_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_giaohang';
}
