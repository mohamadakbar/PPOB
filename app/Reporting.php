<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporting extends Model
{
    protected $connection = "mysql4";
    protected $table = 'reporting';

    public function productPartnerOne()
    {
        return $this->hasOne('App\ProductPartner', 'id', 'id_partner');
    }
    public function productTypeOne()
    {
        return $this->hasOne('App\ProductType', 'id', 'id_type');
    }
    public function productCategoryOne()
    {
        return $this->hasOne('App\ProductCategory', 'id', 'id_category');
    }
    public function clientOne()
    {
        return $this->hasOne('App\Client', 'id', 'id_client');
    }
}
