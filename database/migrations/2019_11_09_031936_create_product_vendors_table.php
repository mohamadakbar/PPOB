<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVendorsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('product_vendor', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->enum('protocol', ['http', 'https'])->default('http');
          $table->enum('method', ['get', 'post','put','delete'])->default('get');
          $table->string('url');
          $table->enum('body_type', ['form', 'formencode','raw'])->default('form');
          $table->text('params');
          $table->enum('authorization', ['basic', 'key','token'])->nullable();
          $table->text('params_auth');
          $table->enum('header', ['active', 'inactive'])->default('inactive')->nullable();
          $table->enum('contype', ['close', 'alive']);
          $table->integer('timeout')->default('30');
          $table->char('separator',5)->nullable();
          $table->string('success_code')->nullable();
          $table->string('error_code')->nullable();
          $table->integer('rank')->default('0');
          $table->enum('status', ['active', 'inactive'])->default('inactive');
          $table->timestamps();
          $table->string('author')->nullable();
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::dropIfExists('product_vendor');
  }
}
