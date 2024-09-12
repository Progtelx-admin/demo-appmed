<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMicrobiologyTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_microbiology_test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_microbiology_test_id');
            $table->unsignedBigInteger('test_id');
            $table->integer('antibiotic_id')->nullable();
			$table->string('sensitivity')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('group_microbiology_test_results');
    }
}
