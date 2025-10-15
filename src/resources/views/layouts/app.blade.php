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

    {{--ページネーションの表示調整のため導入
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">--}}

    {{-- ページごとのCSS --}}
    @yield('css')

    </head>

    <body>
        <header class="header">
            <img class="header__logo" src="{{asset('storage/icon/logo.svg')}}" alt="ロゴマーク">

            {{-- ログイン・会員登録ページでは非表示 --}}
            @if (!in_array(Route::currentRouteName(), ['login', 'register']))

            {{--商品検索フォーム--}}
            <form action="{{ route('product.index') }}" method="GET" class="search-form">
                <input type="text" class="search-form__input" name="keyword" value="{{request('keyword')}}" placeholder=" なにをお探しですか？">
            </form>

            <div class="header__nav">
                {{--ログアウト--}}
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                    <button type="submit" class="nav__item">ログアウト</button>
                </form>

                {{--マイページ--}}
                <a class="nav__item" href="{{ route('mypage.show') }}">マイページ</a>

                {{-- 出品 --}}
                <a class="nav__item--button" href="{{ route('product.create') }}">出品</a> 
            </div> 
            @endif  

        </header>

        <main>
        @yield('content')
        </main>

        @yield('scripts')

    </body>
</html>