<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable =  ['name','contact','email','address'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_office');
    }

}
