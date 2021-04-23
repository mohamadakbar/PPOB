<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $prodtype = Product::create([
          'id_type'=>'1',
          'id_category'=>'1',
          'id_vendor'=>'1',
          'product_code'=>'1',
          'vendor_product_code'=>'1',
          'name'=>'TSEL5',
          'denomination'=>'1',
          'product_price'=>'1',
          'vendor_product_price'=>'1',
          'discount_type'=>'1',
          'discount_value'=>'1',
          'status'=>'Active',
          'author'=>'Administrator - admin.sppob@sprintasia.co.id'
        ]);

        $prodtype = Product::create([
            'id_type'=>'1',
            'id_category'=>'1',
            'id_vendor'=>'1',
            'product_code'=>'1',
            'vendor_product_code'=>'2',
            'name'=>'TSEL10',
            'denomination'=>'1',
            'product_price'=>'1',
            'vendor_product_price'=>'1',
            'discount_type'=>'1',
            'discount_value'=>'1',
            'status'=>'Active',
            'author'=>'Administrator - admin.sppob@sprintasia.co.id'
          ]);

          $prodtype = Product::create([
              'id_type'=>'1',
              'id_category'=>'1',
              'id_vendor'=>'1',
              'product_code'=>'1',
              'vendor_product_code'=>'3',
              'name'=>'TSEL20',
              'denomination'=>'1',
              'product_price'=>'1',
              'vendor_product_price'=>'1',
              'discount_type'=>'1',
              'discount_value'=>'1',
              'status'=>'Active',
              'author'=>'Administrator - admin.sppob@sprintasia.co.id'
            ]);
    }
}
