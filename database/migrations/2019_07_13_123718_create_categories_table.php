<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    public function up(): Void
    {
        Schema::create('categories', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->default(0)->unsigned();
            $table->timestamps();
        });
    }

    public function down(): Void
    {
        Schema::dropIfExists('categories');
    }
}
