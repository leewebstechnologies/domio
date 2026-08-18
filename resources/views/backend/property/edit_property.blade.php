@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Property</h6>

                        <form method="POST" action="{{ route('update.property') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $property->id }}" />
                            <div class="row">
                                <!-- Property Name -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Name</label>

                                        <input type="text" name="property_name" class="form-control" value="{{ $property->property_name }}">
                                    </div>
                                </div>


                                <!-- Property Status -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Status</label>

                                        <select class="form-select"
                                                id="exampleFormControlSelect1"
                                                name="property_status">

                                            <option selected disabled>
                                                Select Status
                                            </option>

                                            <option value="rent" {{ $property->property_status == 'rent' ? 'selected' : '' }}>
                                                For Rent
                                            </option>

                                            <option value="buy" {{ $property->property_status == 'buy' ? 'selected' : '' }}>
                                                For Buy
                                            </option>

                                        </select>
                                    </div>
                                </div>


                                <!-- Lowest Price -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            Lowest Price
                                        </label>

                                        <input type="text"
                                        name="lowest_price"
                                        class="form-control" value="{{ $property->lowest_price }}">
                                    </div>
                                </div>


                                <!-- Maximum Price -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            Maximum Price
                                        </label>

                                        <input type="text" name="max_price" class="form-control" value="{{ $property->max_price }}">
                                    </div>
                                </div>

                            </div>


                            <!-- Bedroom / Bathroom / Garage -->
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Bedroom
                                        </label>

                                        <input type="text" class="form-control" name="bedroom" value="{{ $property->bedroom }}">
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Bathroom
                                        </label>

                                        <input type="text" class="form-control" name="bathroom" value="{{ $property->bathroom }}">
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Garage
                                        </label>

                                        <input type="text" class="form-control" name="garage" value="{{ $property->garage }}">
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Garage Size
                                        </label>

                                        <input type="text" class="form-control" name="garage_size" value="{{ $property->garage_size }}">
                                    </div>
                                </div>

                            </div>


                            <!-- Address -->
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Address
                                        </label>

                                        <input type="text" class="form-control" name="address" value="{{ $property->address }}">
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            City
                                        </label>

                                        <input type="text" class="form-control" name="city" value="{{ $property->city }}">

                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            State
                                        </label>

                                        <input type="text" class="form-control" name="state" value="{{ $property->state }}">

                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Postal Code
                                        </label>

                                        <input type="text" class="form-control" name="postal_code" value="{{ $property->postal_code }}">

                                    </div>
                                </div>

                            </div>


                            <!-- Property Size / Video / Neighbourhood -->
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Property Size
                                        </label>

                                        <input type="text" class="form-control" name="property_size" value="{{ $property->property_size }}">
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Property Video
                                        </label>

                                        <input type="text" class="form-control" name="property_video" value="{{ $property->property_video }}">

                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Neighbourhood
                                        </label>

                                        <input type="text" class="form-control" name="neighbourhood" value="{{ $property->neighbourhood }}">

                                    </div>
                                </div>

                            </div>


                            <!-- Longitude / Latitude -->
                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Longitude
                                        </label>

                                        <input type="text" class="form-control" name="longtitude" value="{{ $property->longtitude }}">

                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html"
                                           target="_blank">

                                            Go here to get longitude from address

                                        </a>

                                    </div>

                                </div>


                                <div class="col-sm-6">

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Latitude
                                        </label>

                                        <input type="text" class="form-control" name="latitude" value="{{ $property->latitude }}">

                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html"
                                           target="_blank">

                                            Go here to get latitude from address

                                        </a>

                                    </div>

                                </div>

                            </div>


                            <!-- Property Type / Amenities / Agent -->
                            <div class="row">

                                <!-- Property Type -->
                                <div class="col-sm-4">

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Property Type
                                        </label>

                                        <select class="form-group form-select"
                                                name="ptype_id"
                                                id="exampleFormControlSelect1">

                                            <option selected disabled>
                                                Select Type
                                            </option>

                                            @foreach ($propertyType as $ptype)

                                                <option value="{{ $ptype->id }}"
                                                    {{ $ptype->id == $property->ptype_id ? 'selected' : '' }}>
                                                    {{ $ptype->type_name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                <!-- Amenities -->
                                <div class="col-sm-4">

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Property Amenities
                                        </label>

                                        <select name="amenity_id[]"
                                                class="js-example-basic-multiple form-select"
                                                multiple="multiple"
                                                data-width="100%">

                                            @foreach ($amenities as $amenity)

                                                <option value="{{ $amenity->id }}" {{ (in_array($amenity->id, $property_amenities)) ? 'selected' : '' }}>
                                                    {{ $amenity->amenities_name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                <!-- Agent -->
                                <div class="col-sm-4">

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Agent
                                        </label>

                                        <select class="form-select"
                                                name="agent_id"
                                                id="exampleFormControlSelect1">

                                            <option selected disabled>
                                                Select Agent
                                            </option>

                                            @foreach ($activeAgent as $agent)

                                                <option value="{{ $agent->id }}"
                                                    {{ $ptype->id == $property->agent_id ? 'selected' : '' }}>
                                                    {{ $agent->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>


                            <!-- Short Description -->
                            <div class="col-sm-12">

                                <div class="mb-3">

                                    <label class="form-label">
                                        Short Description
                                    </label>

                                    <textarea class="form-control"
                                    id="exampleFormControlTextarea1"
                                    name="short_desc"
                                    rows="3">
                                    {{ $property->short_desc }}
                                    </textarea>

                                </div>

                            </div>


                            <!-- Long Description -->
                            <div class="col-sm-12">

                                <div class="mb-3">

                                    <label class="form-label">
                                        Long Description
                                    </label>

                                    <textarea class="form-control"
                                    name="long_desc"
                                    name="tinymce"
                                    id="tinymceExample"
                                    rows="10">
                                    {!! $property->long_desc !!}
                                    </textarea>

                                </div>

                            </div>


                            <hr>


                            <!-- Featured / Hot -->
                            <div class="mb-3">

                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="featured" value="1" class="form-check-input"
                                    id="checkInline1" {{ $property->featured == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkInline1">
                                        Featured Property
                                    </label>
                                </div>


                                <div class="form-check form-check-inline">
                                    <input type="checkbox"
                                           name="hot"
                                           value="1"
                                           class="form-check-input"
                                           id="checkInline"
                                           {{ $property->hot == '1' ? 'checked' : '' }}>

                                    <label class="form-check-label"
                                           for="checkInline">

                                        Hot Property

                                    </label>

                                </div>

                            </div>


                            <!-- Submit -->
                            <button type="submit"
                                    class="btn btn-primary">

                                Save Changes

                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>

        <!-- middle wrapper end -->

    </div>
</div>

{{-- Property Main Thumnail Update --}}
<div class="page-content" style="margin-top: -35px;">
    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Main Thumbnail</h6>

                        <form method="POST" action="{{ route('update.property.thumbnail') }}" id="myForm" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{ $property->id }}">
                            <input type="hidden" name="old_img" value="{{ $property->main_thumbnail }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label class="form-label">
                                        Main Thumbnail
                                    </label>
                                    <input type="file" name="main_thumbnail" id="mainThumbnailInput"
                                    class="form-control" accept="image/*">
                                        <div class="mt-3">
                                            <img src=""
                                                id="mainThumbnail"
                                                alt="Main Thumbnail Preview"
                                                style="
                                                width: 200px;
                                                height: 150px;
                                                object-fit: cover;
                                                border-radius: 5px;
                                                border: 1px solid #ddd;
                                                display: none;
                                            ">
                                        </div>

                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">
                                    </label>
                                        <div class="mt-3">
                                            <img src="{{ asset($property->main_thumbnail) }}"
                                                id="mainThumbnail"
                                                alt="Main Thumbnail Preview"
                                                style="
                                                width: 100px;
                                                height: 100px;
                                                object-fit: cover;
                                                border-radius: 5px;
                                                border: 1px solid #ddd;
                                                ">
                                        </div>

                                </div>
                            </div>
                              <!-- Submit -->
                            <button type="submit"
                                    class="btn btn-primary">

                                Save Changes

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Property Main Thumbnail Update --}}


{{-- Property Multi Image Update --}}
<div class="page-content" style="margin-top: -35px;">
    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">

                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Multi Images</h6>

                        <form method="POST" action="{{ route('update.property.multiimage') }}" id="myForm" enctype="multipart/form-data">
                            @csrf

                            <div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>S/N</th>
												<th>Image</th>
												<th>Change Image</th>
												<th>Delete</th>
											</tr>
										</thead>
										<tbody>
                                            @foreach ($multiImages as $key => $image)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
												<td class="py-1">
													<img src="{{ asset($image->photo_name) }}" alt="image" style="width: 50px; height: 50px;">
												</td>
												<td>
                                                    <input type="file" class="form-control" name="multi_images[{{ $image->id }}]">
                                                </td>
												<td>
                                                   <input type="submit" class="btn btn-primary px-4" value="Update Image">
                                                   <a href="{{ route('delete.property.multiimage', $image->id) }}" class="btn btn-danger" id="delete">Delete</a>
                                                </td>
											</tr>
                                            @endforeach

										</tbody>
									</table>
								</div>
                        </form>

                         <form method="POST" action="{{ route('update.property.multiimage') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="file" class="form-control" name="multi_images">
                                        </td>
                                        <td>
                                            <input type="submit" class="btn btn-info px-4" value="Add Images">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- End Property Multi Image Update --}}



<script>

    document.addEventListener("DOMContentLoaded", function () {

        const mainThumbnailInput =
            document.getElementById("mainThumbnailInput");

        const mainThumbnail =
            document.getElementById("mainThumbnail");


        if (mainThumbnailInput && mainThumbnail) {

            mainThumbnailInput.addEventListener("change", function (event) {

                const file = event.target.files[0];

                if (!file) {

                    mainThumbnail.src = "";
                    mainThumbnail.style.display = "none";

                    return;
                }


                // Make sure the selected file is an image
                if (!file.type.startsWith("image/")) {

                    alert("Please select a valid image file.");

                    mainThumbnailInput.value = "";
                    mainThumbnail.src = "";
                    mainThumbnail.style.display = "none";

                    return;
                }


                const reader = new FileReader();


                reader.onload = function (e) {

                    mainThumbnail.src = e.target.result;

                    mainThumbnail.style.display = "block";

                };


                reader.readAsDataURL(file);

            });

        }

        const multiImages =
            document.getElementById("multiImages");

        const previewImg =
            document.getElementById("preview_img");


        if (multiImages && previewImg) {

            multiImages.addEventListener("change", function (event) {

                // Clear previous previews
                previewImg.innerHTML = "";


                const files = Array.from(event.target.files);


                if (files.length === 0) {
                    return;
                }


                files.forEach(function (file) {

                    // Ignore non-image files
                    if (!file.type.startsWith("image/")) {
                        return;
                    }


                    const reader = new FileReader();


                    reader.onload = function (e) {

                        const col =
                            document.createElement("div");

                        col.className =
                            "col-md-4 col-lg-3 mb-3";


                        const image =
                            document.createElement("img");


                        image.src =
                            e.target.result;

                        image.alt =
                            "Property Image Preview";


                        image.style.width =
                            "100%";

                        image.style.height =
                            "150px";

                        image.style.objectFit =
                            "cover";

                        image.style.borderRadius =
                            "6px";

                        image.style.border =
                            "1px solid #ddd";


                        col.appendChild(image);

                        previewImg.appendChild(col);

                    };


                    reader.readAsDataURL(file);

                });

            });

        }

    });

</script>

<script>

    $(document).ready(function () {

        $('#myForm').validate({

            rules: {

                property_name: {
                    required: true
                },

                property_status: {
                    required: true
                },

                lowest_price: {
                    required: true
                },

                max_price: {
                    required: true
                },

                ptype_id: {
                    required: true
                }

            },


            messages: {

                property_name: {
                    required: 'Please Enter Property Name'
                },

                property_status: {
                    required: 'Please Select Property Status'
                },

                lowest_price: {
                    required: 'Please Enter Lowest Price'
                },

                max_price: {
                    required: 'Please Enter Maximum Price'
                },

                ptype_id: {
                    required: 'Please Enter Property Type'
                }

            },


            errorElement: 'span',


            errorPlacement: function (error, element) {

                error.addClass('invalid-feedback');

                element
                    .closest('.form-group')
                    .append(error);

            },


            highlight: function (element) {

                $(element).addClass('is-invalid');

            },


            unhighlight: function (element) {

                $(element).removeClass('is-invalid');

            }

        });

    });

</script>


@endsection
