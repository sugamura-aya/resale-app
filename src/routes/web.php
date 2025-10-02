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

//認証不要(非認証)でアクセス可能
//➀会員登録画面（表示）
Route::get('/register', [UserController::class, 'create'])
    ->name('register.create');

//➀会員登録画面（登録処理）
Route::post('/register', [UserController::class, 'store'])
    ->name('register.store');

//➁商品一覧画面（トップ画面）（表示）
//タブ切り替えで「商品一覧画面＿マイリスト（/?tab=mylist）※ログインユーザーのみ」表示。（Controller内で認証済みかどうかを判定する形で制御）
Route::get('/', [ProductController::class, 'index'])
    ->name('product.index');

//➂商品詳細画面（表示）
Route::get('/item/{item_id}', [ProductController::class, 'show'])
    ->name('product.show');



// 認証済みユーザーのみアクセスできるグループ
Route::middleware('redirect.if.not.registered')->group(function () {

    //➀プロフィール画面（表示）
    // タブ切り替えで「プロフィール画面＿購入した商品一覧（/mypage?page=buy）」「プロフィール画面＿出品した商品一覧（/mypage?page=sell）」表示。
    Route::get('/mypage', [ProfileController::class, 'show'])
        ->name('mypage.show');

    //➁プロフィール設定画面（表示）
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('mypage.edit');

    //➁プロフィール設定画面（登録・更新処理）
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])
        ->name('mypage.update');

    //➂いいね（登録）
    Route::post('/item/{item_id}/like', [LikeController::class, 'store'])
        ->name('product.like');

    //➂いいね（解除）
    Route::delete('/item/{item_id}/unlike', [LikeController::class, 'destroy'])
        ->name('product.unlike');

    //➃商品購入画面（表示）
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])
        ->name('purchase.create');

    //➃商品購入画面（購入処理）
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])
        ->name('purchase.store');

    //➄送付先住所変更画面（表示）
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'edit'])
        ->name('purchase.address.edit');

    //➄送付先住所変更画面（変更処理）
    Route::patch('/purchase/address/{item_id}', [PurchaseController::class, 'update'])
        ->name('purchase.address.update');

    //➅商品出品画面（表示）
    Route::get('/sell', [ProductController::class, 'create'])
        ->name('product.create');

    //➅商品出品画面（登録処理）
    Route::post('/sell', [ProductController::class, 'store'])
        ->name('product.store');
});



