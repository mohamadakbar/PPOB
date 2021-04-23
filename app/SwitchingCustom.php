<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SwitchingCustom extends Model
{
    protected $connection = "mysql3";
    protected $table = 'switchingcustom';
}
