<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoininTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joinin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_id');
            $table->boolean('hotplace');
            $table->string('country');
            $table->string('state')->nullable();
            $table->enum('gender',['m', 'f'])->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->text('comment');
            $table->timestamps();

            $table->index(['device_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
