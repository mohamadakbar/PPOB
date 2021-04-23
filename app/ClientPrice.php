<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPrice extends Model
{
    protected $connection = "mysql2";
    protected $table = "clientprice";
    protected $primaryKey = 'id';

    protected $fillable = ['client_id','product_id','price_type','price'];
}
