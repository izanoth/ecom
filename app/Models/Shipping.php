<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $table = 'shippings';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'receiver',
        'address',
        'complement',
        'zipcode',
        'city',
        'district',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $guarded = ['id'];
}
