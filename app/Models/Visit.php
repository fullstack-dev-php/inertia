<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'name',
        'status',
        'price'
    ];
//     public function user()
// {
//     return $this->belongsTo(User::class);
// }

// public function restaurant()
// {
//     return $this->belongsTo(Restaurant::class);
// }

}
