@extends('layouts.app')
@section('title', 'Map')
@section('header_scripts')

    <script async defer
            src= "https://maps.googleapis.com/maps/api/js?key=AIzaSyC3i0kUn8NHBQ5RjzFHTn4VK56PJQNGOKo&callback=initMap">
    </script>
    <link rel="stylesheet" href="{{asset('css/map.css')}}">

@endsection
@section('content')

    <h1 class="text-center text-white">Here you can search a store in your area</h1>

    <div id="map"></div>

    <script>
        let map, infoWindow;

        function initMap() {

            map = new google.maps.Map(document.getElementById("map"), {
                center: {lat: 48.210033, lng: 16.363449},
                zoom: 8,
            });
            infoWindow = new google.maps.InfoWindow();
            const locationButton = document.createElement("button");
            locationButton.textContent = "Pin to Current Location";
            locationButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
            locationButton.addEventListener("click", () => {
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            map.zoom = 14;
                            infoWindow.setPosition(pos);
                            infoWindow.setContent("Location found.");
                            infoWindow.open(map);
                            map.setCenter(pos);
                        },
                        () => {
                            handleLocationError(true, infoWindow, map.getCenter());
                        }
                    );
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            });
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(
                browserHasGeolocation
                    ? "Error: The Geolocation service failed."
                    : "Error: Your browser doesn't support geolocation."
            );
            infoWindow.open(map);
        }
    </script>

@endsection
