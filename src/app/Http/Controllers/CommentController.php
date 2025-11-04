<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    // コメント投稿
    public function store(CommentRequest $request, $item_id)
    {
        $user = Auth::user();

        Comment::create([
            'user_id' => $user->id,
            'product_id' => $item_id,
            'body' => $request->body,
        ]);

        return redirect()->route('product.show', ['item_id' => $item_id])
                         ->with('success', 'コメントを投稿しました');
    }
}
