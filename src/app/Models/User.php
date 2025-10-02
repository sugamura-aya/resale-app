<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'postcode',
        'address',
        'building',
    ];


    /*リレーション*/
    //➀Userモデル：Orderモデル＝親：子＝１：多
    //リレーションを繋げる（親モデル側）
    public function orders(){

        //「$this(Userモデル)はOrderモデルを複数有する」
        return $this->hasMany(Order::class);
    }

    //➁Userモデル：Productモデル＝親：子＝１：多（出品商品）
    //リレーションを繋げる（親モデル側）
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    //➂Userモデル：Likeモデル＝親：子＝１：多
    //リレーションを繋げる（親モデル側）
    public function likes(){

        //「$this(Userモデル)はLikeモデルを複数有する」
        return $this->hasMany(Like::class);
    }

    //➃Userモデル：Commentモデル＝親：子＝１：多
    //リレーションを繋げる（親モデル側）
    public function comments(){

        //「$this(Userモデル)はCommentモデルを複数有する」
        return $this->hasMany(Comment::class);
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
