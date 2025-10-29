@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection


@section('content')
<div class="mypage-edit-page">

  <div class="mypage-form">

    <form action="{{route('mypage.edit')}}" method="POST" class="mypage-form__content" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

      <div class="tit">
        <h1 class="mypage-title">プロフィール設定</h1>
      </div>

      {{-- プロフィール画像 --}}
      <div class="form-group">
        <div class="image-upload-wrapper">
          <!-- 丸い画像枠 -->
          <div class="image-preview-wrapper">
            <img id="preview-image" class="preview-image"  src="{{ $user && $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}">
          </div>

          <!-- ファイル入力（非表示） -->
          <input id="image-input" type="file" name="profile_image" accept="image/*" hidden>

          <!-- 画像選択ボタン -->
          <label for="image-input" class="custom-file-button">画像を選択する</label>
        </div>
        
        <span id="file-name" class="file-name"></span>

        @if($errors->has('profile_image'))
            @foreach($errors->get('profile_image') as $message)
                <div class="error-message">{{ $message }}</div>
            @endforeach
        @endif
      </div>


     {{--ユーザー名--}}
      <div class="content">
        <p class="content-name">ユーザー名</p>
        <input type="text" name="name" class="content-item" value="{{ old('name', $user?->name ?? '') }}">
      </div>
      @if($errors->has('name'))
        @foreach($errors->get('name') as $message)
          <div class="error-message">{{ $message }}</div>
        @endforeach
      @endif

      {{--郵便番号--}}
      <div class="content">
        <p class="content-name">郵便番号</p>
        <input type="text" name="postcode" class="content-item" value="{{ old('postcode', $user?->postcode ?? '') }}">
      </div>
      @if($errors->has('postcode'))
        @foreach($errors->get('postcode') as $message)
          <div class="error-message">{{ $message }}</div>
        @endforeach
      @endif

      {{--住所--}}
      <div class="content">
        <p class="content-name">住所</p>
        <input type="text" name="address" class="content-item"
        value="{{ old('address', $user?->address ?? '') }}">
      </div>
      @if($errors->has('address'))
        @foreach($errors->get('address') as $message)
          <div class="error-message">{{ $message }}</div>
        @endforeach
      @endif

      {{--建物名--}}
      <div class="content">
        <p class="content-name">建物名</p>
        <input type="text" name="building" class="content-item" value="{{ old('building', $user?->building ?? '') }}">
      </div>
      @if($errors->has('building'))
        @foreach($errors->get('building') as $message)
          <div class="error-message">{{ $message }}</div>
        @endforeach
      @endif

      <div class="mypage__button">
        <button	class="mypage__button-submit" type="submit">更新する</button>
      </div>
    </form>
  </div>
</div> 
@endsection


@push('scripts')
<script>
document.getElementById('image-input').addEventListener('change', function(){
    const file = this.files[0];
    const previewImage = document.getElementById('preview-image');
    
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewImage.src = '';
        previewImage.style.display = 'none';
    }
});
</script>
@endpush

