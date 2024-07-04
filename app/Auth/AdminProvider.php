<?php
namespace App\Auth;
/*AdminProvider.php*/

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Admin;
class AdminProvider implements UserProvider
{
    protected $model = 'App\Models\Admin';
    public function retrieveById($identifier)
    {
        return Admin::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return Admin::where('id', $identifier)
            ->where('remember_token', $token)
            ->first();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }

    public function retrieveByCredentials(array $credentials)
    {
        return Admin::where('email', $credentials['email'])->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return \Hash::check($credentials['password'], $user->getAuthPassword());
    }
}





/***AuthServiceProvider.php */


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Auth\FilamentGuard;
use Illuminate\Support\Facades\Auth;
class AuthServiceProvider extends ServiceProvider
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
        Auth::extend('admins', function ($app, $name, array $config) {
            return new FilamentGuard(Auth::createUserProvider($config['provider']));
        });
    }
}











/***FilamentGuard.php */


// app/Auth/FilamentGuard.php

namespace App\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Admin;

class FilamentGuard implements Guard
{
    protected $user;

    public function __construct(AdminProvider $adminProvider)
    {
        $this->adminProvider = $adminProvider;
    }

    public function check()
    {
        return !is_null($this->user());
    }

    public function guest()
    {
        return is_null($this->user());
    }

    public function hasUser()
    {
        return !is_null($this->user());
    }

    public function id()
    {
        return $this->user() ? $this->user()->getAuthIdentifier() : null;
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function user()
    {
        return $this->user;
    }

    public function validate(array $credentials = [])
    {
        return dd('ok');
        /*if (empty($credentials['email']) || empty($credentials['password'])) {
            return false;
        }

        $user = Admin::where('email', $credentials['email'])->first();

        if (!$user) {
            return false;
        }

        if (\Hash::check($credentials['password'], $user->password)) {
            return true;
        }

        return false;*/
    }
}
