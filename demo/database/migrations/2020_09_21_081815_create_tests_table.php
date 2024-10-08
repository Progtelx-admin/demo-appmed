<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('parent_id')->nullable();
			$table->integer('category_id')->nullable();
			$table->string('name')->nullable();
			$table->string('name2', 250)->nullable();
			$table->string('shortcut')->nullable();
			$table->string('sample_type')->nullable();
			$table->string('unit')->nullable();
			$table->string('work_method')->nullable();
			$table->string('sample_amount')->nullable();
			$table->string('tube_type')->nullable();
			$table->string('workplace')->nullable();
			$table->string('pantheon_id')->nullable();
			$table->integer('position')->nullable();
			$table->text('reference_range')->nullable();
			$table->text('reference_range2')->nullable();
			$table->text('type')->bullable();
			$table->boolean('separated')->default(0);
			$table->double('price')->default(0);
			$table->boolean('status')->default(0);
			$table->boolean('title', 1)->nullable()->default(0);
			$table->text('precautions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('analyses');
    }
};
