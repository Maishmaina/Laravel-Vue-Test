<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tour_id', 'status','amount','slots'];

    public function tours()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
