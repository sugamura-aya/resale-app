<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Product; 
use App\Models\Category; 
use App\Http\Requests\ExhibitionRequest;

class ProductController extends Controller
{
    //➁商品一覧画面（トップ画面）（表示）
    public function index(Request $request)
    {        
        // タブの種類を取得（?tab=mylistか/か）
        $tab = $request->query('tab', 'all');

        //検索キーワードをRequestから取得
        $keyword = $request->input('keyword');

        // 全商品取得：クエリビルダ作成（検索＋絞り込みと、条件が追加されているためクエリビルダ）
        $query = Product::query()
                        ->with('categories') //リレーション先のｶﾃｺﾞﾘも一緒に取得
                        ->withCount(['orders','likes']); //購入数といいね数をカウント(Blade 側で $product->orders_count>0でsold判定)     

        // 部分一致で絞り込み(!empty($keyword) → 値が入っている場合だけtrue)
        if (!empty($keyword)) {
            $query->nameSearch($keyword); 
        }

        // ログインユーザー自身の出品商品は非表示
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        // マイリストタブの場合、ログインユーザーのいいね商品に絞る
        if ($tab === 'mylist' && Auth::check()) {
            $query->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id()); //→ Likesテーブルのなかでログインユーザーがいいねしたものだけ に絞り込み
            });
        }

        // 並べ替え
        $products = $query
            ->orderByDesc('likes_count')//いいねの多い順
            ->get();

        return view('products.index', compact('products', 'tab'));
    }


    //➂商品詳細画面（表示）
    public function show($item_id)
    {
        $product = Product::with(['categories', 'likes', 'comments'])
                            ->withCount(['likes', 'comments']) //いいね数（Bladeファイル{{ $product->likes_count }}で表示）、コメント数（Bladeファイル{{ $product->comments_count }}で表示）をカウント
                            ->findOrFail($item_id);

        $product = Product::with([
            'categories',
            'likes',
            'comments' => function($query) {
                $query->orderBy('created_at', 'desc'); // 新しい順に並び替え！
            },
        ])
        ->withCount(['likes', 'comments'])
        ->findOrFail($item_id);

        //ログインユーザーがこの商品をいいね済みかを判定
        $isLiked = $product->likes->contains('user_id', Auth::id());
        
        return view('products.show', compact('product','isLiked'));//isLiked で、ログインユーザーが既にいいね済みかも判定
    }


    //➅商品出品画面（表示）
    public function create()
    {
        //出品ページでカテゴリ選択が出来るようcategoryを取得
        $categories = Category::all();
        
        return view('product.create', compact('categories'));
    }


    //➅商品出品画面（登録処理）
    public function store(ExhibitionRequest $request)
    {

        // 画像アップロード
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $data = [
            'name' => $request->name,
            'image' => $imagePath,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'condition_id' => $request->condition,
            'user_id' => Auth::id(),
        ];

        //brandは任意のため、入力がある場合は$dataに追加する
        if ($request->filled('brand')) {
            $data['brand'] = $request->brand;
        }

        $product = Product::create($data);

        // Product と Category が多対多で中間テーブル product_category でつながっているためattachで取得する
        $product->categories()->attach($request->categories);

        return redirect()->route('product.index')->with('success', '商品を出品しました');

    }
}
