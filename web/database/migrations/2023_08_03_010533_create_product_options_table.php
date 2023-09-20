<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false)->default('')->comment('variant title');
            $table->string('instruction')->nullable(false)->default('')->comment('variant instruction');
            $table->tinyInteger('option_type')->nullable(false)->default(1)->comment('1: swatch text; 2:swatch color; 3:swatch image');
            $table->tinyInteger('required')->nullable(false)->default(0)->comment('0: not required; 1:required');
            $table->tinyInteger('display_order')->nullable(false)->default(0)->comment('display order');
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
        Schema::dropIfExists('product_options');
    }
}
