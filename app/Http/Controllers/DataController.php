<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DataController extends Controller
{
    public function initDataAndWelcome(){
        $data = null;

        $data['stations'] = array(
            "london" => array(
                "station_name" => "Main Depot",
                "lat" => 51.509865,
                "long" => -0.118092,
                "address" => "Depot Detail address : London, UK",
                "source" => true
            ),
            "elgin" => array(
                "station_name" => "Station 1",
                "lat" => 57.653484,
                "long" => -3.335724,
                "address" => "Station 1 Detail address : Elgin, UK",
                "source" => false
            ),
            "birmingham" => array(
                "station_name" => "Station 3",
                "lat" => 53.002666,
                "long" => -2.179404,
                "address" => "Station 3 Detail address : Birmingham, UK",
                "source" => false
            ),
            "staffordshire" => array(
                "station_name" => "Station 4",
                "lat" => 52.412811,
                "long" => -1.778197,
                "address" => "Station 4 Detail address : Staffordshire, UK",
                "source" => false
            ),
            "cardiff" => array(
                "station_name" => "Station 5",
                "lat" => 51.481583,
                "long" => -3.179090,
                "address" => "Station 5 Detail address : Cardiff, UK",
                "source" => false
            ),
        );

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
        );
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
        $key = "&key=AIzaSyD-9jnTkbI1w2MOdWfwfd9riEGOHiorIEc";

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
                    $distance = $this->getdistance($urlNew);
                    $adj_matrix[$row][$col] = $distance;
                }
                $j++;
            }
            $i++;
        }

        return $adj_matrix;

    }
}
