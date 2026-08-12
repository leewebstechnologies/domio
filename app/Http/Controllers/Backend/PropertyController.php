<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;

// use App\Models\MultiImage;
// use App\Models\Facility;
// use Illuminate\Http\Request;

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
}
