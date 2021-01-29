<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionMedicineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_medicine', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prescrition');
            $table->unsignedBigInteger('id_medicine');
            $table->integer('amount');
            $table->tinyInteger('morning')->nullable();
            $table->tinyInteger('midday')->nullable();
            $table->tinyInteger('afternoon')->nullable();
            $table->tinyInteger('evening')->nullable();
            $table->string('note_morning')->nullable();
            $table->string('note_midday')->nullable();
            $table->string('note_afternoon')->nullable();
            $table->string('note_evening')->nullable();
            $table->tinyInteger('number_of_day');
            $table->Integer('sell_price');
            $table->Integer('unit_sell_price');
            $table->enum('sell_mode',['original','discount']);
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
        Schema::dropIfExists('prescription_medicine');
    }
}
