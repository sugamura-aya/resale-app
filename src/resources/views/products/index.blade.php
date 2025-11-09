@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection


@section('content')
{{--sessionにて「商品を出品しました」が表示--}}
<div class="listing__alert">
    @if(session('success-listing'))
    <div class="listing__alert--success">
      {{session('success-listing')}}
    </div>
    @endif
</div>

{{--sessionにて「プロフィールを更新しました」が表示--}}
<div class="mypage__alert">
    @if(session('success-mypage'))
    <div class="mypage__alert--success">
      {{session('success-mypage')}}
    </div>
    @endif
</div>

{{--sessionにて「商品を購入しました」が表示--}}
<div class="purchase__alert">
    @if(session('success-purchase'))
    <div class="purchase__alert--success">
      {{session('success-purchase')}}
    </div>
    @endif
</div>

<div class="list">
  {{-- タブ部分 --}}
  <section class="product-tab">
    <header class="product-tab__header">
      <nav class="product-tab__nav">
        <ul class="product-tab__list">
          <li class="product-tab__item">
            <a 
              href="{{ route('product.index', ['tab' => 'all']) }}" 
              class="product-tab__link {{ $tab === 'all' ? 'product-tab__link--active' : '' }}">
              おすすめ
            </a>
          </li>
          <li class="product-tab__item">
            <a 
              href="{{ route('product.index', ['tab' => 'mylist']) }}" 
              class="product-tab__link {{ $tab === 'mylist' ? 'product-tab__link--active' : '' }}">
              マイリスト
            </a>
          </li>
        </ul>
      </nav>
    </header>
  </section>

  {{-- 商品一覧部分 --}}
  <section class="product-list">
    <ul class="product-list__wrapper">
      @foreach ($products as $product)
        <li class="product-list__item">
          <a href="{{ route('product.show', ['item_id' => $product->id]) }}">

            @if (isset($product->orders_count) && $product->orders_count > 0) 
              <div class="sold-out-overlay">
                <span class="sold-badge">Sold</span>
              </div>
            @endif

            {{-- 画像 --}}
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            {{-- 商品名 --}}
            <p class="row-name">{{ $product->name }}</p>
          </a>
        </li>
      @endforeach
    </ul>
  </section>
</div>

@endsection