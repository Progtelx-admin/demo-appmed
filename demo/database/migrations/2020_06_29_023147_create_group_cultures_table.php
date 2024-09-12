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
        Schema::create('group_cultures', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('group_id')->nullable();
            $table->integer('daily_count')->nullable();
            $table->integer('culture_id')->nullable();
            $table->float('price')->nullable();
            $table->boolean('done')->default(0);
            $table->longtext('comment')->nullable();
            $table->string('result')->nullable();
            $table->integer('package_id')->nullable();
            $table->integer('position')->nullable();
            $table->integer('show')->nullable();
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
        Schema::drop('group_cultures');
    }
};
