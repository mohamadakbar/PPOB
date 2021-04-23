<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('products', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('id_type');
          $table->unsignedBigInteger('id_category');
          $table->unsignedBigInteger('id_vendor');
          $table->char('product_code',15);
          $table->char('vendor_product_code',15);
          $table->string('name');
          $table->double('denomination', 10);
          $table->double('product_price', 10);
          $table->double('vendor_product_price', 10);
          $table->enum('discount_type', ['none','discount','price cut', 'cashback'])->default('none');
          $table->bigInteger('discount_value');
          $table->enum('status', ['active', 'inactive'])->default('inactive');
          $table->timestamps();
          $table->string('author')->nullable();

          $table->foreign('id_type')->references('id')->on('product_type')
          ->onUpdate('cascade')->onDelete('cascade');
          $table->foreign('id_category')->references('id')->on('product_category')
          ->onUpdate('cascade')->onDelete('cascade');
          $table->foreign('id_vendor')->references('id')->on('product_vendor')
          ->onUpdate('cascade')->onDelete('cascade');

          $table->unique(['product_code', 'vendor_product_code']);

      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::dropIfExists('products');
  }
}
