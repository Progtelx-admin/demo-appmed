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
        Schema::create('contract_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_id')->nullable();
            $table->string('priceable_type')->nullable();
            $table->bigInteger('priceable_id')->nullable();
            $table->bigInteger('price_id')->nullable();
            $table->float('price')->default(0);
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
        Schema::dropIfExists('contract_prices');
    }
};
