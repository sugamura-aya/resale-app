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

        if ($user) {

            //【出品商品取得】
            $sellProducts = Product::where('user_id', $user->id)->get();

            //【購入商品取得】
            //手順➀：リレーションを使ってProductモデルを取得
            $orders = Order::where('user_id', $user->id)
                        ->with('product') // 紐づく商品情報をロード
                        ->get();

            //手順➁：➀から商品情報のみを抽出→購入商品取得
            $orderProducts = $orders->pluck('product') // OrderからProductモデルを抜き出す(productというキーのみの情報にする処理)
                        ->filter() // nullを除去
                        ->unique('id'); // 重複を排除

        } else {
            $sellProducts = collect(); // 空のコレクションを返す
            $orderProducts = collect(); // 空のコレクションを返す
        }

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

        // ダミー値のクリーニング 
        // もし郵便番号が'000-0000'なら、表示時に空欄にする
        if ($user && $user->postcode === '000-0000') {
            $user->postcode = null; // または $user->postcode = '';
        }
        // もし住所が'未入力'なら、表示時に空欄にする
        if ($user && $user->address === '未入力') {
            $user->address = null; // または $user->address = '';
        }

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
        $user->update($profileData);

        return redirect()->route('product.index')
                         ->with('success-mypage','プロフィールを更新しました');
    }

}


