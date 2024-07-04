<?php

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