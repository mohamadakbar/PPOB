<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

  protected $connection = "DB_CFG";

  protected $fillable = ['id', 'category_name', 'category_active', 'created_by'];
  protected $table = 'category';

  public function ProductType()
  {
    return $this->hasMany('App\ProductType');
  }
  public function reportingBelongsTo()
  {
    return $this->belongsTo('App\Reporting', 'id_category', 'id');
  }
  public function productBelongsTo()
  {
    return $this->belongsTo('App\Product', 'manproduct_category_id', 'id');
  }

}
