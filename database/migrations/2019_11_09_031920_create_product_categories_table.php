<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('product_category', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('product_type_id');
          $table->string('name');
          $table->enum('status', ['active', 'inactive'])->default('inactive');
          $table->timestamps();
          $table->string('author')->nullable();

          $table->foreign('product_type_id')->references('id')->on('product_type')
          ->onUpdate('cascade')->onDelete('cascade');
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::dropIfExists('product_category');
  }
}
