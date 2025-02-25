<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens as HasOAuthApiTokens;
use App\Models\Shipping; 
use App\Models\Cart;

class User extends Authenticatable
{
    use HasApiTokens, HasOAuthApiTokens, HasFactory, Notifiable; 

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        //'role',
    ];

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
        'password' => 'hashed',
    ];
    public function shipaddr()
    {
        return $this->hasMany(Shipping::class);
    }
    public function cart() 
    {
        return $this->hasMany(Cart::class);
    }
    
    protected $guarded = ['id'];
}
