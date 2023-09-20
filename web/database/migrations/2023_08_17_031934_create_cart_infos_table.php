<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_infos', function (Blueprint $table) {
            $table->id();
            $table->string('cart_id')->nullable(false)->default('')->comment('cart id');
            $table->text('cart_info')->default('')->nullable(false)->comment('cart info');
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
        Schema::dropIfExists('cart_infos');
    }
}
