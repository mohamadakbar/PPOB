<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
   protected $connection = "mysql2";
   protected $table = 'productpartner';  

   protected $fillable = [
                           'productCode',
                           'partnerId',
                           'partnerProductCode',
                           'partnerProductName',
                           'denom',
                           'price',
                           'adminFee',
                           'cashback',
                           'headerInq',
                           'headerPay',
                           'paramInq',
                           'paramPay',
                           'paramDescription',
                           'paramResponse',
                           'paramAmount',
                           'status',
                           'author'
                        ];

   public function partnerOne()
   {
      return $this->hasOne('App\Partner', 'id', 'partnerId');
   }
   public function productOne()
   {
      return $this->hasOne('App\Product', 'productCode', 'productCode');
   }
}
