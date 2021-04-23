<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPartner extends Model
{

    protected $connection = "DB_CFG"; // connect to db config
    protected $fillable = ['id', 'partner_name', 'partner_pic', 'partner_nohp', 'partner_email', 'partner_norek',
                            'partner_bank', 'partner_bank_code', 'partner_threshold_deposit', 'partner_deposit', 'partner_del',
                            'partner_active', 'created_at', 'created_by', 'updated_by', 'updated_at'];
    protected $table = 'partner';

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function getBank()
    {
        return $this->hasOne('App\Bank', 'id', 'partner_bank');
    }

    public function reportingBelongsTo()
    {
        return $this->belongsTo('App\Reporting', 'id_partner', 'id');
    }

}
