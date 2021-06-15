<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'sanpham_ma_san_pham', 'sanpham_ten', 'sanpham_mo_ta','sanpham_anh','sanpham_nguoi_su_dung','sanpham_mau_sac',
        'sanpham_tinh_nang','sanpham_noi_san_xuat','sanpham_phu_kien','sanpham_chat_lieu','sanpham_bao_hanh',
        'sanpham_khuyen_mai','sanpham_trang_thai','loaisanpham_id','thuonghieu_id','dongsanpham_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_sanpham';
}
