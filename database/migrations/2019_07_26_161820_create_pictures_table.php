<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    public function up(): Void
    {
        Schema::create('pictures', static function (Blueprint $table) {
            $table->increments('id');
            $table->integer('imageable_id')->unsigned();
            $table->string('imageable_type');
            $table->string('filename');
            $table->timestamps();
        });
    }

    public function down(): Void
    {
        Schema::dropIfExists('pictures');
    }
}
