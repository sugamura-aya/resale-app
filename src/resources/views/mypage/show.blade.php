@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection


@section('content')
<div class="mypage-page">

  {{-- プロフィール部分 --}}
  <div class="mypage-profile">

    <div class="profile-image-wrapper">
      {{--プロフィール画像--}}
      <div class="image-preview-wrapper">
        @if($user)
          <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-profile.png') }}" alt="{{ $user->name }}">
          <div class="profile-name">{{ $user->name }}</div>
        @else
          <img src="{{ asset('images/default-profile.png') }}" alt="ゲスト">
        @endif
      </div>

      {{--ユーザー名--}}
      <div class="profile-name">
        @if($user)
          {{ $user->name }}
        @else
          ゲスト
        @endif
      </div>

      {{--プロフィール編集ボタン--}}
      <form action="{{ route('mypage.edit') }}" method="GET">
        <button type="submit" class="profile-edit__button">プロフィールを編集</button>
      </form>
    </div>
  </div>

  {{-- タブ --}}
  <section class="mypage-tab">
    <ul class="mypage-tab__list">
      <li>
        <a href="{{ route('mypage.show', ['page'=>'sell']) }}" class="mypage-tab__link {{ $page==='sell' ? 'mypage-tab__link--active' : '' }}">出品した商品</a>
      </li>
      <li>
        <a href="{{ route('mypage.show', ['page'=>'buy']) }}" class="mypage-tab__link {{ $page==='buy' ? 'mypage-tab__link--active' : '' }}">購入した商品</a>
      </li>
    </ul>
  </section>

  {{-- 商品一覧 --}}
  <section class="product-list">
    <ul class="product-list__wrapper">
      @foreach ($products as $product)
        <li class="product-list__item">
          <a href="{{ route('product.show', ['item_id' => $product->id]) }}">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            <p class="row-name">{{ $product->name }}</p>
          </a>
        </li>
      @endforeach
    </ul>
  </section>
</div>

@endsection