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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->integer('zoom_level')->nullable();
            $table->tinyInteger('show_header_image')->default(0);
            $table->tinyInteger('show_watermark_image')->default(0);
            $table->tinyInteger('show_footer_image')->default(0);
            $table->integer('show_qrcode');
            $table->string('header_image')->nullable();
            $table->string('watermark_image')->nullable();
            $table->string('footer_image')->nullable();
            $table->longText('report_footer')->nullable();
            $table->string('fiskal_no');
            $table->string('email');
            $table->string('protocol_cert')->nullable();
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
        Schema::dropIfExists('branches');
    }
};
