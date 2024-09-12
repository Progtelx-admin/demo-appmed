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
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('name');
            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('title', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->text('token')->nullable();
            $table->text('signature')->nullable();
			$table->text('signature2')->nullable();
			$table->text('signature3')->nullable();
			$table->text('signature4')->nullable();
            $table->string('theme', 191)->nullable();
            $table->string('avatar', 191)->nullable();
            $table->string('last_activity', 191)->nullable();
            $table->string('point_of_sale_id', 191)->nullable();
            $table->string('pos_1_id', 191)->nullable();
            $table->string('pos_2_id', 191)->nullable();
            $table->string('pos_1_name', 191)->nullable();
            $table->string('pos_2_name', 191)->nullable();
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
        Schema::drop('users');
    }
};
