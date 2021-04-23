<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SprintCode extends Model
{
    protected $connection = "mysql3";
    protected $table = 'sprintresponsecode';

    protected $fillable = ['responseCode', 'status', 'description'];
}
