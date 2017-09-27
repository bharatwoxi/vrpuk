<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MasterController extends Controller
{
    public function scheduleandroutemainpage() {
        $data = null;
        $data['vehicles'] = $this->getVehicleInputData();
        $data['stations'] = $this->getStationInputData();

        return view('master.homepage')->with('data', $data);
    }

    public function plotDataJsonAPINew() {
        $status = 200;
        $data = $this->getStationInputData();
        return json_encode($data, $status);
    }

    public function getVehicleInputData() {
        return array(
            array(
                "vehicle_id" => 1,
                "vehicle_name" => "Tesla Model S 60kWh",
                "capacity" => 100,
                "capacity_unit" => "kg",
                "load_type" => "parcel",
                "init_battery_charge_per" => 100,
                "mileage" => 100,
                "battery_capacity" => 60,
                "battery_capacity_unit" => "kWh"
            ),
            array(
                "vehicle_id" => 2,
                "vehicle_name" => "Tesla Model S 80kWh",
                "capacity" => 100,
                "capacity_unit" => "kg",
                "load_type" => "parcel",
                "init_battery_charge_per" => 100,
                "mileage" => 200,
                "battery_capacity" => 80,
                "battery_capacity_unit" => "kWh"
            ),
            array(
                "vehicle_id" => 3,
                "vehicle_name" => "Tesla Model S 100kWh",
                "capacity" => 100,
                "capacity_unit" => "kg",
                "load_type" => "parcel",
                "init_battery_charge_per" => 100,
                "mileage" => 300,
                "battery_capacity" => 100,
                "battery_capacity_unit" => "kWh"
            )
        );
    }

    public function getEVChargingStationInputData() {
        return array(
            array(
                "charging_st_id" => 93337,
                "charging_st_name" => "Pierhead Car Park",
                "lat" => 55.002267,
                "long" => -1.419571,
                "address" => "Address : Pierhead Car Park, South Shields, NE33 2LD UK",
                "type" => "C",
            ),
            array(
                "charging_st_id" => 93335,
                "charging_st_name" => "Spindlewood",
                "lat" => 51.295484,
                "long" => -1.062915,
                "address" => "Address : Stag Oak Lane, Daneshill, Basingstoke , RG24 8NN UK",
                "type" => "C",
            ),
            array(
                "charging_st_id" => 93330,
                "charging_st_name" => "Scarles Yard",
                "lat" => 52.621162,
                "long" => 1.295693,
                "address" => "Address : Kings Lane, Norwich, NR1 3PN UK",
                "type" => "C",
            )
        );
    }

    public function getStationInputData(){
        return array(
            array(
                "city_name" => "Guildford Main Depot",
                "station_name" => "Main Depot",
                "lat" => 51.215485,
                "long" => -0.631027,
                "address" => "Address : Guildford, Surrey, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-01 10:00:00",
            ),
            array(
                "city_name" => "Guildford Spectrum",
                "station_name" => "Station 1",
                "lat" => 51.254144,
                "long" => -0.562219,
                "address" => "Address : Guildford Spectrum, Parkway, Guildford GU1 1UP, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-01 18:00:00",
            ),
            array(
                "city_name" => "University Of Surrey",
                "station_name" => "Station 2",
                "lat" => 51.247913,
                "long" => -0.588998,
                "address" => "Address : 388 Stag Hill, Guildford GU2 7XH, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-03 23:00:00",
            ),
            array(
                "city_name" => "Stoke Park",
                "station_name" => "Station 3",
                "lat" => 51.244904,
                "long" => -0.569772,
                "address" => "Address : Nightingale Rd, Guildford GU1 1ER, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-02 23:00:00",
            ),
            array(
                "city_name" => "Farnham Road Car Park",
                "station_name" => "Station 4",
                "lat" => 51.241250,
                "long" =>  -0.579728,
                "address" => "Address : Farnham Rd, Guildford GU2 7NP, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-04 23:00:00",
            ),
            array(
                "city_name" => "Guildford College",
                "station_name" => "Station 5",
                "lat" => 51.248665,
                "long" =>   -0.570802,
                "address" => "Address : Stoke Rd, Guildford GU1 1EZ, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-07 11:00:00",
            ),
            array(
                "city_name" => "Loseley Park",
                "station_name" => "Station 6",
                "lat" => 51.215884,
                "long" =>   -0.605861,
                "address" => "Address : Loseley Park, Guildford, GU3 1HS, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-06 11:00:00",
            ),
            array(
                "city_name" => "Royal Surrey County Hospital",
                "station_name" => "Station 7",
                "lat" => 51.244397,
                "long" => -0.608983,
                "address" => "Address : Egerton Rd, Guildford GU2 7XX, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-12 11:00:00",
            ),
            array(
                "city_name" => "Surrey NHS Trust",
                "station_name" => "Station 8",
                "lat" => 51.243752,
                "long" => -0.550790,
                "address" => "Address : 65 Cranley Rd, Guildford GU1 2JW, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-09 11:00:00",
            ),
            array(
                "city_name" => "Wood Street Village",
                "station_name" => "Station 9",
                "lat" => 51.254819,
                "long" => -0.625462,
                "address" => "Address : Wood Street Village, Guildford, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-11 11:00:00",
            ),
            array(
                "city_name" => "Watts Gallery - Artists' Village",
                "station_name" => "Station 10",
                "lat" => 51.224185,
                "long" => -0.629323,
                "address" => "Address : Down Ln, Compton, Guildford GU3 1DQ, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-12 11:00:00",
            ),
            array(
                "city_name" => "AirHop",
                "station_name" => "Station 11",
                "lat" => 51.245198,
                "long" => -0.585206,
                "address" => "Address : 12 Midleton Industrial Estate Rd, Guildford GU2 8XW, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-14 11:00:00",
            ),
            array(
                "city_name" => "G Live",
                "station_name" => "Station 12",
                "lat" => 51.238401,
                "long" => -0.566194,
                "address" => "London Rd, Guildford GU1 2AA, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-05 10:00:00",
            ),
            array(
                "city_name" => "Guildford Cricket Club",
                "station_name" => "Station 13",
                "lat" => 51.243103,
                "long" => -0.577418,
                "address" => "The Sports Ground, Woodbridge Rd, Guildford GU1 4RP, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-08 10:00:00",
            )
        );
    }
}
