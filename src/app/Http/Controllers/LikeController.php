<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Product; 

class LikeController extends Controller
{
    //➂いいね（登録）
    public function store($item_id)
    {
        //今ログインしているユーザーのIDを取得(いいねは「誰が押したか」が必須のため)
        $userId = Auth::id();
        $isLiked = false; // 初期値

        // 重複登録を防ぐ（すでにいいねしてたら何もしない）
        $alreadyLiked = Like::where('user_id', $userId)
            ->where('product_id', $item_id)
            ->exists();

        //いいねを登録
        if (!$alreadyLiked) {
            Like::create([
                'user_id'=>$userId,
                'product_id'=>$item_id, 
            ]);
            $isLiked = true; // 登録したので状態をtrueにする
        } else {
            // すでに登録されていた場合も、いいね状態はtrue
            $isLiked = true;
        }

        // 商品の総いいね数を再計算
        $likesCount = Like::where('product_id', $item_id)->count();

        //json形式:ブラウザをリロードせずにいいねボタンの見た目だけをサッと切り替えるときに使用
        return response()->json([
            'status' => 'ok',
            'isLiked' => $isLiked,
            'likesCount' => $likesCount,
        ]);
    }


    //➂いいね（解除）
    public function destroy($item_id)
    {
        //今ログインしているユーザーのIDを取得(いいねは「誰が押したか」が必須のため)
        $userId = Auth::id();
        $isLiked = false; // 初期値

        //いいねを解除
        Like::where('user_id',$userId)
            ->where('product_id',$item_id)
            ->delete();

        // 商品の総いいね数を再計算
        $likesCount = Like::where('product_id', $item_id)->count();

        return response()->json([
            'status' => 'ok',
            'isLiked' => $isLiked,
            'likesCount' => $likesCount,
        ]);
    }
}
