<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 会員登録まわり
//➀会員登録画面（表示）
Route::get('/register', [UserController::class, 'create'])
    ->name('register.create');

//➀会員登録画面（登録処理）
Route::post('/register', [UserController::class, 'store'])
    ->name('register.store');

//➁プロフィール設定画面（表示）
Route::get('/mypage/profile', [ProfileController::class, 'edit'])
    ->name('mypage.edit');

//➁プロフィール設定画面（登録・更新処理）
Route::patch('/mypage/profile', [ProfileController::class, 'update'])
    ->name('mypage.update');

//➂プロフィール画面（表示）
Route::get('/mypage', [ProfileController::class, 'show'])
    ->name('mypage.show');


//商品まわり
//➀商品一覧画面（トップ画面）（表示）
Route::get('/', [ProductController::class, 'index'])
    ->name('product.index');

//➁商品詳細画面（表示）
Route::get('/item/{item_id}', [ProductController::class, 'show'])
    ->name('product.show');

//➂商品一覧画面＿マイリスト（表示）
Route::get('/?tab=mylist', [ProductController::class, 'index'])
    ->name('product.index');

//➃いいね（登録）
Route::post('/item/{item_id}/like', [LikeController::class, 'store'])
    ->name('product.like');

//➃いいね（解除）
Route::delete('/item/{item_id}/unlike', [LikeController::class, 'destroy'])
    ->name('product.unlike');

//➄商品購入画面（表示）
Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])
    ->name('purchase.create');

//➄商品購入画面（購入処理）
Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])
    ->name('purchase.store');

//➅送付先住所変更画面（表示）
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'edit'])
    ->name('purchase.address.edit');

//➅送付先住所変更画面（変更処理）
Route::patch('/purchase/address/{item_id}', [PurchaseController::class, 'update'])
    ->name('purchase.address.update');

//➆商品出品画面（表示）
Route::get('/sell', [ProductController::class, 'create'])
    ->name('product.create');

//➆商品出品画面（登録処理）
Route::post('/sell', [ProductController::class, 'store'])
    ->name('product.store');

//➇プロフィール画面＿購入した商品一覧（表示）
Route::get('/mypage?page=buy', [ProfileController::class, 'buylist'])
    ->name('mypage.buy');

//➇プロフィール画面＿出品した商品一覧（表示）
Route::get('/mypage?page=sell', [ProfileController::class, 'selllist'])
    ->name('mypage.sell');