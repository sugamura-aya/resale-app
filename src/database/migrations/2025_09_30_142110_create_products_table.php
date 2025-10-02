<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            //usersテーブルとのリレーションのため、下記外部キーの追加
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //conditionsテーブルとのリレーションのため、下記外部キーの追加
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('image');
            $table->string('brand')->nullable(); // 任意
            $table->integer('price');
            $table->text('description');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('products');
    }
}
