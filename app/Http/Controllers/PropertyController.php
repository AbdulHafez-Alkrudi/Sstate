<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Math\PrimeField\Integer;

class PropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::query()->filter(request(['street','category' ,'for_rent' , 'class' , 'space']))->get();
        return $this->sendResponse($properties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input , [
            'category_id'         => 'required',
            'street_id'           => 'required',
            'price'               => 'required',
            'floor'               => 'required',
            'number_of_rooms'     => 'required',
            'number_of_kitchens'  => 'required',
            'number_of_bathrooms' => 'required',
            'space'               => 'required',
            'rent'                => 'required',
            'images'              => 'required|'
        ]);



        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        Property::create($input);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $property = Property::query()->where('id' , $id)->get();
        $property->update('popularity' , $property['popularity'] + 1) ;

        return $this->sendResponse($property);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
