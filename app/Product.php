<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $connection = "DB_CFG";
    protected $table = "manproduct";

    protected $fillable = [
        'id',
        'manproduct_name',
        'manproduct_code',
        'manproduct_expired',
        'manproduct_price_cashback',
        'manproduct_price_denom',
        'manproduct_price_biller',
        'manproduct_price_admin',
        'manproduct_partner_id',
        'manproduct_category_id',
        'manproduct_method',
        'manproduct_active',
        'manproduct_type_id',
        'created_by',
        'created_at',
        'manproduct_price_bottom',
    ];

    public function ProductTypeOne()
    {
        return $this->hasOne('App\ProductType', 'id', 'manproduct_type_id');
    }

    public function ProductCategoryOne()
    {
        return $this->hasOne('App\ProductCategory', 'id', 'manproduct_category_id');
    }

    public function ProductPartner()
    {
        return $this->hasOne('App\ProductPartner', 'id', 'manproduct_partner_id');
    }

    public function ProductList()
    {
        return $this->belongsTo('App\ProductList', 'manproduct_partner_id', 'productCode');
    }

}
