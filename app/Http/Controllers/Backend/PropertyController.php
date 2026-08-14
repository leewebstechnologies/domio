<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

// use App\Models\MultiImage;
// use App\Models\Facility;

class PropertyController extends Controller
{
    public function AllProperties() {
        $property = Property::latest('created_at')->get();
        return view('backend.property.all_properties', compact('property'));
    }
    // End Method

    public function AddProperty() {
        $propertyType = PropertyType::latest('created_at')->get();
        $amenities = Amenities::latest('created_at')->get();
        $activeAgent = User::query()->where('status', '1')->where('role', 'agent')->latest()->get();
        return view('backend.property.add_property', compact('propertyType', 'amenities', 'activeAgent'));
    }
    // End Method

    public function StoreProperty(Request $request) {
        $amenity = $request->amenity_id;
        $amenities = implode(",", $amenity);
        // dd($amenities);

        $pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);

        $image = $request->file('main_thumbnail');
        $manager = new ImageManager(new Driver);
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($image);
        $img->resize(370, 250)->save(public_path('upload/property/thumbnail/'.$name_gen));
        $save_url = 'upload/property/thumbnail'.$name_gen;

        $property_id = Property::insertGetId([
            'ptype_id' => $request->ptype_id,
            'amenity_id' => $amenities,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            
            'main_thumbnail' => $save_url,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'garage' => $request->garage,

            'garage_size' => $request->garage_size,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighbourhood' => $request->neighbourhood,
            'longtitude' => $request->longtitude,
            'latitude' => $request->latitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
