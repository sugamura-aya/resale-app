<!DOCTYPE html>
<html lang="ja">

    <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resale App</title>

    {{--リセットCSS--}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />

    {{--common.css呼び出し--}}
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />

    {{-- ページごとのCSS --}}
    @yield('css')

    </head>

    <body>
        <header class="header">
            <div class="header__inner">

                {{-- 左：ロゴ --}}
                <div class="header__left">
                    <img class="header__logo" src="{{asset('storage/icon/logo.svg')}}" alt="ロゴマーク">
                </div>

                {{-- 中央：検索フォーム --}}
                <div class="header__center">
                {{-- ログイン・会員登録ページでは非表示 --}}
                @if (!in_array(Route::currentRouteName(), ['login', 'register']))
                        {{--商品検索フォーム--}}
                        <form action="{{ route('product.index') }}" method="GET" class="search-form">
                            <input type="text" class="search-form__input" name="keyword" value="{{request('keyword')}}" placeholder=" なにをお探しですか？">
                        </form>
                    @endif
                </div>

                {{-- 右：ボタン3種 --}}
                <div class="header__right">
                
                    {{-- ログイン・会員登録ページでは非表示 --}}
                    @if (!in_array(Route::currentRouteName(), ['login', 'register']))
                        <div class="header__nav">

                            {{-- 認証済みユーザー向けボタン (@auth) --}}
                            @auth 
                                {{-- ログアウト --}}
                                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                @csrf
                                    <button type="submit" class="nav__item">ログアウト</button>
                                </form>

                                {{-- マイページ --}}
                                <a class="nav__item" href="{{ route('mypage.show') }}">マイページ</a>

                                {{-- 出品 --}}
                                <a class="nav__item--button" href="{{ route('product.create') }}">出品</a> 
                            @endauth 
                            
                            {{-- 未認証ユーザー向けボタン (@guest) --}}
                            @guest 
                                {{--「ログイン」ボタン --}}
                                <a class="nav__item" href="{{ route('login') }}">ログイン</a>
                                
                                {{-- 「マイページ」ボタン --}}
                                <a class="nav__item" href="{{ route('login') }}">マイページ</a>
                                
                                {{-- 「出品」ボタン --}}
                                <a class="nav__item--button" href="{{ route('login') }}">出品</a> 
                            @endguest
                        </div> 
                    @endif  
                </div>
            </div>
        </header>

        <main>
        @yield('content')
        </main>

        @yield('scripts')

        @stack('scripts')

    </body>
</html>