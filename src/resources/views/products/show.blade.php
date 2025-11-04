@extends('layouts.app')

@section('css')
    {{-- Font Awesomeを読み込み、星のアイコンが使えるようにする --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5fM/z8Fj1VRTi+qV3jX9f0L3h8Z8A3hA8F0J4jB1B9a9+Q2G/o8G+8A3hA8F0J4jB1B9a9+Q2G/o8G+8A+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection


@section('content')
<div class="detailed-page">

    {{--左側：商品画像--}}
    <div class="detailed-page__left">
        <div class="product-image-wrapper">
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="product-image">
        @else
            <img src="{{ asset('images/no-image.png') }}" alt="画像がありません" class="product-image placeholder">
        @endif
        </div>
    </div>
    

    {{--右側：商品説明--}}
    <div class="detailed-page__right">

        {{--➀商品名・ブランド名・価格・いいね数・コメント数・購入ボタン--}}
        <div class="detailed__content">
            <h2 class="product__name">{{ $product->name }}</h2>
            <div class="product__brand">{{ $product->brand }}</div>
            <div class="product__price-group">
                <span class="required" >￥</span><div class="content__price">{{ number_format($product->price) }} </div><span class="required" >(税込)</span>
            </div>
            

            {{-- 「いいね」機能のセクション--}}
            <div class="likes-comments-area">

                {{-- いいねアイコンといいね数 (ログイン状態によって切り替え) --}}
                @auth
                {{-- ログイン済み: クリック可能なフォーム --}}
                <form 
                    action="{{ route('product.like', $product->id) }}" 
                    method="POST" 
                    class="like-form count__contents" 
                    data-product-id="{{ $product->id }}">
                    @csrf
                    
                    {{-- いいね済みの場合は、解除（DELETEメソッド）を送信するhiddenフィールドを挿入 --}}
                    @if ($isLiked) 
                        @method('DELETE') 
                    @endif
                    
                    <button 
                        type="submit" 
                        class="like-button {{ $isLiked ? 'liked' : 'unliked' }}" 
                        aria-label="{{ $isLiked ? 'いいねを解除' : 'いいねを登録' }}">
                        {{-- 
                             画像アイコンをFont Awesomeのiタグに置き換え
                            - fas: 塗りつぶしの星 (いいね済み)
                            - far: 枠線だけの星 (未いいね)
                            - star-icon--liked / star-icon--unliked: CSSで色を制御するためのクラス (後で定義)
                        --}}
                        <i 
                            class="fa-star star-icon {{ $isLiked ? 'fas star-icon--liked' : 'far star-icon--unliked' }}" 
                            id="product-star-{{ $product->id }}"
                        ></i>
                    </button> 
                    
                    {{-- いいね数 --}}
                    <span class='content__item like-count' id="like-count-{{ $product->id }}">{{ $product->likes_count ?? 0 }}</span>
                </form>
                @endauth

                @guest
                {{-- 未ログイン: 静的な表示（アイコンは1つ） --}}
                <div class="count__contents">
                    {{-- 
                        いいね数が1以上あれば、塗りつぶしアイコン(fas)と黄色クラス(liked)を付ける
                    --}}
                    <i class="
                        fa-star 
                        star-icon 
                        @if ($product->likes_count > 0) 
                            fas star-icon--liked
                        @else 
                            far star-icon--unliked 
                        @endif" 
                        id="product-star-{{ $product->id }}"
                    ></i>
                    <span class='content__item like-count'>{{ $product->likes_count ?? 0 }}</span>
                </div>
                @endguest

                {{-- コメント数を表示 --}}
                <div class="count__contents">
                    <img src="{{ asset('storage/comments/comment.icon.png') }}" alt="コメントアイコン" class="count__icon">
                    <span class='content__item comment-count'>{{ $product->comments_count ?? 0 }}</span>
                </div>
            </div>



            {{--購入ボタン--}}
            {{-- ログインユーザーが出品者本人ではない場合のみ表示 --}}
            @auth
                @if (Auth::id() !== $product->user_id)
                <div class="purchase__button">
                    <a href="{{route('purchase.create', $product->id)}}" class="purchase__button-submit">購入手続きへ</a>
                </div>
                @endif
            @endauth

            {{-- 未認証ユーザー（@guest）にはボタンを常に表示する（ログインページへ誘導） --}}
            @guest
                <div class="purchase__button">
                    <a href="{{route('purchase.create', $product->id)}}" class="purchase__button-submit">購入手続きへ</a>
                </div>
            @endguest
        </div>

        {{--➁商品説明--}}
        <div class="detailed__content">
            <h3 class="content__name">商品説明</h3>
            <div class="product__description">{{ $product->description }}</div>
        </div>

        {{--➂商品の情報（カテゴリー、商品の状態）--}}
        <div class="detailed__content">
            <h3 class="content__name">商品の情報</h3>

            <div class="content__type">
                <h5 class="type__name">カテゴリー</h5>
                <div class="type-category__item">
                    @foreach ($product->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="content__type">
                <h5 class="type__name">商品の状態</h5>
                <div class="type-description__item">
                    {{ $product->condition->name ?? '未設定' }}
                </div>
            </div>
        </div>

        {{--➃コメント欄--}}
        <div class="detailed__content">

            {{--コメント(コメント数)--}}
            <div class="contents__headline">
                <h3 class="headline__title">コメント</h3>
                <span class='headline__count'>（{{ $product->comments_count ?? 0 }}）</span>
            </div>

            {{--コメント内容（投稿者画像・名前・コメント--}}
            <div class="content__list">
                {{--コメント投稿者のプロフィール画像(丸枠内表示)--}}
                {{--コメント投稿者のユーザー名--}}
                {{--コメント内容--}}

                @forelse ($product->comments as $comment)
                    <div class="comment__item">

                        <div class="comment__body-wrapper">
                            {{-- コメント投稿者のプロフィール画像 --}}
                            <div class="comment__user-icon">
                                @if ($comment->user->profile_image)
                                    <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="{{ $comment->user->name }}の画像" class="user-icon">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="デフォルト画像" class="user-icon">
                                @endif
                            </div>

                            {{-- コメント投稿者のユーザー名 --}}
                            <div class="comment__user-name">{{ $comment->user->name }}</div>
                        </div>

                        {{-- コメント内容 --}}
                        <p class="comment__text">{{ $comment->body }}</p>
                        {{--投稿からの経過時間を分かりやすく表示するための機能<div class="comment__time">{{ $comment->created_at->diffForHumans() }}</div>--}}
                    </div>
                @empty
                    <p class="no-comments">　こちらにコメントが入ります。</p>
                @endforelse
            </div>

            {{--コメント投稿欄--}}
            <div class="content__input">

                <h4 class="input__title">商品へのコメント
                </h4>

                <form action="{{route('comment.store', $product->id)}}" class="comment__form" method="POST">
                @csrf
                    <textarea name="body" class="comment__input" >{{old('body')}}</textarea>
                    <input type="hidden" name="product_id" value="{{ $product->id }}"> 
                    @if($errors->has('body'))
                        @foreach($errors->get('body') as $message)
                            <div class="error-message">{{ $message }}</div>
                        @endforeach
                    @endif

                    <div class="comment__button">
                        <button class="comment__button-submit" type="submit">コメントを送信する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const likeForms = document.querySelectorAll('.like-form');
    
    // 未ログイン時はフォームがないので、ここで処理を終了
    if (likeForms.length === 0) {
        return; 
    }

    likeForms.forEach(form => {
        const button = form.querySelector('.like-button');
        
        if (!button) {
            console.error('Fatal Error: Like button not found within the form!');
            return;
        }

        // ボタンのクリックイベント
        button.addEventListener('click', function (e) {
            
            e.preventDefault(); // フォームの通常の送信（ページ遷移）を停止！
            
            const productId = form.dataset.productId;
            const csrfTokenElement = form.querySelector('input[name="_token"]');
            
            if (!csrfTokenElement) {
                console.error("Token Error: CSRF token not found in the form.");
                return;
            }
            
            const csrfToken = csrfTokenElement.value;
            // 現在のフォームの状態から、POST (登録) か DELETE (解除) かを判定
            const currentMethod = form.querySelector('input[name="_method"][value="DELETE"]') ? 'DELETE' : 'POST';
            const url = `/item/${productId}/like`;
            
            // リクエスト中はボタンを無効化して連打を防ぐ
            button.disabled = true;
            
            // APIリクエストの送信
            fetch(url, {
                method: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    _method: currentMethod
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('[AJAX] Processing Error Response:', text);
                        throw new Error(`Failed to process like. Status code: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                // サーバーからの応答に基づき、UIを更新する
                if (data.status === 'ok' && typeof data.isLiked !== 'undefined' && typeof data.likesCount !== 'undefined') {
                    updateLikeButton(form, data.isLiked, data.likesCount, productId);
                } else {
                    console.error('Invalid response format from server:', data);
                }
            })
            .catch(error => {
                console.error('[AJAX] Fatal error during communication:', error);
            })
            .finally(() => {
                // リクエストが完了したらボタンを元に戻す
                button.disabled = false;
            });
        });
    });

    /**
     * いいねボタンといいね数を更新する関数
     * アニメーション機能は削除されています。
     */
    function updateLikeButton(form, isLiked, newLikesCount, productId) {
        const likeCountElement = document.getElementById(`like-count-${productId}`);
        const button = form.querySelector('.like-button');
        const iconElement = document.getElementById(`product-star-${productId}`); 
        
        // 1. いいね数を更新
        if (likeCountElement) {
            likeCountElement.textContent = newLikesCount;
        }

        if (isLiked) {
            // A. いいね済み状態へ (色付き、塗りつぶし)
            
            // 2. ボタンのクラス切り替え
            button.classList.remove('unliked');
            button.classList.add('liked');
            button.setAttribute('aria-label', 'いいねを解除');
            
            // 3. アイコンのクラスを切り替え (塗りつぶし/黄色へ)
            if (iconElement) {
                iconElement.classList.remove('far', 'star-icon--unliked');
                iconElement.classList.add('fas', 'star-icon--liked'); 
            }

            // 4. フォームを「解除（DELETE）」モードに切り替えるhiddenフィールドを追加
            let deleteInput = form.querySelector('input[name="_method"][value="DELETE"]');
            if (!deleteInput) {
                deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = '_method';
                deleteInput.value = 'DELETE';
                form.appendChild(deleteInput);
            }

        } else {
            // B. いいね未済状態へ 

            // 2. ボタンのクラス切り替え
            button.classList.remove('liked');
            button.classList.add('unliked');
            button.setAttribute('aria-label', 'いいねを登録');

            // 3. アイコンのクラスを切り替え 
            if (iconElement) {
                iconElement.classList.remove('fas', 'star-icon--liked');
                iconElement.classList.add('far', 'star-icon--unliked');
            }

            // 4. フォームからDELETEメソッドのhiddenフィールドを削除
            const deleteInput = form.querySelector('input[name="_method"][value="DELETE"]');
            if (deleteInput) {
                form.removeChild(deleteInput);
            }
        }
    }
});
</script>
@endpush