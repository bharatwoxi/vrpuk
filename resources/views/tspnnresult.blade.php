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
                <li><a href="tspnnResult">List Form</a></li>
                <li><a href="plotRoute">Plot Route With Animated Symbol</a></li>
                <li><a href="plotRouteElevation">Showing Elevation Along Path</a></li>

            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        &nbsp;
    </div>
</div>

<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <ul class="list-group">
            <?php $total = 0; $i = 0;?>
        @foreach  ($data as $col => $value)
            <li class="list-group-item">
                <ul class="list-group">
                    <li class="list-group-item" style="background-color: #d6e9c6">
                        Path : <?php echo ++$i;?>
                    </li>
                    <li class="list-group-item">
                       Start City :  {{$value['start']}}
                    </li>
                    <li class="list-group-item">
                        End City :  {{$value['end']}}
                    </li>
                    <li class="list-group-item">
                        Cost :  {{$value['cost']}}
                    </li>
                </ul>
            </li>
            <?php $total = $total + $value['cost']; ?>
        @endforeach
            <li class="list-group-item">
                <ul class="list-group">
                    <li class="list-group-item" style="background-color: #2ca02c;color: #FFFFFF">
                        Total Cost :  <?php echo $total; ?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-sm-2"></div>

</div>

</body>
</html>
