<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    //➃商品購入画面（表示）
    public function create(Request $request,$item_id)
    {
        //ログインしているユーザーを取得
        $user = Auth::user();

        //ルートパスで送られてきた{item_id}で商品取得
        $product = Product::findOrFail($item_id);

        // セッションに住所変更があれば優先
        $postcode = $request->session()->get('postcode', $user->postcode);
        $address = $request->session()->get('address', $user->address);
        $building = $request->session()->get('building', $user->building);

        return view('purchase.create', compact('user','product','postcode','address','building', 'item_id'));
    }


    //➃商品購入画面（購入処理）
    public function store(PurchaseRequest $request,$item_id)
    {
        //ログインしているユーザーを取得
        $user = Auth::user();
        
        //ルートパスで送られてきた{item_id}で商品取得
        $product = Product::findOrFail($item_id);

        //リクエスト内容取得（支払方法など）
        $paymentMethod = $request->input('payment_method');

        $orderData = [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => $paymentMethod,
            'postcode' => $request->session()->get('postcode', $user->postcode),
            'address' => $request->session()->get('address', $user->address),
            'building' => $request->session()->get('building', $user->building),
        ];

        Order::create($orderData);

        // 商品の状態を「Sold」にする
        $product->update(['status' => 1]);

        //セッションの住所を削除
        $request->session()->forget(['postcode','address','building']);

        return redirect()->route('product.index')->with('success-purchase', '商品を購入しました');

    }


    //➄送付先住所変更画面（表示）
    public function edit(Request $request,$item_id)
    {
        //ログインしているユーザーを取得（住所取得）
        $user = Auth::user();

        // 既にセッションに住所がある場合はそちらを優先
        $postcode = $request->session()->get('postcode', $user->postcode);
        $address = $request->session()->get('address', $user->address);
        $building = $request->session()->get('building', $user->building);

        return view('purchase.address', compact('user', 'postcode', 'address', 'building', 'item_id'));
    }


    //➄送付先住所変更画面（変更処理）
    public function update(AddressRequest $request,$item_id)
    {
        $data = $request->only([
            'postcode', 'address', 'building'
        ]);

        // セッションに保存（購入画面で利用）
        $request->session()->put($data);

        return redirect()->route('purchase.create', ['item_id' => $item_id])->with('success', '配送先住所を更新しました'); //['item_id' => $item_id] は ルートパラメータ を渡している
    }

}
