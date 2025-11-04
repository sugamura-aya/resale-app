@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection


@section('content')
<div class="listing-page">

  <form action="{{route('product.store')}}" class="listing-form" method="POST" enctype="multipart/form-data">
  @csrf

    <div class="listing-form__content">

      <h1 class="listing-product__title">商品の出品</h1>

      {{-- 商品画像 --}}
      <div class="form-label">商品画像</div>
      <div class="form-group image-upload-area">

          <img id="preview-image" class="preview-image" style="display:none;" alt="画像プレビュー">
        
        		<label for="image-input" class="custom-file-label">
           	  <span class="label-text">画像を選択する</span>
        		</label>
        
        <input id="image-input" class="image-input" type="file" name="image" accept="image/*" style="display:none;">
        
        @error('image')
          <div class="error-message">{{ $message }}</div>
        @enderror
      </div>

      {{-- 商品詳細 --}}
      <div class="listing-product__detailed">
        <div class="detailed__title">商品の詳細</div>

        {{-- カテゴリー --}}
        <div class="form-label">カテゴリー</div>
          <div class="checkbox-group">
            @foreach($categories as $category)
            <label class="category-item"> 
              <input type="checkbox" 
                   name="categories[]" 
                   value="{{ $category->id }}"
                   {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}
                   class="category-checkbox" 
                   style="display:none;">  <span class="category-name">{{ $category->name }}</span>
            </label>
            @endforeach
          </div>
            @error('categories')
              <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{--商品の状態--}}
        <div class="form-group">
          <div class="form-label">商品の状態</div>
          <select name="condition" class="form-select">
            <option value="" disabled {{ old('condition') ? '' : 'selected' }}>選択してください</option>
            
            @foreach($conditions as $condition)
            <option 
                value="{{ $condition->id }}" 
                {{ old('condition') == $condition->id ? 'selected' : '' }}
            >
                {{ $condition->name }}
            </option>
            @endforeach
          </select>
          @error('condition')
              <div class="error-message">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- 商品名と説明 --}}
      <div class="listing-product__explanation">
        <div class="detailed__title">商品名と説明</div>

        {{--商品名--}}
        <div class="form-group">
          <div class="form-label">商品名</div>

          <input type="text" class="fields" name="name" value="{{ old('name') }}">
          @error('name')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        {{--ブランド名--}}
        <div class="form-group">
          <div class="form-label">ブランド名</div>

          <input type="text" class="fields" name="brand" value="{{ old('brand') }}">
          @error('brand')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        {{--商品の説明--}}
        <div class="form-group">
          <div class="form-label">商品の説明</div>

          <textarea class="fields-description" name="description">{{ old('description') }}</textarea>
            @error('description')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{--販売価格--}}
        <div class="form-group">
            <div class="form-label">販売価格</div>
            <input class="fields" type="text" name="price" value="{{ old('price') }}">
            @error('price')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
      </div>

      {{-- ボタン --}}
      <div class="listing__button">
        <button type="submit" class="listing__button-submit">出品する</button>
      </div>

    </div>

  </form>

</div>

@endsection

@push('scripts')
<script>
document.getElementById('image-input').addEventListener('change', function(){
  const file = this.files[0];
  const previewImage = document.getElementById('preview-image');
  const customLabel = document.querySelector('.custom-file-label'); // カスタムボタン要素を取得
  const uploadArea = document.querySelector('.image-upload-area'); 

  if(file){
    const reader = new FileReader();
    reader.onload = function(e){
     previewImage.src = e.target.result;
     previewImage.style.display = 'block';

     // 画像が表示されたら、カスタムボタンを非表示にする
     if (customLabel) {
      customLabel.style.display = 'none'; 
     } 
     // 画像表示時：親要素にクラスを追加
     if (uploadArea) {
      uploadArea.classList.add('has-preview');
     }
    } 
    reader.readAsDataURL(file);
  } else {
    previewImage.src = '';
    previewImage.style.display = 'none';

    // ファイルがクリアされたら、カスタムボタンを再表示する
    if (customLabel) {
      customLabel.style.display = 'flex'; 
    }
    // 画像クリア時：親要素からクラスを削除
    if (uploadArea) {
      uploadArea.classList.remove('has-preview');
    }
  }
});
</script>
@endpush