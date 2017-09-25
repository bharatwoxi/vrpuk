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
<div class="row" class="text-center" style="background-color: #c2c2c2; padding: 10px;">
    <div class="col-sm-8">
        <h2>Welcome To POC of TSP : NN - For Vehicle Routing Problem</h2>
    </div>
    <div class="col-sm-4" style="margin-top: 1%" >
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Please Select to View Result
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="tspnnResult">Plot Route With Animated Symbol</a></li>
                <li><a href="tspnnResult">List Form</a></li>
                <li><a href="plotRouteElevation">Showing Elevation Along Path</a></li>

            </ul>
        </div>
    </div>
</div>

<div id="map"></div>

<script>
    // This example adds an animated symbol to a polyline.

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.509865, lng: -0.118092},
            zoom: 6,
            mapTypeId: 'terrain'
        });

        // Define the symbol, using one of the predefined paths ('CIRCLE')
        // supplied by the Google Maps JavaScript API.
        var lineSymbol = {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 6,
            strokeColor: '#393'
        };

        <?php
                $path = "[";
                $location = "";
                foreach ($data as $key => $value) {
                    $location = "{ lat:".$value['end_lat'].", lng:".$value['end_long']."},";
                    $path = $path.$location;
                }
                $path = $path."]";
         ?>


        // Create the polyline and add the symbol to it via the 'icons' property.
        var line = new google.maps.Polyline({
            path: <?php echo $path; ?>,
            icons: [{
                icon: lineSymbol,
                offset: '100%'
            }],
            map: map
        });

        animateCircle(line);
    }

    // Use the DOM setInterval() function to change the offset of the symbol
    // at fixed intervals.
    function animateCircle(line) {
        var count = 0;
        window.setInterval(function() {
            count = (count + 1) % 200;

            var icons = line.get('icons');
            icons[0].offset = (count / 2) + '%';
            line.set('icons', icons);
        }, 20);
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUoCkiBINurE1p3i2pUBFsSFpjHWiAudo&callback=initMap">
</script>

</body>
</html>
