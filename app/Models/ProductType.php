<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = [
    	'loaisanpham_ten', 'loaisanpham_mo_ta', 'loaisanpham_anh','loaisanpham_trang_thai'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_loaisanpham';
}
