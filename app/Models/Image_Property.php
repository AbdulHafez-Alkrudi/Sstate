<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image_Property extends Model
{
    use HasFactory;

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

}
