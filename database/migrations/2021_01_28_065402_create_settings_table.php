<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name_doctor')->default('Nguyễn Duy Quang');
            $table->string('degree')->default('Ths.Bs');
            $table->string('name_clinic')->default('Phòng khám Nhi Khoa');
            $table->string('phone')->default('0123456789');
            $table->string('address')->default('Cà Mau');
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
        Schema::dropIfExists('settings');
    }
}
