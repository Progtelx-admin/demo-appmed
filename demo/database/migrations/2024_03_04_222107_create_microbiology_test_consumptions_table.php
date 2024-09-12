<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicrobiologyTestConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microbiology_test_consumptions', function (Blueprint $table) {
            $table->id();
            $table->string('testable_type', 191);
            $table->unsignedBigInteger('testable_id');
            $table->integer('product_id');
            $table->double('quantity', 8, 2);
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
        Schema::dropIfExists('microbiology_test_consumptions');
    }
}
