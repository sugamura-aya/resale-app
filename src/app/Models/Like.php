<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        /*リレーションを設定するため、外部キーのuser_idに許可リストをつける*/
        'user_id',
        /*リレーションを設定するため、外部キーのproduct_idに許可リストをつける*/
        'product_id'
    ];

    /*リレーション*/
    //➀Likeモデル：Userモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function user() {

        return $this->belongsTo(User::class);
    }

    //➁Likeモデル：Productモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function product() {

        return $this->belongsTo(Product::class);
    }

}
