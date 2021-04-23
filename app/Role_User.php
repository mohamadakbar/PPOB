<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_User extends Model
{

  protected $table = 'role_user';

  public function Role()
  {
    return $this->belongsTo('App\Role');
  }

  public function User()
  {
    return $this->belongsTo('App\User');
  }

}
