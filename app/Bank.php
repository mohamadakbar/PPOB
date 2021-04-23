<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = "DB_CFG";
    protected $table = "bank";
    protected $fillable = ['id', 'bank_name', 'bank_code'];

    public function ProdPartner()
    {
        return $this->hasOne('App\ProductPartner', 'id', 'partner_bank');
    }
}
