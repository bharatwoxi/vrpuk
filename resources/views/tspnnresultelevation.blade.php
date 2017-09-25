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
    <script src="https://www.google.com/jsapi"></script>
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
                <li><a href="plotRoute">Plot Route With Animated Symbol</a></li>
                <li><a href="plotRouteElevation">Showing Elevation Along Path</a></li>

            </ul>
        </div>
    </div>
</div>
<div>
    <div id="map" style="height:400px;"></div>
    <div id="elevation_chart"></div>
    <script>
        // Load the Visualization API and the columnchart package.
        google.load('visualization', '1', {packages: ['columnchart']});

        <?php
            $path = "[";
            $location = "";
            foreach ($data as $key => $value) {
                $location = "{ lat:".$value['end_lat'].", lng:".$value['end_long']."},";
                $path = $path.$location;
            }
            $path = $path."]";
        ?>

        function initMap() {
            // The following path marks a path from Mt. Whitney, the highest point in the
            // continental United States to Badwater, Death Valley, the lowest point.
            var path = <?php echo $path; ?>;  // Badwater, Death Valley

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: path[1],
                mapTypeId: 'terrain'
            });

            // Create an ElevationService.
            var elevator = new google.maps.ElevationService;

            // Draw the path, using the Visualization API and the Elevation service.
            displayPathElevation(path, elevator, map);
        }

        function displayPathElevation(path, elevator, map) {
            // Display a polyline of the elevation path.
            new google.maps.Polyline({
                path: path,
                strokeColor: '#0000CC',
                strokeOpacity: 0.4,
                map: map
            });

            // Create a PathElevationRequest object using this array.
            // Ask for 256 samples along that path.
            // Initiate the path request.
            elevator.getElevationAlongPath({
                'path': path,
                'samples': 256
            }, plotElevation);
        }

        // Takes an array of ElevationResult objects, draws the path on the map
        // and plots the elevation profile on a Visualization API ColumnChart.
        function plotElevation(elevations, status) {
            var chartDiv = document.getElementById('elevation_chart');
            if (status !== 'OK') {
                // Show the error code inside the chartDiv.
                chartDiv.innerHTML = 'Cannot show elevation: request failed because ' +
                    status;
                return;
            }
            // Create a new chart in the elevation_chart DIV.
            var chart = new google.visualization.ColumnChart(chartDiv);

            // Extract the data from which to populate the chart.
            // Because the samples are equidistant, the 'Sample'
            // column here does double duty as distance along the
            // X axis.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Sample');
            data.addColumn('number', 'Elevation');
            for (var i = 0; i < elevations.length; i++) {
                data.addRow(['', elevations[i].elevation]);
            }

            // Draw the chart using the data within its DIV.
            chart.draw(data, {
                height: 150,
                legend: 'none',
                titleY: 'Elevation (m)'
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb69JqE8Dneh4Hb8Gm7ZaccUMNvtcoLzc&callback=initMap">
    </script>
</div>
</body>
</html>