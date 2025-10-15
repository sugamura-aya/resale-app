<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => ['required', 'in:card,convenience_store'],
            'address_check' => ['required'], // 配送先はセッションかユーザーのプロフィールから取得するため、仮のフィールド名。配送先が存在するかをチェック
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'payment_method.in' => '正しい支払い方法を選択してください',
            'address_check.required' => '配送先を選択してください',
        ];
    }
}
