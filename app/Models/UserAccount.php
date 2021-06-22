<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable = [
    	'user_ten','user_email','user_password','loainguoidung_id','remember_token'
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_user';

     public function Customer(){
        return $this->hasMany('App\Models\Customer');
    }
    public function Admin(){
        return $this->hasMany('App\Models\Admin');
    }
}
