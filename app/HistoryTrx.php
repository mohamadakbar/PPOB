<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryTrx extends Model
{
    protected $connection = "DB_TRX";
    protected $table = 'history_trx';

}
