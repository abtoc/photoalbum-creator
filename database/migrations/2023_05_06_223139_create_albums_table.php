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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class);
            $table->unsignedSmallInteger('status')->default(0);
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->uuid('uuid');
            $table->unsignedBigInteger('capacity')->default(0);
            $table->unsignedBigInteger('photo_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->cascadeOnDelete();
            $table->index([
                'user_id',
                'title',
            ]);
            $table->index([
                'user_id',
                'updated_at',
            ]);
            $table->index([
                'user_id',
                'status',
            ]);
            $table->index([
                'user_id',
                'status',
                'title',
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
        Schema::dropIfExists('albums');
    }
};
