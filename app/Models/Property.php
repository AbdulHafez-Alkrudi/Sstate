<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // TODO: Test favourite_users relationship
    public function favourite_users(): HasMany
    {
        return $this->hasMany(Favourite::class , 'property_id');
    }

    public function street(): BelongsTo
    {
        return $this->belongsTo(Street::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(Image_Property::class);
    }
}
