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
        Schema::create('group_test_results', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('group_test_id')->nullable();
            $table->integer('test_id')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->nullable();
            $table->string('idsnp')->nullable();
			$table->string('genotype')->nullable();
            $table->string('status2')->nullable();
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
        Schema::drop('group_analysis_results');
    }
};
