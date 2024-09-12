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
        Schema::create('group_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id')->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->double('amount')->default(0);
            $table->string('date')->nullable();
            $table->integer('closed')->default(0);
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
        Schema::dropIfExists('group_payments');
    }
};
