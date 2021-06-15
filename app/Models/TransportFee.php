<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportFee extends Model
{
    protected $fillable = [
    	'tinhthanhpho_id', 'quanhuyen_id', 'xaphuong_id','phivanchuyen_phi_van_chuyen'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_phivanchuyen';
}
