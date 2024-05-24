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
        Schema::create('bill_models', function (Blueprint $table) {
            $table->id();
            $table->integer('units')->nullable(false);
            $table->enum('Tariff', ['LT-1A'])->nullable(false); 
            $table->enum('Purpose', ['Domestic'])->nullable(false); 
            $table->string('BillingCycle')->nullable(false);
            $table->string('Phase')->nullable(false);
            $table->integer('total_cost')->nullable();
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
        Schema::dropIfExists('bill_models');
    }
};
