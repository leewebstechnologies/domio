<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
// use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function AllTypes() {
        $types = PropertyType::latest('created_at')->get();
        return view('backend.type.all_types', compact('types'));

    }
    // End Method
}
