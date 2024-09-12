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
        Schema::create('laboratories', function (Blueprint $table) {
            $table->integer('ResultDetailPK')->unsigned();
            $table->string('ResultMasterFK');
            $table->string('AnalyzerNo');
            $table->string('SampleNo');
            $table->datetime('ResultTransferDtTm');
            $table->datetime('ResultAnalysisDtTm')->nullable();
            $table->string('AnalyzerTestParam');
            $table->string('ResultValue');
            $table->string('ResultValue2')->nullable();
            $table->string('ResultValueFlag')->nullable();
            $table->string('SampleType')->nullable();
            $table->string('ResultUnit')->nullable();
            $table->string('ReferenceRange')->nullable();
            $table->string('IsResultValueRead');
            $table->string('LIMSTestParam');
            $table->string('LIMSData1')->nullable();
            $table->string('LIMSData2')->nullable();
            $table->string('LIMSData3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratories');
    }
};
