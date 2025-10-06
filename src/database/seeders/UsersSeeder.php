<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // パスワードはハッシュ化
            'postcode' => 1234567,
            'address' => '東京都新宿区',
            'building' => 'テストビル',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
