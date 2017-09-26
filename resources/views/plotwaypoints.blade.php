<!DOCTYPE html>
<html>
<head>
    <title>Welcome To TSP:NN - For Vehicle Routing Problem<</title>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
        #right-panel {
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        #right-panel select, #right-panel input {
            font-size: 15px;
        }

        #right-panel select {
            width: 100%;
        }

        #right-panel i {
            font-size: 12px;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 100%;
            float: left;
            width: 70%;
            height: 100%;
        }
        #right-panel {
            margin: 20px;
            border-width: 2px;
            width: 20%;
            height: 400px;
            float: left;
            text-align: left;
            padding-top: 0;
        }
        #directions-panel {
            margin-top: 10px;
            background-color: #FFEE77;
            padding: 10px;
            overflow: scroll;
            height: 450px;
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
                <li><a href="tspnnResult">List Form</a></li>
                <li><a href="tspnnResult">Plot Route With Animated Symbol</a></li>
                <!--<li><a href="plotRouteElevation">Showing Elevation Along Path</a></li>-->
                <li><a href="plotRoutewithWayPoint">Route with Waypoint Google API</a></li>

            </ul>
        </div>
    </div>
</div>

<div id="map"></div>
<div id="right-panel">
    <div>
        <input type="submit" id="submit">
    </div>
    <div id="directions-panel"></div>
</div>
<script>
    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: {lat: 41.85, lng: -87.65}
        });
        directionsDisplay.setMap(map);

        document.getElementById('submit').addEventListener('click', function() {
            calculateAndDisplayRoute(directionsService, directionsDisplay);
        });
    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        //var checkboxArray = document.getElementById('waypoints');
        //for (var i = 0; i < checkboxArray.length; i++) {
           // if (checkboxArray.options[i].selected) {

        <?php
        $count = 0;
        foreach ($data as $key => $value) {
                if (!($count == 0 || $count == count($data))) {
        ?>
                    waypts.push({
                        location: {"lat" : <?php echo $value['end_lat']; ?>,"lng" : <?php echo $value['end_long']; ?>},
                        stopover: true
                    });
        <?php
            }
                $count++;
            }
        ?>
           // }
        //}
        directionsService.route({
            origin: {"lat" : {{$data[0]['end_lat']}},"lng" : {{$data[0]['end_long']}}},
            destination: {"lat" : {{$data[$count-1]['end_lat']}},"lng" : {{$data[$count-1]['end_long']}}},
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];
                var summaryPanel = document.getElementById('directions-panel');
                summaryPanel.innerHTML = '';
                // For each route, display summary information.
                for (var i = 0; i < route.legs.length; i++) {
                    var routeSegment = i + 1;
                    summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                        '</b><br>';
                    summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                    summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                    summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                }
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }

    $(document).ready(function(){
        $("#submit").trigger('click');
    });
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhGPQjX5WJXHMcbQ9FybEDNlnGS8fyvh0&callback=initMap">
</script>
</body>
</html>