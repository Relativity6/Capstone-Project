var map;
var service;
var infowindow;

function initMap() {
    var mapEl = document.getElementById('map');
    navigator.geolocation.getCurrentPosition(success, fail);

    function success(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var location = new google.maps.LatLng(lat, long);

        infowindow = new google.maps.InfoWindow();

        map = new google.maps.Map(mapEl, {center: location, zoom: 13});

        var request = {
            location: location,
            radius: '5000',
            query: "doctor"
        };

        var service = new google.maps.places.PlacesService(map);
        service.textSearch(request, callback);

        
    }

    function callback(results, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            var place = results[i];
            createMarker(results[i]);
          }
        }
      }

    function fail() {
        mapEl.classList.add('fail');
        mapEl.textContent = "Unable to retrieve your location.";
    }

    function createMarker(place) {
        if (!place.geometry || !place.geometry.location)
            return;
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            title: place.name + '\n' + place.formatted_address
        });
        google.maps.event.addListener(marker, "click", function () {
            infowindow.setContent(place.name || "");
            infowindow.open(map);
        });
    }

}

window.initMap = initMap;
