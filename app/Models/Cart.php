<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Cart extends Model
{
    use HasFactory;
    
    protected $table = 'cart';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'title',
        'price',
        'units',
        'ip_address',
    ];

    protected $casts = [
        'images' => 'json',
    ];
    
    protected $guarded = ['id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}