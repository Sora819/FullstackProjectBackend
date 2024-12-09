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
            $table->id();

            $table->unsignedBigInteger('genius_id')->nullable()->comment('Song id in Genius api');
            $table->string('title')->comment('Title of song');
            $table->string('artist')->comment('Artist performing the song');
            $table->string('lyrics')->comment('Lyrics of the song');
            $table->integer('word_count')->comment('Number of distinct words in the lyrics');

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
