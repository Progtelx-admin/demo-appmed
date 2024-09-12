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
        Schema::create('group_tests', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('group_id')->nullable();
            $table->integer('barcode')->nullable();
            $table->integer('daily_count')->nullable();
            $table->integer('test_id')->nullable();
            $table->float('price')->nullable();
            $table->boolean('has_results')->default(0);
            $table->boolean('has_entered')->default(0);
            $table->boolean('done')->default(0);
            $table->longtext('comment')->nullable();
            $table->string('eritrocitet', 191)->nullable();
            $table->string('leukocitet', 191)->nullable();
            $table->string('trombocitet', 191)->nullable();
            $table->text('description')->nullable();
            $table->integer('package_id')->nullable();
            $table->integer('order')->nullable();
            $table->integer('position')->nullable();
            $table->integer('show')->nullable();
            $table->string('working_place')->nullable();
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
        Schema::drop('group_analyses');
    }
};
