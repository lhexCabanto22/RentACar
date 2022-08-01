<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $fillable = [
        'first_name',
        'last_name',
        'purok',
        'barangay',
        'city',
        'contact',
        'email',
        'password',
    ];

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    public function offices()
    {
        return $this->belongsToMany(Office::class, 'customer_office');
    }
}
