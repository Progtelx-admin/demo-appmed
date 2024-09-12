<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMicrobiologyTestAntibioticResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_microbiology_test_antibiotic_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_microbiology_test_result_id');
            $table->unsignedBigInteger('antibiotic_id');
            $table->string('sensitivity');
            // Add any other columns you need
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
        Schema::dropIfExists('group_microbiology_test_antibiotic_result');
    }
}
