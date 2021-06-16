<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'khuyenmai_id', 'sanpham_id'
    ];
 	protected $table = 'tbl_sanphamkhuyenmai';
}
