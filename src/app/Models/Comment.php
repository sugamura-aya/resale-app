<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        /*リレーションを設定するため、外部キーのuser_idにも許可リストをつける*/
        'user_id',
        /*リレーションを設定するため、外部キーのproduct_idにも許可リストをつける*/
        'product_id'
    ];

    /*リレーション*/
    //➀Commentモデル：Userモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function user() {

        return $this->belongsTo(User::class);
    }

    //➁Commentモデル：Productモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function product() {

        return $this->belongsTo(Product::class);
    }
}
