<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'plate',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'car_users');
    }
}
