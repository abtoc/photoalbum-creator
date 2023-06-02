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
        Schema::create('category_photo', function (Blueprint $table) {
            $table->foreignIdFor(App\Models\Category::class);
            $table->foreignIdFor(App\Models\Photo::class);

            $table->primary(['category_id', 'photo_id']);
            $table->foreign('category_id')
                ->on('categories')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreign('photo_id')
                ->on('photos')
                ->references('id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_photo');
    }
};
