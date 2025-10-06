<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'user_id' => 1, // UsersSeederで作ったユーザーのID
            'condition_id' => 1, // ConditionsSeederで作った「良好」
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'status' => 1, // 1=出品中
            'created_at' => now(),
            'updated_at' => now()
        ]);

                DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 2, // 目立った傷や汚れなし
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 3, // やや傷や汚れあり
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 4, // 状態が悪い
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 1,
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 2,
                'name' => 'マイク',
                'price' => 8000,
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 3,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 4,
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 1,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('products')->insert([
            [
                'user_id' => 1,
                'condition_id' => 2,
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}