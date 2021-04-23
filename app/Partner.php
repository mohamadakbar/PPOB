<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
   protected $connection = "mysql2";
   protected $table = 'partner';  

   protected $fillable = [
                           'name',
                           'picName',
                           'picEmail',
                           'picPhone',
                           'accountNumber',
                           'bankName',
                           'deposit',
                           'thresholdDeposit',
                           'protocol',
                           'method',
                           'url',
                           'bodytype',
                           'header',
                           'authorization',
                           'timeoutTime',
                           'headerparam',
                           'status',
                           'author',
                           'rcTimeout',
                           'cronInqStatusName',
                           'user_gw',
                           'pass_gw',
                           'logo_image',
                           'connectiontype'
                        ];

   public function productListBelong()
   {
      return $this->belongsTo('App\ProductList', 'partnerId', 'id');
   }
}
