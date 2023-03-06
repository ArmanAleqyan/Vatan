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
        Schema::create('buy_vatan_service_tranzactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('service_id')->nullable();
            $table->string('tranzaction_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('buy_vatan_service_tranzactions');
    }
};
