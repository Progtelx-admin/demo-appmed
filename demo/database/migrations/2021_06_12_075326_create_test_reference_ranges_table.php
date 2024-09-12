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
        Schema::create('test_reference_ranges', function (Blueprint $table) {
            $table->id();
            $table->integer('test_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('age_unit')->nullable();
            $table->double('age_from')->nullable();
            $table->double('age_from_days')->nullable();
            $table->double('age_to')->nullable();
            $table->double('age_to_days')->nullable();
            $table->string('critical_low_from')->nullable();
            $table->string('normal_from')->nullable();
            $table->string('normal_to')->nullable();
            $table->string('critical_high_from')->nullable();
            $table->string('critical_extra_from')->nullable();
            $table->string('low_risk')->nullable();
            $table->string('moderate_risk')->nullable();
            $table->string('high_risk')->nullable();
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
        Schema::dropIfExists('tests_reference_ranges');
    }
};
