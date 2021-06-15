<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
    	'binhluan_nguoi_danh_gia', 'binhluan_noi_dung', 'binhluan_so_sao','binhluan_ngay_danh_gia','binhluan_trang_thai','sanpham_id','khachang_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_binhluan';
}
