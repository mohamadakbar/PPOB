<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
  protected $connection = "DB_CFG";
  protected $fillable = ['producttype_name', 'producttype_category_id', 'producttype_created_by', 'producttype_active'];
  protected $table = 'producttype';

  public function ProductCategories()
  {
    return $this->belongsTo('App\ProductCategory');
  }
  public function reportingBelongsTo()
  {
    return $this->belongsTo('App\Reporting', 'id_type', 'id');
  }
  public function productBelongsTo()
  {
    return $this->belongsTo('App\Product', 'productTypeId', 'id');
  }

  public function ProductCategoryOne()
  {
    return $this->hasOne('App\ProductCategory', 'id', 'producttype_category_id');
  }
}
