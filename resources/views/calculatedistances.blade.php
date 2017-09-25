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
            <a href="tspnnResult" style="color: #f5f5f5">Apply TSP : NN Algo - Click Here</a>
        </button>
    </h2>
</div>

<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <td>#</td>
                @foreach  ($data as $col => $value)
                    <td>{{$col}}</td>
                @endforeach
                </tr>

                @foreach ($data as $row=> $dataValue)
                    <tr>
                    <td>{{$row}}</td>
                    @foreach ($dataValue as $key => $cost )
                    <td>{{$cost}}</td>
                    @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-1"></div>

</div>

</body>
</html>
