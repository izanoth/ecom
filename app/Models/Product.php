<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'brand_id',
        'title',
        'specifications',
        'price',
        'images',
        'description',
        'in_stoch',
    ];

    protected $casts = [
        'specifications' => 'json',
        'images' => 'json',
    ];

    protected $guarded = ['id'];

    public function carts() {
        return $this->hasMany(Cart::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
