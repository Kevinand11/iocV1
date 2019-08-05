<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up(): Void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->json('phone');
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->longText('passportToken')->nullable();
            $table->timestamps();
        });
    }

    public function down(): Void
    {
        Schema::dropIfExists('users');
    }
}
