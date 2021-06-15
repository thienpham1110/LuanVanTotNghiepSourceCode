<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
    	'dongsanpham_ten', 'dongsanpham_mo_ta', 'dongsanpham_anh','dongsanpham_trang_thai'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_dongsanpham';
}
