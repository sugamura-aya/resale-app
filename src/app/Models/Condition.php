<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    //Conditionモデル：Productモデル＝親：子＝１：多
    //リレーションを繋げる（親モデル側）
    public function products() 
    {
        return $this->hasMany(Product::class);
    }
}
