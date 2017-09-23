<!DOCTYPE html>
<html>
<head>
    <title>Welcome To TSP:NN - For Vehicle Routing Problem<</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div class="text-center" style="background-color: #c2c2c2; padding: 10px;">
    <h2>Welcome To POC of TSP : NN - For Vehicle Routing Problem
        <button type="button" class="btn btn-success">
            <a href="#" style="color: #f5f5f5">Calculate Distances using GDM API - Click Here</a>
        </button>
    </h2>
</div>
<div id="map"></div>
<script>
    var customLabel = {
        S: {
            label: 'S'
        },
        D: {
            label: 'D'
        }
    };

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(51.509865, -0.118092),
            zoom: 5
        });
        var infoWindow = new google.maps.InfoWindow;

        // Change this depending on the name of your PHP or XML file
        downloadUrl('http://www.vrpuk.woxisoftware.com/plotDataJsonAPI', function(data) {
            var jsonObj = JSON.parse(data.responseText);
            Array.prototype.forEach.call(jsonObj, function(markerElem) {
                var name = markerElem.city_name;
                var address = markerElem.address;
                var station_name = markerElem.station_name;
                var type = markerElem.type;
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.lat),
                    parseFloat(markerElem.long));

                var infowincontent = document.createElement('div');
                var strong = document.createElement('strong');
                strong.textContent = name + " : " + station_name
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = address
                infowincontent.appendChild(text);
                var icon = customLabel[type] || {};
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    label: icon.label
                });
                marker.addListener('click', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
            });
        });
    }



    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_9io6iFi5rLAp1sGU73AYruIUbaW4-qc&callback=initMap">
</script>
</body>
</html>
