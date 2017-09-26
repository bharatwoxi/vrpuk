<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DataController extends Controller
{
    public function initDataAndWelcome(){
        $data = null;

        $data['stations'] = $this->inputData();

        $data['vehicles'] = array(
            "nissan" => array(
                "vehicle_name" => "Nissan LEAF 24kWh",
                "starting_point" => "london",
                "stoping_position" => "london",
                "capacity" => 100,
                "load_type" => "parcel",
                "avg_speed_km_per_hr" => 40,
                "cost_per_km_pound" => 1
            ),
            "bmw" => array(
                "vehicle_name" => "i3(60Ah)",
                "starting_point" => "london",
                "stoping_position" => "london",
                "capacity" => 100,
                "load_type" => "parcel",
                "avg_speed_km_per_hr" => 30,
                "cost_per_km_pound" => 1.5
            )
        );

        return view('welcome')->with('data', $data);
    }

    public function plotData() {
        $data = null;
        return view('plotdata')->with('data', $data);
    }

    public function inputData() {
        return array(
            array(
                "city_name" => "Guildford Main Depot",
                "station_name" => "Main Depot",
                "lat" => 51.215485,
                "long" => -0.631027,
                "address" => "Address : Guildford, Surrey, UK",
                "source" => true,
                "type" => "S"
            ),
            array(
                "city_name" => "Guildford Spectrum",
                "station_name" => "Station 1",
                "lat" => 51.254144,
                "long" => -0.562219,
                "address" => "Address : Guildford Spectrum, Parkway, Guildford GU1 1UP, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "University Of Surrey",
                "station_name" => "Station 2",
                "lat" => 51.247913,
                "long" => -0.588998,
                "address" => "Address : 388 Stag Hill, Guildford GU2 7XH, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Stoke Park",
                "station_name" => "Station 3",
                "lat" => 51.244904,
                "long" => -0.569772,
                "address" => "Address : Nightingale Rd, Guildford GU1 1ER, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Farnham Road Car Park",
                "station_name" => "Station 4",
                "lat" => 51.241250,
                "long" =>  -0.579728,
                "address" => "Address : Farnham Rd, Guildford GU2 7NP, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Guildford College",
                "station_name" => "Station 5",
                "lat" => 51.248665,
                "long" =>   -0.570802,
                "address" => "Address : Stoke Rd, Guildford GU1 1EZ, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Loseley Park",
                "station_name" => "Station 6",
                "lat" => 51.215884,
                "long" =>   -0.605861,
                "address" => "Address : Loseley Park, Guildford, GU3 1HS, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Royal Surrey County Hospital",
                "station_name" => "Station 7",
                "lat" => 51.244397,
                "long" => -0.608983,
                "address" => "Address : Egerton Rd, Guildford GU2 7XX, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Surrey & Borders Partnership NHS Trust",
                "station_name" => "Station 8",
                "lat" => 51.243752,
                "long" => -0.550790,
                "address" => "Address : 65 Cranley Rd, Guildford GU1 2JW, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Wood Street Village",
                "station_name" => "Station 9",
                "lat" => 51.254819,
                "long" => -0.625462,
                "address" => "Address : Wood Street Village, Guildford, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Watts Gallery - Artists' Village",
                "station_name" => "Station 10",
                "lat" => 51.224185,
                "long" => -0.629323,
                "address" => "Address : Down Ln, Compton, Guildford GU3 1DQ, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "AirHop",
                "station_name" => "Station 11",
                "lat" => 51.245198,
                "long" => -0.585206,
                "address" => "Address : 12 Midleton Industrial Estate Rd, Guildford GU2 8XW, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "G Live",
                "station_name" => "Station 12",
                "lat" => 51.238401,
                "long" => -0.566194,
                "address" => "London Rd, Guildford GU1 2AA, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Guildford Cricket Club",
                "station_name" => "Station 13",
                "lat" => 51.243103,
                "long" => -0.577418,
                "address" => "The Sports Ground, Woodbridge Rd, Guildford GU1 4RP, UK",
                "source" => false,
                "type" => "D"
            )

        );
        /*return array(
            array(
                "city_name" => "London",
                "station_name" => "Main Depot",
                "lat" => 51.509865,
                "long" => -0.118092,
                "address" => "Address : London, UK",
                "source" => true,
                "type" => "S"
            ),
            array(
                "city_name" => "Elgin",
                "station_name" => "Station 1",
                "lat" => 57.653484,
                "long" => -3.335724,
                "address" => "Address : Elgin, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Birmingham",
                "station_name" => "Station 3",
                "lat" => 53.002666,
                "long" => -2.179404,
                "address" => "Address : Birmingham, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Staffordshire",
                "station_name" => "Station 4",
                "lat" => 52.412811,
                "long" => -1.778197,
                "address" => "Address : Staffordshire, UK",
                "source" => false,
                "type" => "D"
            ),
            array(
                "city_name" => "Cardiff",
                "station_name" => "Station 5",
                "lat" => 51.481583,
                "long" => -3.179090,
                "address" => "Address : Cardiff, UK",
                "source" => false,
                "type" => "D"
            ),
        );*/
    }

    public function getListOfCity(){
        $cityList = [];
        $input = $this->inputData();

        foreach ($input as $key => $val) {
            array_push($cityList, $val['city_name']);
        }
        return $cityList;
    }

    public function plotDataJsonAPI() {
        $status = 200;
        $data = $this->inputData();
        return json_encode($data, $status);
    }

    public function calculateDistanceUsingGDMAPI() {
        $data = null;
        $data = $this->createAdjMatrix();
        return view('calculatedistances')->with('data', $data);
    }

    public function tspnnResult() {
        $data = null;
        $adj_matrix = $this->createAdjMatrix();
        //TSP : NN Algo Here

        $data = $this->tspnnWithoutDestinationAsHub($adj_matrix);
        return view('tspnnresult')->with('data', $data);
    }

    public function plotRoute() {
        $data = null;
        $adj_matrix = $this->createAdjMatrix();
        //TSP : NN Algo Here

        $data = $this->tspnnWithoutDestinationAsHub($adj_matrix);
        return view('plotroute')->with('data', $data);
    }

    public function plotRoutewithWayPoint() {
        $data = null;
        $adj_matrix = $this->createAdjMatrix();
        //TSP : NN Algo Here

        $data = $this->tspnnWithoutDestinationAsHub($adj_matrix);
        return view('plotwaypoints')->with('data', $data);
    }

    public function plotRouteElevation() {
        $data = null;
        $adj_matrix = $this->createAdjMatrix();
        //TSP : NN Algo Here

        $data = $this->tspnnWithoutDestinationAsHub($adj_matrix);
        return view('tspnnresultelevation')->with('data', $data);
    }


    public function tspnnWithoutDestinationAsHub($adj_matrix) {
        $listOfStation = $this->getListOfCity();
        $source = $listOfStation[0];
        $destination = $listOfStation[0];
        $path[] = array(
            "start" => $source,
            "start_lat" => $this->getStationLat($source),
            "start_long" => $this->getStationLong($source),
            "end" => $source,
            "end_lat" => $this->getStationLat($source),
            "end_long" => $this->getStationLong($source),
            "cost" => 0
        );
        $traveller = $source;
        while (count($path) != count($listOfStation)) {
            $cost = null;
            $traveller_path = $adj_matrix[$traveller];
            //echo "Source : ".$traveller;
            foreach ($traveller_path as $city => $tp_cost) {
                if( ($city != $traveller) && (!in_array($city, array_column($path, 'end'))) ){
                    if ($cost == null) {
                        $start = $traveller;
                        $cost = $tp_cost;
                        $end = $city;
                    } elseif ( $cost > $tp_cost) {
                        $start = $traveller;
                        $cost = $tp_cost;
                        $end = $city;
                    }
                }
            }
            $path[] = array(
                "start" => $start,
                "start_lat" => $this->getStationLat($start),
                "start_long" => $this->getStationLong($start),
                "end" => $end,
                "end_lat" => $this->getStationLat($end),
                "end_long" => $this->getStationLong($end),
                "cost" => $cost
            );

            $traveller = $end;
        }

        $path[] = array(
            "start" => $traveller,
            "start_lat" => $this->getStationLat($traveller),
            "start_long" => $this->getStationLong($traveller),
            "end" => $destination,
            "end_lat" => $this->getStationLat($destination),
            "end_long" => $this->getStationLong($destination),
            "cost" => $adj_matrix[$traveller][$destination]
        );

        return $path;
    }
    public function tspnnWithDestinationAsHub($adj_matrix) {
        $listOfStation = $this->getListOfCity();
        $source = $listOfStation[0];
        $destination = $listOfStation[0];
        $path[] = array(
            "start" => $source,
            "end" => $source,
            "cost" => 0
        );
        $traveller = $source;
        while (count($path) != count($listOfStation)) {
            $cost = null;
            $traveller_path = $adj_matrix[$traveller];
            //echo "Source : ".$traveller;
            foreach ($traveller_path as $city => $tp_cost) {
                if( ($city != $traveller) && (!in_array($city, array_column($path, 'end'))) ){
                    if ($cost == null) {
                        $start = $traveller;
                        $cost = $tp_cost;
                        $end = $city;
                    } elseif ( $cost > $tp_cost) {
                        $start = $traveller;
                        $cost = $tp_cost;
                        $end = $city;
                    }
                }
            }
            $path[] = array(
                "start" => $start,
                "end" => $end,
                "cost" => $cost
            );

            $traveller = $end;
        }

        $path[] = array(
            "start" => $traveller,
            "start_lat" => $this->getStationLat($traveller),
            "start_long" => $this->getStationLong($traveller),
            "end" => $destination,
            "end_lat" => $this->getStationLat($destination),
            "end_long" => $this->getStationLong($destination),
            "cost" => $adj_matrix[$traveller][$destination]
        );
        return $path;
    }

    public function getStationLat($city){
        $inputData = $this->inputData();
        foreach ($inputData as $data) {
            if ($city == $data['city_name']) {
                return $data['lat'];
            }
        }
        return null;
    }

    public function getStationLong($city){
        $inputData = $this->inputData();
        foreach ($inputData as $data) {
            if ($city == $data['city_name']) {
                return $data['long'];
            }
        }
        return null;
    }

    public function getdistance($Url) {

            $output = null;

            // is cURL installed yet?
            if (!function_exists('curl_init')){
                die('Sorry cURL is not installed!');
            }

            // OK cool - then let's create a new cURL resource handle
            $ch = curl_init();

            // Now set some options (most are optional)

            // Set URL to download
            curl_setopt($ch, CURLOPT_URL, $Url);

            // Set a referer
            //curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");

            // User agent
            //curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

            // Include header in result? (0 = yes, 1 = no)
            //curl_setopt($ch, CURLOPT_HEADER, 0);

            // Should cURL return or print out the data? (true = return, false = print)
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Timeout in seconds
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            // Download the given URL, and return output
            $output = curl_exec($ch);

            // Close the cURL resource, and free system resources
            curl_close($ch);
            $result = null;
            $distance = null;
            $result = json_decode($output, true); // convert it from JSON to php array
            if ($result['status'] != 'OVER_QUERY_LIMIT') {
                $distance = $result['rows'][0]['elements'][0]['distance']['value']/1000;
            }
            return $distance;
    }

    public function createAdjMatrix() {
        $dataCity = $this->inputData();
        $cityList = [];
        $cityLat = [];
        $cityLong = [];
        foreach ($dataCity as $city) {
            array_push($cityList, $city['city_name']);
            array_push($cityLat, $city['lat']);
            array_push($cityLong, $city['long']);
        }

        /* This is where will save the adj. matrix */
        $adj_matrix = array();

        /* Reset the matrix to all '0's */
        foreach($cityList as $row){
            foreach($cityList as $col){
                $adj_matrix[$row][$col] = 0;
            }
        }

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metrix";
        $key = "&key=AIzaSyC4fAyRCp1XMnlL5vJvA0kOjTGoZLnScY0";

        $i = 0;
        foreach($cityList as $row) {
            $j = 0;
            foreach($cityList as $col) {
                $distance = null;
                if ($row == $col) {
                    $adj_matrix[$row][$col] = 0;
                } else {
                    $sourceLat = $cityLat[$i];
                    $sourceLong = $cityLong[$i];
                    $destLat = $cityLat[$j];
                    $destLong = $cityLong[$j];
                    $origin = "&origins=".$sourceLat.",".$sourceLong;
                    $dest = "&destinations=".$destLat.",".$destLong;
                    $urlNew = null;
                    $urlNew = $url.$origin.$dest.$key;
                    //$distance = $this->getdistance($urlNew);
                    $distance = $this->distance($sourceLat,$sourceLong,$destLat,$destLong,'M');
                    $adj_matrix[$row][$col] = $distance;
                }
                $j++;
            }
            $i++;
        }

        return $adj_matrix;

    }

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::                                                                         :*/
    /*::  This routine calculates the distance between two points (given the     :*/
    /*::  latitude/longitude of those points). It is being used to calculate     :*/
    /*::  the distance between two locations using GeoDataSource(TM) Products    :*/
    /*::                                                                         :*/
    /*::  Definitions:                                                           :*/
    /*::    South latitudes are negative, east longitudes are positive           :*/
    /*::                                                                         :*/
    /*::  Passed to function:                                                    :*/
    /*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
    /*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
    /*::    unit = the unit you desire for results                               :*/
    /*::           where: 'M' is statute miles (default)                         :*/
    /*::                  'K' is kilometers                                      :*/
    /*::                  'N' is nautical miles                                  :*/
    /*::  Worldwide cities and other features databases with latitude longitude  :*/
    /*::  are available at http://www.geodatasource.com                          :*/
    /*::                                                                         :*/
    /*::  For enquiries, please contact sales@geodatasource.com                  :*/
    /*::                                                                         :*/
    /*::  Official Web site: http://www.geodatasource.com                        :*/
    /*::                                                                         :*/
    /*::         GeoDataSource.com (C) All Rights Reserved 2017		   		     :*/
    /*::                                                                         :*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function getDistancesFromLatLong () {
        //echo $this->distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
        echo $this->distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kms<br>";
        //echo $this->distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
        echo $this->distanceGeoPoints(32.9697, -96.80322, 29.46786, -98.53506)/1000 . " Kms<br>";
        echo $this->distanceCalculation(32.9697, -96.80322, 29.46786, -98.53506) . " Kms<br>";
    }

    function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
        // Calculate the distance in degrees
        $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));

        // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
        switch($unit) {
            case 'km':
                $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
                break;
            case 'mi':
                $distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
                break;
            case 'nmi':
                $distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
        }
        return round($distance, $decimals);
    }

    function distanceGeoPoints ($lat1, $lng1, $lat2, $lng2) {

        $earthRadius = 3958.75;

        $dLat = deg2rad($lat2-$lat1);
        $dLng = deg2rad($lng2-$lng1);


        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $dist = $earthRadius * $c;

        // from miles
        $meterConversion = 1609;
        $geopointDistance = $dist * $meterConversion;

        return $geopointDistance;
    }




}
