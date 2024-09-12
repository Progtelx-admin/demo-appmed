<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCashInOutflowsTable extends Migration
{
    public function up()
    {
        Schema::create('cash_in_outflows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('point_of_sale_id');
            $table->decimal('cash_in', 10, 2)->default(0);
            $table->decimal('cash_out', 10, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            // $table->foreign('point_of_sale_id')->references('id')->on('point_of_sales');
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_in_outflows');
    }
}
