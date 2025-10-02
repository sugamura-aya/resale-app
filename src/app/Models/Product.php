<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'brand',
        'price',
        'description',
        /*リレーションを設定するため、外部キーのuser_idにも許可リストをつける*/
        'user_id',
        /*リレーションを設定するため、外部キーのcondition_idにも許可リストをつける*/
        'condition_id'
    ];


    /*リレーション*/
    //➀Productモデル：Userモデル＝子：親＝多：１（出品者）
    //リレーションを繋げる（子モデル側）
    public function user() {

        return $this->belongsTo(User::class);
    }

    //➁Productモデル：Orderモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function orders() 
    {
        return $this->hasMany(Order::class);
    }

    //➂Productモデル：Likeモデル＝親：子＝１：多
    //リレーションを繋げる（親モデル側）
    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    //➃Productモデル：Commentモデル＝親：子＝１：多
    //リレーションを繋げる（親モデル側）
    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }

    //➄Productモデル：Conditionモデル＝子：親＝多：１
    //リレーションを繋げる（子モデル側）
    public function condition() {

        return $this->belongsTo(Condition::class);
    }

    //➅Productモデル：Categoryモデル＝多：多
    //リレーションを繋げる（中間テーブル経由でつなぐ）
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

}
