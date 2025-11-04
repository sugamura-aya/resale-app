@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')
<div class="purchase-page">

  <form action="{{route('purchase.store', ['item_id' => $item_id]) }}" class="purchase-form" method="POST" id="purchaseForm">
  @csrf

    {{--左側（➀商品情報、➁支払方法選択、➂配送先情報）--}}
    <div class="purchase-form__content">
      
      {{--➀商品情報--}}
      <div class="product__info">
        {{--左側：商品画像--}}
        <div class="img-preview-wrapper">
          <img class="product-img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        </div>

        {{--右側：商品名、価格--}}
        <div class="nameprice-preview-wrapper">
          <h2 class="product-name">{{ $product->name }}</h2>

          <p class="product-price">¥{{ number_format($product->price) }}</p> <!--number_format() 3桁ごとにカンマ（,）**を入れてくれるPHPの関数 -->
        </div>
      </div>

      {{--➁支払方法選択--}}
      <div class="payment-method">
          <h2 class="payment-method__title">支払方法</h2>
          <select name="payment_method" id="" class="payment-method__select">
            <option value="convenience_store">コンビニ払い</option>       
            <option value="card">カード支払い</option>     
          </select>

          @error('payment_method')
            <p class="error-message">{{ $message }}</p>
          @enderror
      </div>

      {{--➂配送先情報--}}
      <div class="address__info">
        {{--左側：配送先情報--}}
        <div class="address__content">
          <h2 class="address__title">配送先</h2>
          <p class="address__item">〒{{($postcode) }}</p>
          <p class="address__item">{{($address) }}</p>
          <p class="address__item">{{($building) }}</p>
        </div>

        {{--変更ボタン--}}
        <div class="address-change__button">
          <a href="{{ route('purchase.address.edit', ['item_id' => $item_id]) }}" class="address-change__button-submit">変更する</a>
        </div>
      </div>

    </div>


    {{--右側：確認表示、購入ボタン--}}
    <div class="purchase-confirm__content">

      {{--上部：代金、支払方法確認--}}
      <div class="confirm-grid">
        <div class="confirm-grid__item-title">商品代金</div>
        <div class="confirm-grid__item-value">
            ¥{{ number_format($product->price) }}
        </div>

        <div class="confirm-grid__item-title">支払い方法</div>
        <div class="confirm-grid__item-value">
            <span id="payment-confirm">コンビニ払い</span>
        </div>  
      </div>

      {{--下部：購入ボタン--}}
      <div class="purchase__button">

        @error('purchase_error')
              <p class="error-message purchase-error-box">{{ $message }}</p>
        @enderror

        <button class="purchase__button-submit" type="submit" id="finalPurchaseButton">購入する</button>
      </div>
    </div>

  </form>
</div>


@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.querySelector('select[name="payment_method"]');
    const paymentConfirm = document.getElementById('payment-confirm');
    
    // 選択肢のテキストを返す関数
    function getSelectedText(selectElement) {
        return selectElement.options[selectElement.selectedIndex].text;
    }

    // ページロード時にも初期値を設定
    if (paymentSelect && paymentConfirm) {
        paymentConfirm.textContent = getSelectedText(paymentSelect);
    }

    // 選択が変更されたときの処理
    if (paymentSelect) {
        paymentSelect.addEventListener('change', function() {
            if (paymentConfirm) {
                // 選択された <option> のテキストを取得し、右側の表示を更新
                paymentConfirm.textContent = getSelectedText(this);
            }
        });
    }

});
</script>
@endpush