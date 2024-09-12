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
        Schema::create('group_antibiotics', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('group_id')->nullable();
            $table->unsignedInteger('antibiotic_id')->nullable();
            $table->double('price', 8, 2)->nullable(); // Adjust the precision and scale if needed
            $table->tinyInteger('done')->default(0);
            $table->longText('comment')->nullable();
            $table->unsignedInteger('package_id')->nullable();
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
        Schema::dropIfExists('group_antibiotics');
    }
};
