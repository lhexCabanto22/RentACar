<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $fillable = [
        'description',
        'rent_id',
        'office_id'
    ];

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
