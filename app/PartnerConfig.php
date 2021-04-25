<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerConfig extends Model
{
    protected $connection = "DB_CFG";
    protected $table = "partnerconfig";

    protected $fillable = [
        'id',
        'partnerconfig_name',
        'partnerconfig_partner_id',
        'partnerconfig_partner_name',
        'partnerconfig_tipe',
        'partnerconfig_tipe_name',
        'partnerconfig_protocol',
        'artnerconfig_method',
        'partnerconfig_url',
        'partnerconfig_bodytype',
        'partnerconfig_auth',
        'partnerconfig_conntype',
        'partnerconfig_timeout',
        'partnerconfig_resptype',
        'partnerconfig_resptype_header',
        'partnerconfig_active',
        'partnerconfig_created_by',
        'partnerconfig_updated_by',
        'created_at',
        'updated_at',
    ];
}
