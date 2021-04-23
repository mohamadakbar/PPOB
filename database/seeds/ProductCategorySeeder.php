<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Telkomsel 5000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Telkomsel 10000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Telkomsel 25000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Telkomsel 50000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);

      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Indosat 5000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Indosat 10000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Indosat 25000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductCategory::create(['product_type_id'=>'1','name'=>'Indosat 50000','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
    }
}
