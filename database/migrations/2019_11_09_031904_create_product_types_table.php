<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('product_type', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
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
      Schema::dropIfExists('product_type');
  }
}
