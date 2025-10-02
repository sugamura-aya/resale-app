<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    //➅Categoryモデル：Productモデル＝多：多
    //リレーションを繋げる（中間テーブル経由でつなぐ）
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
