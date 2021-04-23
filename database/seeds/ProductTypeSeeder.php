<?php

use Illuminate\Database\Seeder;
use App\ProductType;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $prodtype = ProductType::create(['name'=>'Pembelian Pulsa Prepaid','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductType::create(['name'=>'Pembelian PLN Prepaid','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductType::create(['name'=>'Pembelian Paket Data','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductType::create(['name'=>'Pembelian Voucher Game','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
    }
}
