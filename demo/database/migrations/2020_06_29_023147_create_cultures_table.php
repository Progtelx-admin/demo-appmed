<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('name2')->nullable();
            $table->string('sample_type')->nullable();
            $table->text('precautions')->nullable();
            $table->double('price')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('pantheon_id')->nullable();
            $table->integer('position')->nullable();
            $table->softDeletes();
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
        Schema::drop('cultures');
    }
};
