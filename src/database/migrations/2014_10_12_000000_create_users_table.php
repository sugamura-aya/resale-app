<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',20);//入力必須、20文字以内
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('profile_image')->nullable();// 任意
            $table->string('postcode', 8);// バリデーションで「ハイフンを含む8文字」指定だったため、stringで文字列扱い
            $table->string('address');
            $table->string('building')->nullable();// 任意
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
        Schema::dropIfExists('users');
    }
}
