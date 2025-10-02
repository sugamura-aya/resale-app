<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            //usersテーブルとのリレーションのため、下記外部キーの追加
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //productsテーブルとのリレーションのため、下記外部キーの追加
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('payment_method', ['card', 'convenience_store']); // 選択必須
            $table->string('postcode', 8); //ハイフンありの8文字
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
        Schema::dropIfExists('orders');
    }
}
