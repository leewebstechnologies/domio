<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PropertyController extends Controller
{
    public function AllProperties()
    {
        $property = Property::latest('created_at')->get();

        return view('backend.property.all_properties', compact('property'));
    }

    public function AddProperty()
    {
        $propertyType = PropertyType::latest('created_at')->get();

        $amenities = Amenities::latest('created_at')->get();

        $activeAgent = User::query()
            ->where('status', '1')
            ->where('role', 'agent')
            ->latest()
            ->get();

        return view(
            'backend.property.add_property',
            compact('propertyType', 'amenities', 'activeAgent')
        );
    }

    /**
     * Store a new property.
     */
    public function StoreProperty(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'property_name' => 'required|string|max:255',

            'property_status' => 'required|in:rent,buy',

            'ptype_id' => 'required',

            'city' => 'required|string|max:255',

            'main_thumbnail' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'multi_images' => 'nullable|array',

            'multi_images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Amenities
        |--------------------------------------------------------------------------
        */

        $amenity = $request->input('amenity_id', []);

        $amenities = implode(',', $amenity);


        /*
        |--------------------------------------------------------------------------
        | Generate Property Code
        |--------------------------------------------------------------------------
        */

        $pcode = IdGenerator::generate([
            'table' => 'properties',
            'field' => 'property_code',
            'length' => 5,
            'prefix' => 'PC',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Upload Directories
        |--------------------------------------------------------------------------
        */

        $thumbnailDirectory = public_path(
            'upload/property/thumbnail'
        );

        $multiImageDirectory = public_path(
            'upload/property/multi_images'
        );

        if (!is_dir($thumbnailDirectory)) {
            mkdir($thumbnailDirectory, 0755, true);
        }

        if (!is_dir($multiImageDirectory)) {
            mkdir($multiImageDirectory, 0755, true);
        }


        /*
        |--------------------------------------------------------------------------
        | Main Thumbnail Upload
        |--------------------------------------------------------------------------
        */

        $image = $request->file('main_thumbnail');

        $manager = new ImageManager(
            new Driver()
        );

        $name_gen = hexdec(uniqid()) . '.' .
            $image->getClientOriginalExtension();

        $img = $manager->read($image);

        $img->resize(370, 250)->save(
            $thumbnailDirectory . '/' . $name_gen
        );

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        | Store the relative path in the database.
        |--------------------------------------------------------------------------
        */

        $save_url = 'upload/property/thumbnail/' . $name_gen;


        /*
        |--------------------------------------------------------------------------
        | Property Slug
        |--------------------------------------------------------------------------
        */

        $propertySlug = strtolower(
            str_replace(
                ' ',
                '-',
                trim($request->property_name)
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Insert Property
        |--------------------------------------------------------------------------
        */

        $property_id = Property::insertGetId([
            'ptype_id' => $request->ptype_id,

            'amenity_id' => $amenities,

            'property_name' => $request->property_name,

            'property_slug' => $propertySlug,

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

            'featured' => $request->featured ?? 0,

            'hot' => $request->hot ?? 0,

            'agent_id' => $request->agent_id,

            'status' => 1,

            'created_at' => Carbon::now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Multiple Images Upload
        |--------------------------------------------------------------------------
        */

        $images = $request->file('multi_images', []);

        foreach ($images as $image) {

            $manager = new ImageManager(
                new Driver()
            );

            $make_name = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();

            $multiImage = $manager->read($image);

            $multiImage->resize(770, 520)->save(
                $multiImageDirectory . '/' . $make_name
            );

            $uploadPath =
                'upload/property/multi_images/' . $make_name;


            MultiImage::create([
                'property_id' => $property_id,

                'photo_name' => $uploadPath,

                'created_at' => Carbon::now(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Facilities
        |--------------------------------------------------------------------------
        */

        $facilityNames = $request->input(
            'facility_name',
            []
        );

        $distances = $request->input(
            'distance',
            []
        );

        foreach ($facilityNames as $index => $facilityName) {

            /*
            |--------------------------------------------------------------------------
            | Skip empty facility rows
            |--------------------------------------------------------------------------
            */

            if (empty($facilityName)) {
                continue;
            }

            $facility = new Facility();

            $facility->property_id = $property_id;

            $facility->facility_name = $facilityName;

            $facility->distance =
                $distances[$index] ?? null;

            $facility->save();
        }


        /*
        |--------------------------------------------------------------------------
        | Success Notification
        |--------------------------------------------------------------------------
        */

        $notification = [
            'message' => 'Property Created Successfully!',
            'alert-type' => 'success',
        ];


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('all.properties')
            ->with($notification);
    }
    // End Method

    public function EditProperty(mixed $id) {
        $property = Property::findOrFail($id);
         $propertyType = PropertyType::latest('created_at')->get();

        $amenities = Amenities::latest('created_at')->get();

        $activeAgent = User::query()
            ->where('status', '1')
            ->where('role', 'agent')
            ->latest()
            ->get();

        return view('backend.property.edit_property', compact('property', 'propertyType', 'amenities', 'activeAgent'));
    }


}
