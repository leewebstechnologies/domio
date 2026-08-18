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
        | Insert Property
        |--------------------------------------------------------------------------
        */

        $property_id = Property::insertGetId([
            'ptype_id' => $request->ptype_id,

            'amenity_id' => $amenities,

            'property_name' => $request->property_name,

            'property_slug' => strtolower(str_replace(' ', '-', trim($request->property_name))),

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

        $notification = [
            'message' => 'Property Created Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()
            ->route('all.properties')
            ->with($notification);
    }
    // End Method

    public function EditProperty(mixed $id) {
        $property = Property::findOrFail($id);

        // $type = $request->input('amenity_id', []);
        $type = $property->amenity_id;

        $property_amenities = explode(',', $type);

        $multiImages = MultiImage::where('property_id', $id)->get();

        $propertyType = PropertyType::latest('created_at')->get();

        $amenities = Amenities::latest('created_at')->get();

        $activeAgent = User::query()
            ->where('status', '1')
            ->where('role', 'agent')
            ->latest()
            ->get();

        return view('backend.property.edit_property', compact('property', 'propertyType', 'amenities', 'activeAgent', 'property_amenities', 'multiImages'));
    }
    // End Method

    public function UpdateProperty(Request $request) {
        $amenity = $request->amenity_id;
        $amenities = implode(',', $amenity);

        $property_id = $request->id;
        Property::findOrFail($property_id)->update([
            'ptype_id' => $request->ptype_id,
            'amenity_id' => $amenities,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', trim($request->property_name))),
            'property_status' => $request->property_status,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
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
            'created_at' => Carbon::now(),

        ]);

        $notification = [
            'message' => 'Property Updated Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.properties')->with($notification);

    }

    public function UpdatePropertyThumbnail(Request $request) {
        $pro_id = $request->id;
        $oldImage = $request->old_img;


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

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Property::findOrFail($pro_id)->update([
            'main_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);


        $notification = [
            'message' => 'Property Image Thumbnail Updated Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

   public function UpdatePropertyMultiimage(Request $request) {
        $request->validate([
            'multi_images' => 'required|array',
            'multi_images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        // Multi-image upload directory
        $multiImageDirectory = public_path(
            'upload/property/multi_images'
        );

        // Create directory if it does not exist
        if (!is_dir($multiImageDirectory)) {
            mkdir($multiImageDirectory, 0755, true);
        }

        $images = $request->file('multi_images', []);

        foreach ($images as $id => $image) {

            // Find existing multi-image record
            $imageDel = MultiImage::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Delete old image
            |--------------------------------------------------------------------------
            | photo_name contains a relative path such as:
            | upload/property/multi_images/123456.jpg
            |
            | Convert it to the full public path before deleting.
            |--------------------------------------------------------------------------
            */

            $oldImagePath = public_path($imageDel->photo_name);

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            /*
            |--------------------------------------------------------------------------
            | Create new image name
            |--------------------------------------------------------------------------
            */

            $manager = new ImageManager(
                new Driver()
            );

            $make_name = hexdec(uniqid()) . '.' .
                $image->getClientOriginalExtension();

            /*
            |--------------------------------------------------------------------------
            | Read and resize image
            |--------------------------------------------------------------------------
            */

            $multiImage = $manager->read($image);

            $multiImage->resize(770, 520)->save(
                $multiImageDirectory . '/' . $make_name
            );

            /*
            |--------------------------------------------------------------------------
            | Store relative path in database
            |--------------------------------------------------------------------------
            */

            $uploadPath =
                'upload/property/multi_images/' . $make_name;

            $imageDel->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = [
            'message' => 'Property Multi-Images Updated Successfully!',
            'alert-type' => 'success',
        ];

        return redirect()
            ->back()
            ->with($notification);
        }
        // End Method

        public function DeletePropertyMultiimage(mixed $id) {
           $oldImage = MultiImage::findOrFail($id);
           unlink($oldImage->photo_name);

           MultiImage:: findOrFail($id)->delete();

            $notification = [
            'message' => 'Property Multi-Images Deleted Successfully!',
            'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);

        }


}
