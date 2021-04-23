<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SprintCode extends Model
{
    protected $connection = "DB_TRX";
    protected $table = 'sprintresponsecode';

    protected $fillable = ['responseCode', 'status', 'description'];
}
