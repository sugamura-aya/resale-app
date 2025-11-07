<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Authファサードを使うために追加
use Illuminate\Validation\Validator; // withValidatorで型を指定するために追加

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


    //カスタムバリデーションルールの追加
    /**
     * バリデーション実行前に、配送先住所が存在するかどうかをチェックする
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();

        // 郵便番号(postcode)または住所(address)のどちらかが空の場合にエラーを追加する
        // ※ 建物名(building)は任意なのでチェックしない
        if (empty($user->postcode) || empty($user->address)) {
            
            // エラーが発生した場合、バリデーターにメッセージを追加する
            $validator->after(function ($validator) {
                // messages() で定義したキー（'address_check'）を使ってエラーメッセージを出す
                $validator->errors()->add('address_check', $this->messages()['address_check.required']);
            });
        }
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
            
             // 配送先はセッションかユーザーのプロフィールから取得するため、仮のフィールド名。配送先が存在するかをチェック
            // withValidatorでエラーを発生させるためのダミーとして残す
            'address_check' => ['sometimes'], 
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'payment_method.in' => '正しい支払い方法を選択してください',

            // 配送先情報がDBから取得できなかった場合のエラーメッセージ
            'address_check.required' => '配送先住所を入力してください。', 
        ];
    }
}
