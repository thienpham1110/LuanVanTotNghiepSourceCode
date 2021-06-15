<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogNews extends Model
{
    protected $fillable = [
    	'baiviet_tieu_de', 'baiviet_noi_dung', 'baiviet_anh','thuonghieu_trang_thai','nhanvien_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_baiviet';
}
