<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function AllAmenities() {
        $amenities = Amenities::latest('created_at')->get();
        return view('backend.amenity.all_amenities', compact('amenities'));

    }
    // End Method

    public function AddAmenity() {
        return view('backend.amenity.add_amenity');
    }

    public function StoreAmenity(Request $request) {

        // Validation
        $request->validate([
            'amenities_name' => 'required|unique:amenities|max:200',
        ]);

        Amenities::create([
            'amenities_name' => $request->amenities_name,
        ]);

        $notification = array(
            'message' => 'Amenity Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenities')->with($notification);

    }
    // End Method

    public function EditAmenity(mixed $id) {
        $amenities = Amenities::findOrFail($id);
        return view('backend.amenity.edit_amenity', compact('amenities'));
    }

    public function UpdateAmenity(Request $request) {

        $pid = $request->id;

        Amenities::findOrFail($pid)->update([
            'amenities_name' => $request->amenities_name,
        ]);

        $notification = array(
            'message' => 'Amenity Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenities')->with($notification);

    }
    // End Method

    public function DeleteAmenity(mixed $id) {
        Amenities::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Amenity Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }   
}
