<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpCodesTable extends Migration
{
    public function up()
    {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('code');
            $table->boolean('verified')->default(false);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('otp_codes');
    }
}
