<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required','string','max:255'],
            'image' => ['required', 'file', 'mimes:png,jpeg'],
            'categories'   => ['required', 'array', 'min:1'],   // 必須、配列、最低1つは選択必須
            'categories.*' => ['exists:categories,id'],        // 配列内の各要素がcategoriesテーブルのidとして存在するか
            'condition' => ['required', 'exists:conditions,id'], //exists を使って、入力された ID が条件テーブルに存在するか確認
            'price' => ['required','numeric','min:0'],
            'brand' =>  ['nullable'], // ブランドは任意入力
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            //'description.string' => 'テキスト形式で入力してください',
            'description.max' => '255文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'categories.required' => 'カテゴリを選択してください',
            'categories.array'    => 'カテゴリを選択してください',
            'categories.min'      => 'カテゴリを選択してください',
            'categories.*.exists' => '正しいカテゴリを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'condition.exists'   => '正しい商品の状態を選択してください',
            'price.required' => '価格を入力してください',
            'price.numeric' => '価格を数値で入力してください',
            'price.min' => '価格を０円以上で入力してください',
        ];
    }
}
