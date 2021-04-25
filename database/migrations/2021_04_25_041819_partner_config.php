<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartnerConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('partnerconfig_name');
            $table->string('partnerconfig_partner_id');
            $table->string('partnerconfig_partner_name');
            $table->string('partnerconfig_tipe');
            $table->string('partnerconfig_tipe_name');
            $table->string('partnerconfig_protocol');
            $table->string('artnerconfig_method');
            $table->string('partnerconfig_url');
            $table->string('partnerconfig_bodytype');
            $table->string('partnerconfig_auth');
            $table->string('partnerconfig_conntype');
            $table->string('partnerconfig_timeout');
            $table->string('partnerconfig_resptype');
            $table->string('partnerconfig_resptype_header');
            $table->string('partnerconfig_active');
            $table->string('partnerconfig_updated_by');
            $table->string('partnerconfig_created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
