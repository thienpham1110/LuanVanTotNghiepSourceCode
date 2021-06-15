<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
    	'sanpham_id', 'dondathang_id', 'chitietdondathang_don_gia','chitietdondathang_size','chitietdondathang_so_luong',
        'chitietdondathang_tong_tien'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_chitietdondathang';
}
