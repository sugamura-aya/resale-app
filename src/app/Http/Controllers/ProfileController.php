<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    //➀プロフィール画面（表示）
    // タブ切り替えで「購入した商品一覧（/mypage?page=buy）」「出品した商品一覧（/mypage?page=sell）」表示。
    public function show(Request $request)
    {
        //ログインしているユーザーを取得（表示に必要なのはプロフィール画像、ユーザー名）
        $user = Auth::user();

        // ページの種類を取得（?page=buyか?page=sellか）
        $page = $request->query('page', 'sell');// デフォルトは「出品した商品」

        //出品商品取得
        $sellProducts=Product::where('user_id', Auth::id())->get();

        //購入商品取得
        $orderProducts=Order::where('user_id', Auth::id())->get();

        //タブ切り替え処理（クエリパラメーター?page=buy or ?page=sell で表示切替）※デフォは出品商品一覧
        if ($page === 'sell') {
            $products = $sellProducts;
        } else {
            $products = $orderProducts;
        }
      
        return view('mypage.show', compact('user','products','page'));
    }


    //➁プロフィール設定画面（表示）
    public function edit()
    {
        //ログインしているユーザーを取得(時点で登録されているプロフィール内容を反映表示させるため)
        $user = Auth::user();

        return view('mypage.edit', compact('user'));
    }


    //➁プロフィール設定画面（初回登録&2回目以降更新処理）
    public function update(ProfileRequest $request)
    {
        //ログインしているユーザーを取得(時点で登録されているプロフィール内容を反映表示させるため)
        $user = Auth::user();

        //Requestで送られてきたフォームを取得
        $profileData = $request->only(['name','postcode','address','building']);

        //画像のアップロード
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $profileData['profile_image'] = $path;
        }

        //ログイン中ユーザーのレコードを更新
        Auth::user()->update($profileData);

        return redirect()->route('product.index')
                         ->with('success','プロフィールを更新しました');
    }

}


