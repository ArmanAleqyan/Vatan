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
        Schema::create('tranzactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('service_id')->nullable();
            $table->string('price')->nullable();
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
        Schema::dropIfExists('tranzactions');
    }
};
