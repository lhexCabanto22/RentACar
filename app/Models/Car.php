<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','plate_number','brand_id', 'office_id'];
    
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
