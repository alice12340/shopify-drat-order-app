<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_option_details', function (Blueprint $table) {
            $table->id();
            $table->integer('product_option_id')->nullable(false)->default(0)->comment('Product option id');
            $table->string('product_option_value')->nullable(false)->default('')->comment('Product option value');
            $table->decimal('product_option_price')->nullable(false)->default('0.00')->comment('Product option price');
            $table->string('product_option_description')->nullable(false)->default('')->comment('Product option description');
            $table->tinyInteger('deleted')->nullable(false)->default(0)->comment('0: not deleted; 1: deleted');
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
        Schema::dropIfExists('product_option_details');
    }
}
