<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    public $fillable = ['quantity', 'rent_date', 'return_date', 'status', 'car_id', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

}
