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
        Schema::create('patients', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
			$table->string('code')->nullable();
			$table->integer('protocolno')->nullable();
			$table->string('branch_id')->nullable();
			$table->string('collaborator', 250)->nullable();
			$table->string('name')->nullable();
			$table->string('gender')->nullable();
			$table->string('dob')->nullable();
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->string('address')->nullable();
			$table->string('profession')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('comment')->nullable();
            $table->integer('contract_id')->nullable();
            $table->string('theme')->nullable();
            $table->string('country_id')->nullable();
            $table->string('national_id')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('avatar')->nullable();
            $table->string('last_activity')->nullable();
            $table->string('vaccinated')->nullable();
            $table->string('datevaccine1')->nullable();
            $table->string('vaccinemodel')->nullable();
            $table->string('datevaccine2')->nullable();
            $table->string('datevaccine3')->nullable();
            $table->string('api')->nullable();
			$table->softDeletes();
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
        Schema::drop('patients');
    }
};
