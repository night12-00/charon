<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('songs', static function (Blueprint $table): void {
            $table->integer('artist_id')->unsigned()->nullable();
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
        });
    }
};
