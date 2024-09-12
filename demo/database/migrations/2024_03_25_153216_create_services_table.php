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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shortcut')->nullable();
            $table->string('commercial_name')->nullable();
            $table->decimal('price', 8, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('pantheon_id')->nullable();

            // If category_id is a foreign key, add the constraint
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
