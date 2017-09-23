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

    public function plotDataJsonAPI() {
        $status = 200;
        $data = array(
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
        return json_encode($data, $status);
    }
}
