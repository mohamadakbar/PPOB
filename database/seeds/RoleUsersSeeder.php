<?php

use Illuminate\Database\Seeder;
use App\Role_User;

class RoleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Make role users
      $adminRole = new Role_User();
      $adminRole->role_id = "1";
      $adminRole->user_id = "1";
      $adminRole->user_type = "App\User";
      $adminRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $adminRole->status = "active";
      $adminRole->save();

      $adminRole = new Role_User();
      $adminRole->role_id = "2";
      $adminRole->user_id = "2";
      $adminRole->user_type = "App\User";
      $adminRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $adminRole->status = "active";
      $adminRole->save();

      $adminRole = new Role_User();
      $adminRole->role_id = "3";
      $adminRole->user_id = "3";
      $adminRole->user_type = "App\User";
      $adminRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $adminRole->status = "active";
      $adminRole->save();

      $adminRole = new Role_User();
      $adminRole->role_id = "4";
      $adminRole->user_id = "4";
      $adminRole->user_type = "App\User";
      $adminRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $adminRole->status = "active";
      $adminRole->save();

    }
}
