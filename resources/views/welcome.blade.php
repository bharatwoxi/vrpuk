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
    </head>
    <body>
        <div class="text-center" style="background-color: #c2c2c2; padding: 10px;">
            <h2>Welcome To POC of TSP : NN - For Vehicle Routing Problem
                <button type="button" class="btn btn-success">
                    <a href="plotData" style="color: #f5f5f5">Plot the Data - Click Here</a>
                </button>
            </h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4" >
                    <h3>Station Data</h3>
                    <div style="height: 400px; overflow-y: scroll; margin-top: 5%; background-color: #f2f2f2; padding: 10px;">
                    @foreach ($data['stations'] as $station => $details)
                        <p>Station Details : {{ucfirst($station)}}</p>
                        <ul class="list-group">
                            @foreach ($details as $key => $value)
                                @if ($key == "source" && $value == true)
                                    <li class="list-group-item" style="background-color: #ff6666;">Station : This is the Source : Depot</li>
                                @elseif ($key == "source" && $value == false)
                                    <li class="list-group-item" style="background-color: #c1e2b3;">Station : This is the Destination</li>
                                @else
                                    <li class="list-group-item">{{ucfirst($key)}} : {{ucfirst($value)}}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endforeach
                    </div>
                </div>
                <div class="col-sm-4">
                    <h3>Vehicle Data</h3>
                    <div style="height: 400px; overflow-y: scroll; margin-top: 5%; background-color: #f2f2f2; padding: 10px;">
                        @foreach ($data['vehicles'] as $vehicle => $details)
                        <p>Vehicle Details : {{ucfirst($vehicle)}}</p>
                        <ul class="list-group">
                            @foreach ($details as $key => $value)
                                <li class="list-group-item">{{ucfirst($key)}} : {{ucfirst($value)}}</li>
                            @endforeach
                        </ul>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-4" >
                    <h3>Station List</h3>
                    <div style="height: 400px; overflow-y: scroll; margin-top: 5%; background-color: #f2f2f2; padding: 10px;">
                        @foreach ($data['stations'] as $station => $details)
                        <ul class="list-group">
                            <li class="list-group-item">{{ucfirst($details['city_name'])}}</li>
                        </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
