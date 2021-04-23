<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposit';
    protected $fillable = ['date', 'transaction', 'debit', 'credit', 'saldo'];
}
