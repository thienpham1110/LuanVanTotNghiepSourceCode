<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderShow extends Model
{
    protected $fillable = [
    	'headerquangcao_noi_dung', 'headerquangcao_lien_ket', 'headerquangcao_thu_tu','headerquangcao_trang_thai','nhanvien_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_headerquangcao';
}
