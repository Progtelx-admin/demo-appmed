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
        Schema::create('pathologies', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->nullable();
            $table->string('visit_type')->nullable();
            $table->string('clinical_diagnosis')->nullable();
            $table->string('reference')->nullable();
            $table->string('doctor_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('births')->nullable();
            $table->string('abortions')->nullable();
            $table->string('menstrual_cycle')->nullable();
            $table->string('pap_tests')->nullable();
            $table->string('hysterectomy')->nullable();
            $table->string('chemotherapy')->nullable();
            $table->string('radiation')->nullable();
            $table->string('hormonal_therapy')->nullable();
            $table->string('cytological_examination')->nullable();
            $table->string('microscopic_examination')->nullable();
            $table->string('macroscopic_examination')->nullable();
            $table->string('histopathological')->nullable();
            $table->string('sample')->nullable();
            $table->string('pathologist')->nullable();
            $table->tinyInteger('read')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('report')->nullable();
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
        Schema::dropIfExists('pathologies');
    }
};
