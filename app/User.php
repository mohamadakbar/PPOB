<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    protected $connection = "DB_CFG";

    public function Role_Users()
    {
      return $this->hasMany('App\Role_User');
    }

      public function Role()
      {
        return $this->belongsTo('App\Role');
      }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name', 'email', 'password', 'username', 'id_client', 'status', 'id_product', 'phonenumber',
		    'id', 'name','username','id_product','id_client','phonenumber','email' ,'email_verified_at',  'password','role_id',  'remember_token','status',  'created_at','updated_at','author',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
