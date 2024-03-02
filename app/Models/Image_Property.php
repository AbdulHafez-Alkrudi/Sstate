<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image_Property extends Model
{
    use HasFactory;
    protected $guarded = [] ;
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

}
