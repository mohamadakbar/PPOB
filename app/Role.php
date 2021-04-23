<?php

namespace App;

use Laratrust\Models\LaratrustRole;
use DB;


class Role extends LaratrustRole
{
    protected $connection = "DB_CFG";
    protected $table = "user_groups";

    public function Role_Users()
    {
        return $this->hasMany('App\Role_User');
    }

    public function User()
    {
        return $this->hasMany('App\User');
    }

    public static function Roles($email)
    {
        $ret = DB::connection('DB_CFG')
            ->table('user_groups')
            ->join('users', 'users.role_id', '=', 'user_groups.id')
            ->select('user_groups.*')
            ->where('users.username', $email)
            ->orWhere('users.email', $email)
            ->first();
        return $ret;
    }
}
