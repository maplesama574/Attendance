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
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\LoginResponse;

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
        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            LoginResponse::class
        );

        Fortify::createUsersUsing(CreateNewUser::class);
        // 新規登録

        Fortify::registerView(function () {
            return view('auth.register');
        });
        
        // ログイン
        Fortify::loginView(function (Request $request) {
            if ($request->is('admin/login')) {
            return view('auth.admin-login');
        }

            return view('auth.login');
        });

        Fortify::verifyEmailView(function ()
        {
            return view('auth.email');
        });

        //ログアウト
         $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/login');
            }
        });

        // 入力制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email.$request->ip());

        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if (! $user) {
            return null;
            }

            if (! Hash::check($request->password, $user->password)) {
            return null;
            }

            if ($request->login_type === 'admin') {
            return $user->is_admin ? $user : null;
            }

            if ($request->login_type === 'user') {
            return ! $user->is_admin ? $user : null;
            }

            return null;
        });
    }
}
