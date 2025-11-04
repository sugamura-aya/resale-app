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
        'condition_id',
        'status'
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


    // いいね済みか判定するメソッド
    /**
     * ログインユーザーがこの商品にいいねしているかチェック
     *
     * @param int|null $userId ログインユーザーID
     * @return bool
     */
    public function isLikedByUser(?int $userId): bool
    {
        if (is_null($userId)) {
            return false;
        }
        // likesリレーションシップを使って、現在のユーザーIDで絞り込む
        return $this->likes()->where('user_id', $userId)->exists();
    }

    //Productsテーブルカラム「statu」をラベル表示できるように下記記述
    public function getStatusLabelAttribute() {
        return match($this->status) {
            1 => '出品中',
            2 => '販売済み',
            default => '不明',
        };
    }

    //商品名検索スコープ（部分一致）
    public function scopeNameSearch($query, $name)
    {
        if (!empty($name)) {
            $query->where('name','like', '%'.$name.'%');
        }
    }

    //並び替えローカルスコープ（いいね数が多い順＋いいねが無い場合ID順）
    public function scopeSortByLikes($query)
    {
        $query->withCount('likes')
            ->orderByDesc('likes_count')
            ->orderBy('id', 'asc');
    }

}
