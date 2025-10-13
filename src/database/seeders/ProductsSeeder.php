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
            'image' => 'products/armani_mens_clock.jpg',
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
                'image' => 'products/hdd_hard_disk.jpg',
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
                'image' => 'products/onion3.jpg',
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
                'image' => 'products/leather_shoes.jpg',
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
                'image' => 'products/laptop.jpg',
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
                'image' => 'products/mic.jpg',
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
                'image' => 'products/shoulder_bag.jpg',
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
                'image' => 'products/tumbler.jpg',
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
                'image' => 'products/coffee_mill.jpg',
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
                'image' => 'products/makeup_set.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}