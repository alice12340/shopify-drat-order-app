<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options_relations', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable(false)->defaultValue('')->comment('Product id');
            $table->integer('product_variant_id')->nullable(false)->defaultValue(0)->comment('Product variant id');
            $table->tinyInteger('deleted')->nullable(false)->defaultValue(0)->comment('0: default; 1: deleted');
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
        Schema::dropIfExists('product_options_relations');
    }
}
