<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'start_time',
        'end_time',
    ];
}
