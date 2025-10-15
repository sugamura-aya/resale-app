<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Responses\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() //プロバイダで提供する依存関係やサービスの登録場所
    {
        // 会員登録後のリダイレクト先をカスタムレスポンスに置き換え
        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);

        // デフォルトの LoginRequest を自作のものに差し替え
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\LoginRequest::class,
            \App\Http\Requests\LoginRequest::class
        );

        // デフォルトの RegisterRequest を自作のものに差し替え
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\RegisterRequest::class,
            \App\Http\Requests\RegisterRequest::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */

    //boot() は画面表示やログイン制限だけを記載
    public function boot()
    {
        //新規ユーザの登録処理
        Fortify::createUsersUsing(CreateNewUser::class);

        //【登録画面】GETメソッドで/registerにアクセスしたときに表示するviewファイル
        Fortify::registerView(function () {
            return view('auth.register');
        });

        //【ログイン画面】GETメソッドで/loginにアクセスしたときに表示するviewファイル
        Fortify::loginView(function () {
            return view('auth.login');
        });

        //login処理の実行回数を1分あたり10回までに制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // ログイン後のリダイレクト先
        Fortify::redirects('/');

    }
}
