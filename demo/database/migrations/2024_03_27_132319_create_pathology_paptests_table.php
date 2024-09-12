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
        Schema::create('pathology_paptests', function (Blueprint $table) {
            $table->id();
            $table->string('pathology_id');
            $table->string('sample_conventional')->nullable()->default('0');
            $table->string('sample_other')->nullable();
            $table->string('sample_satisfactory')->nullable()->default('0');
            $table->string('sample_unsatisfactory')->nullable();
            $table->string('sample_negative')->nullable()->default('0');
            $table->string('sample_abnormal')->nullable()->default('0');
            $table->string('reactive_changes')->nullable()->default('0');
            $table->string('inflammation')->nullable()->default('0');
            $table->string('iud')->nullable()->default('0');
            $table->string('repair_changes')->nullable()->default('0');
            $table->string('radiation')->nullable()->default('0');
            $table->string('cylinder_cells')->nullable()->default('0');
            $table->string('squamous_metaplasia')->nullable()->default('0');
            $table->string('atrophy')->nullable()->default('0');
            $table->string('pregnancy_related')->nullable()->default('0');
            $table->string('hormonal_status')->nullable()->default('0');
            $table->string('endometrial_cells')->nullable()->default('0');
            $table->string('squamous_cells')->nullable()->default('0');
            $table->string('atypical_squamous')->nullable()->default('0');
            $table->string('ascus')->nullable()->default('0');
            $table->string('asc_h')->nullable()->default('0');
            $table->string('lsil')->nullable()->default('0');
            $table->string('hsil')->nullable()->default('0');
            $table->string('suspicious_patterns')->nullable()->default('0');
            $table->string('squamous_carcinoma')->nullable()->default('0');
            $table->string('glandular_cells')->nullable()->default('0');
            $table->string('atypical_glandular')->nullable()->default('0');
            $table->string('endocervical')->nullable()->default('0');
            $table->string('endometrial')->nullable()->default('0');
            $table->string('glandular')->nullable()->default('0');
            $table->string('neoplastic_cells')->default('0');
            $table->string('endocervical_in')->default('0');
            $table->string('adenocarcinoma')->default('0');
            $table->string('endocervical_ade')->default('0');
            $table->string('endometrial_ade')->default('0');
            $table->string('other_neoplasm')->nullable();
            $table->string('repeat_treatment')->default('0');
            $table->string('repeat_date')->nullable();
            $table->string('hpv_typing1')->default('0');
            $table->string('hpv_typing2')->default('0');
            $table->string('hpv_typing3')->default('0');
            $table->string('biopsy')->default('0');
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('pathology_paptests');
    }
};
