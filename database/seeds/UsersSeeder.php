<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      // Make role admin
      $adminRole = new Role();
      $adminRole->name = "Administrator";
      $adminRole->display_name = "Administrator";
      $adminRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $adminRole->status = "active";
      $adminRole->save();
      // Make role approver
      $approveRole = new Role();
      $approveRole->name = "Approver";
      $approveRole->display_name = "Approver";
      $approveRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $approveRole->status = "active";
      $approveRole->save();
      // Make role checker
      $checkerRole = new Role();
      $checkerRole->name = "Checker";
      $checkerRole->display_name = "Checker";
      $checkerRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $checkerRole->status = "active";
      $checkerRole->save();
      // Make role maker
      $makerRole = new Role();
      $makerRole->name = "Maker";
      $makerRole->display_name = "Maker";
      $makerRole->author = "Administrator - admin.sppob@sprintasia.co.id";
      $makerRole->status = "active";
      $makerRole->save();

      // Make sample admin
      $create = new User();
      $create->name = 'Administrator';
      $create->email = 'admin.sppob@sprintasia.co.id';
      $create->password = bcrypt('sppobadm');
      $create->author = 'Administrator - admin.sppob@sprintasia.co.id';
      $create->status = "active";
      $create->save();
      // $create->attachRole($adminRole);
      // Make sample approver
      $create = new User();
      $create->name = 'Approver';
      $create->email = 'approve.sppob@sprintasia.co.id';
      $create->password = bcrypt('sppobapp');
      $create->author = 'Administrator - admin.sppob@sprintasia.co.id';
      $create->status = "active";
      $create->save();
      // $create->attachRole($approveRole);
      // Make sample checker
      $create = new User();
      $create->name = 'Checker';
      $create->email = 'check.sppob@sprintasia.co.id';
      $create->password = bcrypt('sppobchk');
      $create->author = 'Administrator - admin.sppob@sprintasia.co.id';
      $create->status = "active";
      $create->save();
      // $create->attachRole($checkerRole);
      // Make sample maker
      $create = new User();
      $create->name = 'Maker';
      $create->email = 'make.sppob@sprintasia.co.id';
      $create->password = bcrypt('sppobmke');
      $create->author = 'Administrator - admin.sppob@sprintasia.co.id';
      $create->status = "active";
      $create->save();
      // $create->attachRole($makerRole);

    }
}
