@extends('layouts.website.main')


@section('content')

    <div id="app">
        <example-component :order="4" :customer="'34.7313827,36.7080187'" :driver="'35.7313827,36.7080187'"></example-component>
    </div>
 <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">



    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCSt4ABayMg8O3n9Hvxb_vrs_1oUfWXuA&loading=async&callback=initMap">
    </script>






    <!--google map scripts-->
    <script>
        // Initialize and add the map
        // let map;

        // async function initMap() {
        //     // The location of Uluru
        //     const position = {
        //         lat: -25.344,
        //         lng: 131.031
        //     };
        //     // Request needed libraries.
        //     //@ts-ignore

        //     // The map, centered at Uluru
        //     map = new google.maps.Map(document.getElementById("map"), {
        //         zoom: 4,
        //         center: position,
        //     });

        //     // The marker, positioned at Uluru
        //     // const marker = new AdvancedMarkerElement({
        //     //     map: map,
        //     //     position: position,
        //     //     title: "Uluru",
        //     // });
        // }

        // initMap();
    </script>
@endsection
