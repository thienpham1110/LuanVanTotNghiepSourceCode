<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
    	'size', 'size_trang_thai', 'nhanvien_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_size';
}
