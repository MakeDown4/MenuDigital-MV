<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'remarks',
        'num_people',
        'is_confirmed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'reservation_menu_items')->withPivot('quantity');
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}