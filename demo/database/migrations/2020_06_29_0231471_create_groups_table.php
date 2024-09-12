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
        Schema::create('groups', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
			$table->bigInteger('ackey')->nullable();
			$table->integer('branch_id')->nullable()->unsigned();
			$table->integer('patient_id')->nullable();
			$table->integer('doctor_id')->nullable();
			$table->integer('contract_id')->nullable();
			$table->float('discount')->default(0);
            $table->float('discount_fix')->nullable();
			$table->float('subtotal')->default(0);
			$table->float('total')->default(0);
			$table->float('paid')->default(0);
			$table->float('due')->default(0);
			$table->boolean('done')->default(0);
            $table->tinyInteger('sent');
			$table->text('report_pdf')->nullable();
			$table->text('report_pdf2')->nullable();
			$table->text('report_pdf3')->nullable();
			$table->text('receipt_pdf2')->nullable();
            $table->text('receipt_pdf3')->nullable();
            $table->text('pdf_new')->nullable();
            $table->text('report_uploaded')->nullable();
            $table->text('receipt_pdf')->nullable();
            $table->string('barcode')->nullable();
            $table->float('doctor_commission');
            $table->tinyInteger('uploaded_report');
            $table->tinyInteger('uploaded_report1');
            $table->timestamp('sample_collection_date')->nullable();
            $table->timestamp('pdf_update')->nullable();
            $table->integer('signed_by')->nullable();
            $table->integer('signed_by2')->nullable();
            $table->integer('signed_by3')->nullable();
            $table->integer('signed_by4')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('api');
            $table->string('pos');
            $table->integer('called');
            $table->string('reference')->nullable();
            $table->string('comment')->nullable();
            $table->integer('fiscalized');
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
        Schema::drop('groups');
    }
};
