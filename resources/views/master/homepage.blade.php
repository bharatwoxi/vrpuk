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



    <!-- Include the plugin's CSS and JS: -->
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>


    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #main {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }


        /* The side navigation menu */
        .sidenav {
            height: 100%; /* 100% Full-height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            z-index: 1; /* Stay on top */
            top: 0;
            left: 0;
            background-color: #f5f5f5; /* Black*/
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 60px; /* Place content 60px from the top */
            transition: 0.3s; /* 0.5 second transition effect to slide in the sidenav */
            box-shadow: 0px 10px 5px #888888;
        }

        /* The navigation menu links */
        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            color: #818181;
            display: block;
            transition: 0.3s
        }

        .row {
            margin-right: 0px;
        }

        /* Position and style the close button (top right corner) */
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
        #main {
            transition: margin-left .3s;
            padding: 20px;
        }

        /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }

        #example-optionClass-container .multiselect-container li.odd {
            background: #eeeeee;
        }
        #example-optionClass-container1 .multiselect-container1 li.odd {
            background: #eeeeee;
        }

        #snackbar {
            visibility: visible;
            min-width: 200px;
            margin-left: -10px;
            background-color: #333;
            color: #fff;
            text-align: left;
            border-radius: 2px;
            padding: 5px;
            position: fixed;
            z-index: 1;
            left: 80%;
            bottom: 30px;
            font-size: 13px;
            opacity: 0.6;
            font-weight: bolder;
        }

        #snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
            opacity: 0.8;
        }

        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }

    </style>
</head>
<body>
    <div class="row" style="background-color: #c1e2b3; padding: 10px;box-shadow: 5px 10px 10px 10px #888888;">
        <div class="col-md-12" >
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Welcome To POC of Electric Vehicle Routing Problem using TSP</span>
            <a class="btn btn-info" href="inputDataAll" style="float:right;color: #f5f5f5;" target="_self">
                View Data Set >>
            </a>
        </div>
    </div>


    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">DEMO &nbsp;&nbsp;&nbsp; &times;</a>
        <ul class="list-group">
            <li class="list-group-item">
                <label>Please Select the Vehicle</label>
                <div id="example-optionClass-container">
                    <select id="example-optionClass" multiple="multiple">
                        <div style="height: 400px; overflow-y: scroll; margin-top: 5%; background-color: #f2f2f2; padding: 10px;">
                            @foreach ($data['vehicles'] as $vehicle => $details)
                                <option value="{{ucfirst($details['vehicle_id'])}}">{{ucfirst($details['vehicle_name'])}}</option>
                            @endforeach
                        </div>
                    </select>
                </div>
            </li>
            <li class="list-group-item">
                <label>Source Station : </label>
                <select id="source">
                    <?php foreach($data['source'] as $key => $value) {
                    ?>
                                <option value="#">{{$value['station_name']}} : {{$value['city_name']}}</option>
                    <?php
                          }
                    ?>
                </select>
            </li>
            <li class="list-group-item">
                <label>Please Select Delivery Station : </label>
                <form class="form-horizontal" name="temp1" action="scheduleandroutehomepagepost" method="POST" onsubmit="return validateDestination()">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <select id="example-post" name="multiselect[]" multiple="multiple">
                                <div style="height: 400px; overflow-y: scroll; margin-top: 5%; background-color: #f2f2f2; padding: 10px;">
                                    @foreach ($data['stations'] as $vehicle => $details)
                                    <option value="{{ucfirst($details['station_id'])}}">{{ucfirst($details['city_name'])}}</option>
                                    @endforeach
                                </div>
                            </select>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </form>
            </li>
            <?php if ($data['selectDest'] != "all") { ?>
            <li class="list-group-item">
                <a class="btn btn-danger" href="plotScheduleAndRoute/1/{{$data['selectDest']}}" style="color: #f5f5f5">
                    Start Schedule & Route >>
                </a>
            </li>
            <?php } ?>
        </ul>
        <input type="hidden" id="destOpt" value="{{$data['selectDest']}}">
    </div>

    <div id="snackbar">
        <ul>
            <li>CS - Charging Station</li>
            <li>S - Source</li>
            <li>D - Destination</li>
        </ul>
    </div>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="main"></div>

    <script type="text/javascript">
        var selectArray = [];
         $(document).ready(function() {
            $('#example-post').multiselect({
                includeSelectAllOption: true,
                onChange: function(element, checked) {
                    if (checked === true) {
                        //action taken here if true
                        selectArray.push(element.val())
                    }
                    else if (checked === false) {
                        var tempArr = [];
                        for (i = 0; i< selectArray.length; i++) {
                            if (selectArray[i] != element.val()) {
                                tempArr.push(selectArray[i])
                            }
                            selectArray = tempArr;
                        }
                    }

                }
            });
        });
        /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "300px";
            document.getElementById("main").style.marginLeft = "300px";
        }

        /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }

        function myFunction() {
            var x = document.getElementById("snackbar")
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }

        $(document).ready(function() {
            $('#example-optionClass').multiselect({
                includeSelectAllOption: true,
                optionClass: function(element) {
                    var value = $(element).val();

                    if (value%2 == 0) {
                        return 'even';
                    }
                    else {
                        return 'odd';
                    }
                }
            });

            $('#example-optionClass1').multiselect({
                includeSelectAllOption: true,
                optionClass: function(element) {
                    var value = $(element).val();

                    if (value%2 == 0) {
                        return 'even';
                    }
                    else {
                        return 'odd';
                    }
                }
            });
        });

         function validateDestination() {
             var selArr = selectArray;
             if (selArr.length > 0) {
                 return true;
             } else {
                 alert("Please select atleast one destination.");
                 return false;
             }
         }

    var customLabel = {
        S: {
            label: 'S'
        },
        D: {
            label: 'D'
        },
        C: {
            label : 'CS'
        }
    };

    function initMap() {
        var map = new google.maps.Map(document.getElementById('main'), {
            center: new google.maps.LatLng(51.215485, -0.631027),
            zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;
        var optionVal = $("#destOpt").val();
        var ajaxUrl = "http://localhost/vrpuk/public/plotDataJsonAPINew/"+optionVal;

        // Change this depending on the name of your PHP or XML file
        downloadUrl(ajaxUrl, function(data) {
            var jsonObj = JSON.parse(data.responseText);
            if (jsonObj.length != 0) {
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
            }
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
