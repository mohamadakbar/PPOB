<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Switching extends Model
{
    protected $connection = "mysql3";
    protected $table = 'manageswitching';
}
