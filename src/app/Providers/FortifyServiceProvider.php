<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Http\Responses\LogoutResponse as CustomLogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        // 新規登録

        Fortify::registerView(function () {
            return view('auth.register');
        });
        
        // ログイン
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::verifyEmailView(function ()
        {
            return view('auth.email');
        });

        //ログアウト
        $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);

        // 入力制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email.$request->ip());

        });
    }
}
