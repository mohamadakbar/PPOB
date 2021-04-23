<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuditTrail extends Model
{	
	public $timestamps = false;
    protected $connection = "mysql5";
    protected $table = "audit_trail";

    protected $fillable = ['audit_menu', 'audit_submenu', 'audit_action', 'audit_desc_before', 'audit_desc_after', 'audit_username'];
}
