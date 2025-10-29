@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')

<div class="address-page">

  <div class="address-form">

    <form action="{{ route('purchase.address.update', ['item_id' => $item_id]) }}" method="POST" class="address-form__content">
    @csrf
    @method('PATCH')

      <div class="tit">
        <h1 class="address-title">住所の変更</h1>
      </div>

      {{--郵便番号--}}
      <div class="content">
        <p class="content-name">郵便番号</p>
        <input type="text" name="postcode" class="content-item"  value="{{ old('postcode', $postcode ?? '') }}">
      </div>
      @if($errors->has('postcode'))
        @foreach($errors->get('postcode') as $message)
          <div class="error-message">{{ $message }}</div>
        @endforeach
      @endif

      {{--住所--}}
      <div class="content">
        <p class="content-name">住所</p>
        <input type="text" name="address" class="content-item" value="{{ old('address', $address ?? '') }}">
      </div>
      @if($errors->has('address'))
        @foreach($errors->get('address') as $message)
          <div class="error-message">{{ $message }}</div>
        @endforeach
      @endif

      {{--建物名--}}
      <div class="content">
        <p class="content-name">建物名</p>
        <input type="text" name="building" class="content-item" value="{{ old('building', $building ?? '') }}">
      </div>
      @if($errors->has('building'))
        @foreach($errors->get('building') as $message)
          <div class="error-message">{{ $message }}</div>
        @endforeach
      @endif

      <div class="address__button">
        <button	class="address__button-submit" type="submit">更新する</button>
      </div>
    </form>
  </div>
</div>

@endsection