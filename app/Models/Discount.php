<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'khuyenmai_tieu_de', 'khuyenmai_noi_dung', 'khuyenmai_anh','khuyenmai_gia_tri',
        'khuyenmai_thoi_gian','khuyenmai_trang_thai'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_khuyenmai';
}
