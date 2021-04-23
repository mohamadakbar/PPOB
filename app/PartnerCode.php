<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerCode extends Model
{
    protected $connection = "mysql3";
    protected $table = 'partnerresponsecode';

    protected $fillable = ['partner', 'responseCode', 'markedas', 'description'];
}
