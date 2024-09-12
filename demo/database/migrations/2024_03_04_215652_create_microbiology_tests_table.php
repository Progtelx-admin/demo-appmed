<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicrobiologyTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbiology_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name', 191);
            $table->string('name2', 250)->nullable();
            $table->string('shortcut', 191)->nullable();
            $table->string('sample_type', 191)->nullable();
            $table->string('unit', 191)->nullable();
            $table->text('reference_range')->nullable();
            $table->text('reference_range2')->nullable();
            $table->string('type')->nullable();
            $table->tinyInteger('separated')->default(0);
            $table->double('price')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('title')->default(0);
            $table->text('precautions')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('category_id');
            $table->string('pantheon_id', 191)->nullable();
            $table->integer('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('microbiology_tests');
    }
}
