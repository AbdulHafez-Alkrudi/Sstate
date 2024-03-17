<?php

namespace App\Http\Controllers;

use App\Models\Image_Property;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Math\PrimeField\Integer;

class PropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $properties = Property::query()->filter(request(['street','category' ,'for_rent' , 'class' , 'space']))->get();
        return $this->sendResponse($properties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
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
            'for_rent'            => 'required',
            'images'              => 'array|present',
        ]);

        if($validator->fails()){
            DB::rollBack();
            return $this->sendError($validator->errors());
        }

        $input['user_id'] = Auth::id();
        $property = Property::create(Arr::except($input , ['images']));

        foreach($request['images'] as $image){
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/properties_images') , $image_name);
            $image_name = 'images/properties_images/'.$image_name;

            Image_Property::create([
               'property_id' => $property['id'],
               'image' => $image_name
            ]);

        }
        DB::commit();
        return $this->sendResponse([]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $property = Property::find($id);
        $property->update( ['popularity' => $property['popularity'] + 1] ) ;
        $images_paths = Image_Property::query()->where('property_id' , $id)->get();

        $images = array();
        foreach($images_paths as $path){
            $images[]= base64_encode(file_get_contents(public_path($path['image'])));
        }
        $property['images'] = $images ;
        return $this->sendResponse($property);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
