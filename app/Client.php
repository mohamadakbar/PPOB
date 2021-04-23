<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $connection = "mysql2";
    protected $table = "client";

    public function reportingBelongsTo()
    {
        return $this->belongsTo('App\Reporting', 'id_client', 'id');
    }
}
