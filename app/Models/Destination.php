<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            $destination->slug = static::generateUniqueSlug($destination->name);
        });
    }

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();
        
        return $count ? "{$slug}-{$count}" : $slug;
    }
}
