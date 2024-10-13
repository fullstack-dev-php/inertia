<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'avatar'
    ];
    public function visits()
{
    return $this->hasMany(Visit::class);
}

}
