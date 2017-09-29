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

<div class="row" class="text-center" style="background-color: #c1e2b3; padding: 10px;box-shadow: 2px 2px 2px 2px #888888;">
    <div class="col-sm-12" style="font-size:30px;cursor:pointer">
        <a class="btn btn-danger" href="scheduleandroutehomepage"><< Back</a>
        <span >Welcome To POC of Electric Vehicle Routing Problem using TSP</span>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        &nbsp;
    </div>
</div>

<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            Source Details + </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php foreach ($data['source'] as $key1 => $val1 ) {
                                    foreach ($val1 as $key2 => $val2) {
                                        if (!($key2 == "source" || $key2 == "type" || $key2 == "expected_del_time" || $key2 == "parcel_wt" || $key2 == "parcel_unit")) {
                                ?>
                            <li class="list-group-item">
                                <b>{{$key2}}</b> : {{$val2}}
                            </li>
                            <?php
                                     }
                                    }
                                  }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            Vehicle Details : (Total Vehicle : {{count($data['vehicles'])}})</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body" style="height: 400px;overflow-y: scroll;">
                        <ul class="list-group">
                            <?php
                            $countVeh = 1;
                            foreach ($data['vehicles'] as $key1 => $val1 ) {
                                foreach ($val1 as $key2 => $val2) {
                                    if (!($key2 == "vehicle_id")) {
                                        if ($key2 == "vehicle_name") {
                                            ?>
                                            <li class="list-group-item" style="background-color: #337ab7;color: #ffffff">
                                               Vehicle {{$countVeh}} ) <b>{{$key2}}</b> : {{$val2}}
                                            </li>
                                        <?php
                                            $countVeh++;
                                        } else {
                                            ?>
                                            <li class="list-group-item">
                                                <b>{{$key2}}</b> : {{$val2}}
                                            </li>
                                            <?php

                                        }
                                        ?>

                                    <?php
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                            Destination Details : (Total Station : {{count($data['stations'])}})</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body" style="height: 400px;overflow-y: scroll;">
                        <ul class="list-group">
                            <?php
                            $count = 1;
                            foreach ($data['stations'] as $key1 => $val1 ) {
                                foreach ($val1 as $key2 => $val2) {
                                    if (!($key2 == "station_id" || $key2 == "source" || $key2 == "type")) {
                                        if ($key2 == "city_name") {
                                            ?>
                                            <li class="list-group-item" style="background-color: #337ab7;color: #ffffff">
                                                Station {{$count}} )  <b>{{$key2}}</b> : {{$val2}}
                                            </li>
                                        <?php
                                            $count++;
                                        } else {
                                            ?>
                                            <li class="list-group-item">
                                                <b>{{$key2}}</b> : {{$val2}}
                                            </li>
                                        <?php

                                        }
                                        ?>

                                    <?php
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>



</body>
</html>
