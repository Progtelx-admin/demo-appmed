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
        Schema::create('antibiotics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('shortcut')->nullable();
            $table->longtext('commercial_name')->nullable();
            $table->double('price')->nullable();
            $table->integer('category_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('antibiotics');
    }
};
