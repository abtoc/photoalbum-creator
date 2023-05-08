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
        Schema::create('album_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Album::class);
            $table->foreignIdFor(App\Models\Photo::class);
            $table->unsignedBigInteger('page');
            $table->timestamps();

            $table->foreign('album_id')
                ->on('albums')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreign('photo_id')
                ->on('photos')
                ->references('id')
                ->cascadeOnDelete();
            $table->unique([
                'album_id',
                'photo_id',
            ]);
            $table->index([
                'album_id',
                'photo_id',
                'page',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_photos');
    }
};
