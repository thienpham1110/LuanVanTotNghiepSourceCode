<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImportDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'chitietnhap_so_luong_nhap', 'chitietnhap_so_luong_da_ban', 'chitietnhap_so_luong_con_lai','chitietnhap_gia_nhap',
        'chitietnhap_gia_ban','chitietnhap_size','sanpham_id','donnhaphang_id'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_chitietnhap';

    public function ProductImport(){
        return $this->belongsTo('App\Models\ProductImport','donnhaphang_id');
    }
    public function Product(){
        return $this->belongsTo('App\Models\Product','sanpham_id');
    }
}
