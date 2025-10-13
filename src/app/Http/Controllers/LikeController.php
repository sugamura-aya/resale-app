<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    //➂いいね（登録）
    public function store($item_id)
    {
        //今ログインしているユーザーのIDを取得(いいねは「誰が押したか」が必須のため)
        $userId = Auth::id();

        // 重複登録を防ぐ（すでにいいねしてたら何もしない）
        $alreadyLiked = Like::where('user_id', $userId)
            ->where('product_id', $item_id)
            ->exists();

        //いいねを登録
        if (!$alreadyLiked) {
            Like::create([
                'user_id'=>$userId,
                'product_id'=>$item_id, // $item_idそのままでOK！
            ]);
        }

        return response()->json(['status' => 'ok']);
    }


    //➂いいね（解除）
    public function destroy($item_id)
    {
        //今ログインしているユーザーのIDを取得(いいねは「誰が押したか」が必須のため)
        $userId = Auth::id();

        //いいねを解除
        Like::where('user_id',$userId)
            ->where('product_id',$item_id)
            ->delete();

        return response()->json(['status' => 'ok']);
    }
}
