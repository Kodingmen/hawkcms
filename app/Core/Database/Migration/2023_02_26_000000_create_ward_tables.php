<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type');
            $table->string('name_with_type');

            $table->string('path');
            $table->string('path_with_type');
            $table->string('code');
            $table->string('parent_code');
            $table->foreignId('district_id')->references('id')->on('districts');
            //$table->foreignId('category_id')->references('id')->on('categories');
            //$table->foreignId('customer_id')->references('id')->on('customers')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('wards');
    }
};
