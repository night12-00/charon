<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->integer('album_id')->unsigned();
            $table->mediumText('title');
            $table->float('length');
            $table->integer('track');
            $table->integer('disc')->default(1);
            $table->text('lyrics');
            $table->text('path');
            $table->integer('mtime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
