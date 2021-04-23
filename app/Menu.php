<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection   = "DB_CFG";
    protected $table    = "menu";
    protected $fillable = ['id','parent_id','title','url','menu_order'];
}
