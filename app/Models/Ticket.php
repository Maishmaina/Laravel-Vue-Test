<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['booking_id', 'ticket_no'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->ticket_no = $model->generateUniqueAlphanumeric();
        });
    }

    // Method to generate a unique
    public function generateUniqueAlphanumeric()
    {
        do {
           
            $alphanumeric = Str::random(10);
        } while (self::where('ticket_no', $alphanumeric)->exists());

        return $alphanumeric;
    }
}
