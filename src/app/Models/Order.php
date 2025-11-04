<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'postcode',
        'address',
        'building',
        /*リレーションを設定するため、外部キーのuser_idにも許可リストをつける*/
        'user_id',
        /*リレーションを設定するため、外部キーのproduct_idにも許可リストをつける*/
        'product_id',
        'status',
    ];

    /*リレーション*/
    //➀Orderモデル：Userモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function user() {

        return $this->belongsTo(User::class);
    }

    //➁Orderモデル：Productモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function product() {

        return $this->belongsTo(Product::class);
    }
}
