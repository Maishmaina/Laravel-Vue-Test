<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['destination_id', 'name', 'description','price', 'slots','pickup_place','start_date','end_date'];

    public function destinations()
    {
        return $this->belongsTo(Destination::class,'destination_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeSearch($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }
    
}
