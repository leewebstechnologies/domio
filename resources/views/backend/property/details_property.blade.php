@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Property Details</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Property Name</td>
                                    <td><code>{{ $property->property_name }}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Status</td>
                                    <td><code>{{ $property->property_status }}</code></td>
                                </tr>
                                <tr>
                                    <td>Lowest Price</td>
                                    <td><code>{{ $property->lowest_price }}</code></td>
                                </tr>
                                <tr>
                                    <td>Max Price</td>
                                    <td><code>{{ $property->max_price }}</code></td>
                                </tr>
                                <tr>
                                    <td>Bedroom</td>
                                    <td><code>{{ $property->bedroom }}</code></td>
                                </tr>
                                <tr>
                                    <td>Bathroom</td>
                                    <td><code>{{ $property->bathroom }}</code></td>
                                </tr>
                                <tr>
                                    <td>Garage</td>
                                    <td><code>{{ $property->garage }}</code></td>
                                </tr>
                                <tr>
                                    <td>Garage Size</td>
                                    <td><code>{{ $property->garage_size }}</code></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><code>{{ $property->address }}</code></td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td><code>{{ $property->state }}</code></td>
                                </tr>
                                <tr>
                                    <td>Postal Code</td>
                                    <td><code>{{ $property->postal_code }}</code></td>
                                </tr>
                                <tr>
                                    <td>Main Thumbnail</td>
                                    <td><img src="{{ asset($property->main_thumbnail) }}"
                                         alt=""
                                         style="width: 100px; height: 70px;"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Property Status</td>
                                     <td>
                                    @if ($property->status == 1)
                                    <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                    <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Property Code</td>
                                    <td><code>{{ $property->property_code }}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Size</td>
                                    <td><code>{{ $property->property_size }}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Video</td>
                                    <td><code>{{ $property->property_video }}</code></td>
                                </tr>
                                <tr>
                                    <td>Neighbourhood</td>
                                    <td><code>{{ $property->neighbourhood }}</code></td>
                                </tr>
                                <tr>
                                    <td>Longitude</td>
                                    <td><code>{{ $property->longitude }}</code></td>
                                </tr>
                                <tr>
                                    <td>Latitude</td>
                                    <td><code>{{ $property->latitude }}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Type</td>
                                    <td><code>{{ $property['type']['type_name'] }}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Amenities</td>
                                    <td>
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
                                    </td>
                                </tr>
                                <tr>
                                    <td>Agent</td>
                                        @if ($property->agent_id == NULL)
                                        <td><code>Admin</code></td>
                                        @else
                                         <td><code>{{ $property['user']['name'] }}</code></td>
                                        @endif
                                </tr>
                                {{-- <tr>
                                    <td>Short Description</td>
                                    <td><code>{{ $property->short_desc }}</code></td>
                                </tr>
                                <tr>
                                    <td>Long Description</td>
                                    <td><code>{!! $property->long_desc !!}</code></td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <br>
                        @if ($property->status == 1)
                        <form action="{{ route('inactive.property') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $property->id }}">
                            <button type="submit" class="btn btn-primary">Inactive</button>
                        </form>
                        @else
                        <form action="{{ route('active.property') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $property->id }}">
                            <button type="submit" class="btn btn-primary">Active</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Bordered table</h6>
                    <p class="text-muted mb-3">Add class <code>.table-bordered</code></p>
                    <div class="table-responsive pt-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Progress</th>
                                    <th>Salary</th>
                                    <th>Start date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Cedric Kelly</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>$206,850</td>
                                    <td>June 21, 2022</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Haley Kennedy</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>$313,500</td>
                                    <td>May 15, 2022</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Bradley Greer</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>$132,000</td>
                                    <td>Apr 12, 2022</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Brenden Wagner</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>$206,850</td>
                                    <td>June 21, 2022</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Bruno Nash</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>$163,500</td>
                                    <td>January 01, 2022</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Sonya Frost</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>$103,600</td>
                                    <td>July 18, 2022</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Zenaida Frank</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>$313,500</td>
                                    <td>March 22, 2022</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
