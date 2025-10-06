<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // product_id と category_id を固定で紐付け
        DB::table('product_category')->insert([
            ['product_id' => 1, 'category_id' => 1], // 腕時計 - ファッション
            ['product_id' => 1, 'category_id' => 5], // 腕時計 - メンズ

            ['product_id' => 2, 'category_id' => 2], // HDD - 家電

            ['product_id' => 3, 'category_id' => 10], // 玉ねぎ - キッチン

            ['product_id' => 4, 'category_id' => 1], // 革靴 - ファッション
            ['product_id' => 4, 'category_id' => 5], // 革靴 - メンズ

            ['product_id' => 5, 'category_id' => 2], // ノートPC - 家電

            ['product_id' => 6, 'category_id' => 2], // マイク - 家電

            ['product_id' => 7, 'category_id' => 1], // ショルダーバッグ - ファッション
            ['product_id' => 7, 'category_id' => 5], // ショルダーバッグ - メンズ

            ['product_id' => 8, 'category_id' => 10], // タンブラー - キッチン

            ['product_id' => 9, 'category_id' => 2], // コーヒーミル - 家電

            ['product_id' => 10, 'category_id' => 6], // メイクセット - コスメ
        ]);
    }
}
