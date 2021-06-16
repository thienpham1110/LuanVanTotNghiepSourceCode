<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'binhluan_ten_nguoi_danh_gia', 'binhluan_noi_dung', 'binhluan_so_sao','binhluan_ngay_danh_gia','binhluan_tra_loi','binhluan_trang_thai','admin_id','khachhang_id','sanpham_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_binhluan';
}
