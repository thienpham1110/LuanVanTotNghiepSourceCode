<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
    	'makhyenmai_ma', 'makhuyenmai_ten_ma', 'makhuyenmai_so_luong','makhuyenmai_loai_ma','makhuyenmai_gia_tri','makhuyenmai_trang_thai','nhanvien_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_makhuyenmai';
}
