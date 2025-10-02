<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            //usersテーブルとのリレーションのため、下記外部キーの追加
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //productsテーブルとのリレーションのため、下記外部キーの追加
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->text('body');// 入力必須、255文字以内
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
        Schema::dropIfExists('comments');
    }
}
