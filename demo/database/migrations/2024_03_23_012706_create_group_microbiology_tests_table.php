<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMicrobiologyTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_microbiology_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->string('barcode')->nullable();
            $table->integer('daily_count')->default(0);
            $table->unsignedBigInteger('test_id');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->boolean('has_results')->default(false);
            $table->boolean('has_entered')->default(false);
            $table->boolean('done')->default(false);
            $table->text('comment')->nullable();
            $table->integer('package_id')->nullable();
            $table->timestamps();

            // $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            // $table->foreign('test_id')->references('id')->on('microbiology_tests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_microbiology_tests');
    }
}
