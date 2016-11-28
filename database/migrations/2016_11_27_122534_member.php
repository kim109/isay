<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Member extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')
            $table->unsignedInteger('Total');
            $table->unsignedInteger('Seoul');
            $table->unsignedInteger('Busan');
            $table->unsignedInteger('Incheon');
            $table->unsignedInteger('Daejeon');
            $table->unsignedInteger('Daegu');
            $table->unsignedInteger('Gwangju');
            $table->unsignedInteger('Ulsan');
            $table->unsignedInteger('Sejongsi');
            $table->unsignedInteger('Gyeonggi-do');
            $table->unsignedInteger('Gangwon-do');
            $table->unsignedInteger('Chungcheongbuk-do');
            $table->unsignedInteger('Chungcheongnam-do');
            $table->unsignedInteger('Jeollabuk-do');
            $table->unsignedInteger('Jeollanam-do');
            $table->unsignedInteger('Gyeongsangbuk-do');
            $table->unsignedInteger('Gyeongsangnam-do');
            $table->unsignedInteger('Jeju-do');
            $table->json('World');
            $table->json('Info');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
