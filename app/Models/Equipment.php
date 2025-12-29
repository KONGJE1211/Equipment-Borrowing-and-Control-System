<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{

    use HasFactory; 
    protected $table = 'equipment';
    protected $fillable = ['name', 'information', 'value', 'image', 'status', 'expired_date'];

    public function bookings()
    {
       return $this->hasMany(Booking::class, 'equipment_id');
    }
}