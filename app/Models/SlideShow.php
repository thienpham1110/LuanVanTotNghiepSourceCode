<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideShow extends Model
{
    protected $fillable = [
    	'slidequangcao_tieu_de', 'sildequangcao_noi_dung', 'sildequangcao_anh','slidequangcao_lien_ket','slidequangcao_thu_tu',
        'slidequangcao_trang_thai','nhanvien_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_slidequangcao';
}
