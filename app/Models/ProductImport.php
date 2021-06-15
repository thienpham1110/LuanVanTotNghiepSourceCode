<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImport extends Model
{
    protected $fillable = [
    	'donnhaphang_ma_don_nhap_hang', 'donnhaphang_ngay_nhap', 'donnhaphang_tong_tien','donnhaphang_trang_thai','nhacungcap_id','nhanvien_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_donnhaphang';
}
