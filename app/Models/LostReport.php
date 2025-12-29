<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostReport extends Model
{
    protected $fillable = [
        'user_id',
        'equipment_id',
        'description',
        'admin_reply',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }
}
