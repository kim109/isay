<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->unsignedInteger('Total')->default(0);
            $table->unsignedInteger('HotPlace')->default(0);
            $table->unsignedInteger('Seoul')->default(0);
            $table->unsignedInteger('Busan')->default(0);
            $table->unsignedInteger('Incheon')->default(0);
            $table->unsignedInteger('Daejeon')->default(0);
            $table->unsignedInteger('Daegu')->default(0);
            $table->unsignedInteger('Gwangju')->default(0);
            $table->unsignedInteger('Ulsan')->default(0);
            $table->unsignedInteger('Sejongsi')->default(0);
            $table->unsignedInteger('Gyeonggi-do')->default(0);
            $table->unsignedInteger('Gangwon-do')->default(0);
            $table->unsignedInteger('Chungcheongbuk-do')->default(0);
            $table->unsignedInteger('Chungcheongnam-do')->default(0);
            $table->unsignedInteger('Jeollabuk-do')->default(0);
            $table->unsignedInteger('Jeollanam-do')->default(0);
            $table->unsignedInteger('Gyeongsangbuk-do')->default(0);
            $table->unsignedInteger('Gyeongsangnam-do')->default(0);
            $table->unsignedInteger('Jeju-do')->default(0);
            $table->json('World')->default(0);
            $table->json('Info')->default(0);
            $table->timestamps();

            $table->index('date');
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
