<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('medicine_name');
            $table->integer('medicine_amount');
            $table->integer('sell_price');
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_lot');
            $table->unsignedBigInteger('id_unit');
            $table->foreign('id_category')->references('id')->on('med_categories');
            $table->foreign('id_lot')->references('id')->on('lots');
            $table->foreign('id_unit')->references('id')->on('units');
            $table->string('image');
            $table->integer('unit_volume');
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
        Schema::dropIfExists('medicines');
    }
}
