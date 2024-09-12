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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('contract_id')->nullable();
            $table->integer('signed_by')->nullable();
            $table->string('visit_type')->nullable();
            $table->string('diagnosis')->nullable();
            $table->text('anamnesis')->nullable();
            $table->string('therapy', 1500)->nullable();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->integer('zoom_level')->nullable();
            $table->integer('branch_id')->nullable();
            $table->text('visit_address')->nullable();
            $table->text('report_pdf')->nullable();
            $table->string('visit_date')->nullable();
            $table->string('attach')->nullable();
            $table->string('examination', 1500)->nullable();
            $table->string('recommendation', 1500)->nullable();
            $table->boolean('read')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('visits');
    }
};
