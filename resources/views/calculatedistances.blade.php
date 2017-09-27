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
        <a class="btn btn-success" href="tspnnResult" style="color: #f5f5f5">Apply TSP : NN Algo - Click Here</a>
    </h2>
</div>

<div class="row" style="margin-right: 0px;text-align: center;">
    <div class="col-sm-12">
        <div class="table-responsive" style="height: 550px;">
            <table class="table-condensed" border="1">
                <tbody>
                <tr>
                    <td>Sr.no</td>
                    <td>#</td>
                @foreach  ($data as $col => $value)
                    <td>{{$col}}</td>
                @endforeach
                </tr>
                <?php $count = 0; ?>

                @foreach ($data as $row=> $dataValue)
                    <tr>
                    <td><?php echo $count++; ?></td>
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

</div>

</body>
</html>
