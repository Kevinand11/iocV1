<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    public function up(): Void
    {
        Schema::create('stores', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->json('phone');
            $table->string('link');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down(): Void
    {
        Schema::dropIfExists('stores');
    }
}
