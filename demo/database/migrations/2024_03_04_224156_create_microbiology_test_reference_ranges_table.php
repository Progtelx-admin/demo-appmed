<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicrobiologyTestReferenceRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbiology_test_reference_ranges', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('test_id');
            $table->string('gender', 191)->nullable();
            $table->string('age_unit', 191)->nullable();
            $table->double('age_from')->nullable();
            $table->double('age_from_days')->nullable();
            $table->double('age_to')->nullable();
            $table->double('age_to_days')->nullable();
            $table->string('critical_low_from', 191)->nullable();
            $table->string('normal_from', 191)->nullable();
            $table->string('normal_to', 191)->nullable();
            $table->string('critical_high_from', 191)->nullable();
            $table->string('critical_extra_from', 191)->nullable();
            $table->string('low_risk', 191)->nullable();
            $table->string('moderate_risk', 191)->nullable();
            $table->string('high_risk', 191)->nullable();
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
        Schema::dropIfExists('microbiology_test_reference_ranges');
    }
}
