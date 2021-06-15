<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
    	'tinhthanhpho_name', 'tinhthanhpho_type'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_tinhthanhpho';
}
