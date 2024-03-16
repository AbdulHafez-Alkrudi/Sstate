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
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];
    const CHEAP_RENT_FROM = 1 ;
    const CHEAP_RENT_TO   = 500;

    const CHEAP_SALE_FROM = 1 ;
    const CHEAP_SALE_TO   = 15000;

    const MEDIUM_RENT_FROM = 501;
    const MEDIUM_RENT_TO = 2000 ;

    const MEDIUM_SALE_FROM = 15001;
    const MEDIUM_SALE_TO   = 50000;

    const EXPENSIVE_RENT_FROM = 2001;
    const EXPENSIVE_SALE_FROM = 50001;


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

    // Here are the scopes sections:

    public function scopeForSale($query){
        return $query->where('for_rent' , '=' , 0);
    }
    public function scopeForRent($query){
        return $query->where('for_rent' , '=' , 1);
    }

    public function scopeRentCheap($query){
        return $query->where('for_rent' , 1)->
        whereBetween('price' , [self::CHEAP_RENT_FROM , self::CHEAP_RENT_TO]);
    }
    public function scopeRentMedium($query){
        return $query->where('for_rent' , 1)->
        whereBetween('price', [self::MEDIUM_RENT_FROM , self::MEDIUM_RENT_TO]);
    }
    public function scopeRentExpensive($query){
        return $query->where('for_rent' , 1)->
        where('price' , '>' , self::EXPENSIVE_RENT_FROM);
    }

    public function scopeSaleCheap($query){
        return $query->where('for_rent' , 0)->
        whereBetween('price' , [self::CHEAP_SALE_FROM , self::CHEAP_SALE_TO]);
    }
    public function scopeSaleMedium($query){
        return $query->where('for_rent' , 0)->
        whereBetween('price', [self::MEDIUM_SALE_FROM , self::MEDIUM_SALE_TO]);
    }
    public function scopeSaleExpensive($query){
        return $query->where('for_rent' , 0)->
        where('price' , '>' , self::EXPENSIVE_SALE_FROM);
    }


    /*
     *  the user can search for a property according to 5 properties:
     * 1- street name
     * 2- category
     * 3- if the user want to rent or buy a property
     * 4- the price
     * 5- the space
    */

    public function scopeFilter($query , array $filters)
    {

        // Applying the first property: According to the street name

        // checking of the user has entered a street name:
        // if it's existed, I want to bring the ID of that street, and if there is no such a street
        // I'll return nothing

        $query->when($filters['street'] ?? false , fn($query , $street) =>
            $query->whereHas('street' , fn($query) =>
                    $query->where('name_EN' , 'regexp' , $street)
                          ->orWhere('name_AR' , 'regexp' , $street)
            )
        );
        // Second property: According to the category
        $query->when($filters['category'] ?? false , fn($query , $category) =>
            $query->whereHas('category')

        );

        // Third property: get the properties that are for sale or rent:
        // TODO: it may cause a bug, so test it carefully
        $query->when($filters['for_rent'] ?? false , function($query , $forRent){
            if($forRent) $query->forRent();
            else $query->forSell();
        });

        // Forth property: According to the price:
        $query->when($filters['class'] ?? false , function($query , $class) use($filters){
                // here there are three cases:
                // if the users didn't choose if the property for sale or for rent:


                // instead of using multiple ifs, I'll construct the function name :)
                $sale_method_name = "sale".ucfirst($class);
                $rent_method_name = "rent".ucfirst($class);

                if(!array_key_exists('for_rent' , $filters)){
                    $query->where(function($query) use($sale_method_name , $rent_method_name){
                        $query->where(
                            fn($query) => $query->$rent_method_name())
                            ->orWhere(fn($query) => $query->$sale_method_name());
                    });
                }
                else{
                    $query->where(function($query) use($filters , $class , $sale_method_name , $rent_method_name){
                        // Just I'm checking if the property for sale or rent
                        $query->when($filters['for_rent'] ,
                            fn($query) =>
                                $query->$rent_method_name()
                            ,
                            fn($query) =>
                                $query->$sale_method_name()
                        );
                    });
                }
        });
        $query->when($filters['space'] ?? false , fn($query , $space) =>
                $query -> where('space' , '>=' , $space)
        );
    }


}
