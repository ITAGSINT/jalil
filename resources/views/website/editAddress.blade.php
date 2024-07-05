@extends('layouts.website.main')
@section('additional_styles')
<link href="{{URL::asset('css/add.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/no.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/addone.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/changetwo.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/addresses.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
        <div class="row w-100">
            <div class="col-12 d-flex">
                <a class="btn" href="">
                <i class="fa-solid fa-chevron-left left"></i></a>
               <p class="add">Addresses</p>
            </div>
            </div>
        </div>
        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
        <div class="container">
            <div class="row w-100">
              <div class="col-lg-6 col-md-12 row ">
                <div class="col-12  choose choose-right">
                  <div class="row w-100 ">
                    <div class="col-12 ">
                      <p class="right">Edit Delivery Address</p>
                    </div>
                   
                   </div>
                   <div class="row w-100 ">
                    <div class="col-12 ">
                        <p class="emirate">Edit Delivery Address</p>
                    </div>
                   
                   </div>
                   <form method='POST' action="{{route('website.addresses.update')}}">
                  @csrf
                   <div class="row w-100 justify-content-center pt-1 h-100  address" >
                    <div class="col-12">
                        <div class="input-group mb-3">
                           <!-- <input type="text" class="form-control Current-Location" placeholder="Current Location" aria-label="Username" aria-describedby="basic-addon1">-->
                          
                           
                           <input class=" form-control" type="text" id="locationName" name="address" value="{{$address->address}}">
                          </div>
                          
                          <div id="map"  class='rounded my-2 img-fluid' style='height:300px; width:100%;'></div>
                          <!--<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d2503345.026653993!2d5.2793703!3d52.2129919!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snl!4v1716894214590!5m2!1sen!2snl" width="100%" height="60%" style="border:0;border-radius: 24px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
                         
                             
                    </div>
                   
                           
                    </div>
                </div>
              </div>
          
          
          
          
          
          
          
              <div class="col-lg-6 col-md-12 row ">
                
                <div class="col-12  choose choose-left" >
                
                  <div class="row w-100 pt-4">
                    <div class="row w-100">
                    <div class="col-12">
                      <div class="mb-3">
                      <input type="text" class="form-control add-input" id="exampleFormControlInput1" placeholder="Filled" name="id" required value="{{$address->id}}" hidden>
                        <label for="exampleFormControlInput1" class="form-label add-label">Address Type</label>
                        <input type="text" class="form-control add-input" id="exampleFormControlInput1" placeholder="Filled" name="name" required value="{{$address->name}}">
                      </div></div>
                      
                      <div class="mb-3">
                        <label for="exampleFormControlInput2" class="form-label add-label">Your Street Address</label>
                        <input type="text" class="form-control add-input" id="exampleFormControlInput2" placeholder="Filled" name="street" value="{{$address->street}}">
                      </div>
                     
                    </div>
                 <div class="row w-100">
                  <div class="col-md-12 col-sm-12">
                    <div class="mb-3">
                      <label for="exampleFormControlInput3" class="form-label add-label">Your City</label>
                      <input type="text" class="form-control add-input" id="exampleFormControlInput3" placeholder="Filled" name="city" value="{{$address->city}}">
                    </div>
                     </div>
                     <div class="col-md-12 col-sm-12">
                      <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label add-label">State/Province/Region</label>
                        <input type="text" class="form-control add-input" id="exampleFormControlInput4" placeholder="Filled" name="state" value="{{$address->state}}">
                      </div>
                       </div>
                 </div>
                 <div class="row w-100">
                  
                 <input class=" form-control" type="text" id="latitude" name="lat"  required value="{{$address->loc_lat}}" hidden>
                           <input class=" form-control" type="text" id="longitude" name="long"  required value="{{$address->loc_long}}" hidden>
                 </div>
                 <input type="submit" class="btn next "  role="button" value="Edit Address">
                   </div>  
          
          
                   </form>
                </div>
                          
              </div>
            </div>
          </div>
@endsection
@section('additional_scripts')
<script src="{{ URL::asset('js/changetwo.js') }}"></script> 

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCSt4ABayMg8O3n9Hvxb_vrs_1oUfWXuA&callback=initMap" async defer></script>
<script>
        let map;
        // function initMap() {
        //     // Default location (center of the map)
        //     const defaultLocation = { lat: -34.397, lng: 150.644 };

        //     // Create a map object and specify the DOM element for display.
        //     map = new google.maps.Map(document.getElementById('map'), {
        //         center: defaultLocation,
        //         zoom: 8,
        //     });

        //     // Set the location from the server
        //     const location = {
        //         lat: {{ $address->loc_lat }},
        //         lng: {{ $address->loc_long }}
        //     };

        //     // Center map on the location
        //     map.setCenter(location);

        //     // Place a marker on the location
        //     new google.maps.Marker({
        //         position: location,
        //         map: map,
        //     });
        // }


        function initMap() {
            // Initialize geocoder
            geocoder = new google.maps.Geocoder();

            // Try HTML5 geolocation
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        // Initialize the map centered on the user's current position
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: pos,
                            zoom: 8
                        });
                        const location = {
                lat: {{ $address->loc_lat }},
                lng: {{ $address->loc_long }}
            };

            // Center map on the location
            map.setCenter(location);

                        // Initialize the marker
                        marker = new google.maps.Marker({
                        position: location,
                            map: map,
                            draggable: true
                        });

                        // Update the input fields with the current position
                        // document.getElementById('latitude').value = pos.lat;
                        // document.getElementById('longitude').value = pos.lng;

                        // Reverse geocode the current position to get the location name
                        geocodeLatLng(location.lat, location.lng);

                        // Update latitude and longitude input fields on marker drag
                        google.maps.event.addListener(marker, 'dragend', function(event) {
                            const newPos = event.latLng;
                            document.getElementById('latitude').value = newPos.lat();
                            document.getElementById('longitude').value = newPos.lng();
                            // Reverse geocode the new position
                            geocodeLatLng(newPos.lat(), newPos.lng());
                        });
                    },
                    function() {
                        handleLocationError(true, map.getCenter());
                    }
                );
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, map.getCenter());
            }

            // Add event listeners to the input fields to update the map
            document.getElementById('latitude').addEventListener('change', updateMap);
            document.getElementById('longitude').addEventListener('change', updateMap);
            document.getElementById('locationName').addEventListener('change', geocodeLocation);
        }


        function geocodeLocation() {
            const location = document.getElementById('locationName').value;
            geocoder.geocode({ 'address': location }, function(results, status) {
                if (status === 'OK') {
                    // Get the location coordinates from the geocode result
                    const pos = results[0].geometry.location;

                    // Re-center the map to the new position
                    map.setCenter(pos);
                    // Move the marker to the new position
                    marker.setPosition(pos);

                    // Update latitude and longitude input fields
                    document.getElementById('latitude').value = pos.lat();
                    document.getElementById('longitude').value = pos.lng();
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }


        function geocodeLatLng(lat, lng) {
            const latlng = { lat: lat, lng: lng };
            geocoder.geocode({ 'location': latlng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('locationName').value = results[0].formatted_address;
                    } else {
                        document.getElementById('locationName').value = 'Location not found';
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        }

    </script>
@endsection