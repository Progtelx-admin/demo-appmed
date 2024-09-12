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
        Schema::create('group_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->double('price');
            $table->boolean('done');
            $table->longText('comment')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->integer('daily_count')->nullable();

            // Foreign key constraints (if necessary)
            // $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            // $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            // $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_services');
    }
};
