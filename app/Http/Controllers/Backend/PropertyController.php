<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Property;
// use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function AllProperties() {
        $property = Property::latest('created_at')->get();
        return view('backend.property.all_properties', compact('property'));
    }
}
