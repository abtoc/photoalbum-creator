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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class);
            $table->string('name');
            $table->boolean('favorite')->default(false);
            $table->unsignedBigInteger('capacity')->default(0);
            $table->unsignedBigInteger('album_count')->default(0);
            $table->date('uploaded_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->cascadeOnDelete();
            $table->index([
                'user_id',
                'uploaded_at',
            ]);
            $table->index([
                'user_id',
                'favorite',
            ]);
            $table->index([
                'user_id',
                'album_count',
            ]);
            $table->index([
                'user_id',
                'favorite',
                'uploaded_at',
            ]);
            $table->index([
                'user_id',
                'favorite',
                'album_count',
            ]);
            $table->index([
                'user_id',
                'favorite',
                'album_count',
                'uploaded_at',
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
        Schema::dropIfExists('photos');
    }
};
