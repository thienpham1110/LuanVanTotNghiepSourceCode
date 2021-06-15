<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
    	'thuonghieu_ten', 'thuonghieu_mo_ta', 'thuonghieu_anh','thuonghieu_trang_thai'
    ];
    protected $primaryKey = 'id';
 	protected $table = '';
}
