<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Make sample client
      $create = new Client();
      $create->name = 'Bank BCA';
      $create->username = 'bankbca';
      $create->password = base64_encode('b4nk8c4');
      $create->ip_source = '172.0.0.1';
      $create->author = 'Administrator - admin.sppob@sprintasia.co.id';
      $create->status = "active";
      $create->save();

      $create = new Client();
      $create->name = 'Bank BRI';
      $create->username = 'bankbri';
      $create->password = base64_encode('b4nk8r1');
      $create->ip_source = '172.0.0.1';
      $create->author = 'Administrator - admin.sppob@sprintasia.co.id';
      $create->status = "active";
      $create->save();

    }
}
