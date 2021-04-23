<?php

use Illuminate\Database\Seeder;
use App\ProductVendor;

class ProductVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $prodtype = ProductVendor::create(['name'=>'Butraco1','protocol'=>'http','method'=>'post','url'=>'http://localhost','body_type'=>'formencode','params'=>'u=@u@&p=@p@','authorization'=>'basic','params_auth'=>'u=@u@&p=@p@','header'=>'active','contype'=>'close','timeout'=>'30','separator'=>';','success_code'=>'0,1','error_code'=>'2,3','rank'=>'400','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductVendor::create(['name'=>'Butraco2','protocol'=>'http','protocol'=>'http','protocol'=>'http','method'=>'post','url'=>'http://localhost','body_type'=>'formencode','params'=>'u=@u@&p=@p@','authorization'=>'basic','params_auth'=>'u=@u@&p=@p@','timeout'=>'30','separator'=>';','success_code'=>'0,1','error_code'=>'2,3','header'=>'active','contype'=>'close','rank'=>'300','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductVendor::create(['name'=>'Butraco3','protocol'=>'http','protocol'=>'http','method'=>'post','url'=>'http://localhost','body_type'=>'formencode','params'=>'u=@u@&p=@p@','authorization'=>'basic','params_auth'=>'u=@u@&p=@p@','header'=>'active','timeout'=>'30','separator'=>';','success_code'=>'0,1','error_code'=>'2,3','contype'=>'close','rank'=>'400','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
      $prodtype = ProductVendor::create(['name'=>'Butraco4','protocol'=>'http','method'=>'post','url'=>'http://localhost','body_type'=>'formencode','params'=>'u=@u@&p=@p@','authorization'=>'basic','params_auth'=>'u=@u@&p=@p@','header'=>'active','contype'=>'close','timeout'=>'30','separator'=>';','success_code'=>'0,1','error_code'=>'2,3','rank'=>'100','status'=>'Active','author'=>'Administrator - admin.sppob@sprintasia.co.id']);
    }
}
