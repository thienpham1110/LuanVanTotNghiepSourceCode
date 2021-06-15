<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
    	'nhacungcap_ten', 'nhacungcap_dia_chi', 'nhacungcap_so_dien_thoai','nhacungcap_email','nhacungcap_trang_thai'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_nhacungcap';
}
