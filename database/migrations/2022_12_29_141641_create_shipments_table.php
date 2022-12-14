<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->boolean('isApproved');
            $table->unsignedBigInteger('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles')->cascadeOnDelete();

            $table->unsignedBigInteger('to');
            $table->foreign('to')->references('id')->on('branches')->cascadeOnDelete();

            $table->unsignedBigInteger('from');
            $table->foreign('from')->references('id')->on('branches')->cascadeOnDelete();
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
        Schema::dropIfExists('shipments');
    }
};