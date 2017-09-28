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
        $data['source'] = $this->getSourceStation();
        return view('master.homepage')->with('data', $data);
    }

    public function plotScheduleAndRoute($vehicle) {
        $data = null;
        $scheduleData = null;
        $scheduleDataWithAdjMat = array();
        $scheduleData = $this->scheduleVehicleLogic();
        $sourceData = $this->getSourceStation();
        foreach ($scheduleData as $key => $delMainData) {
            if ($key == "scheduleDelData") {
                foreach ($delMainData as $veh_id => $delData) {
                    $listCity = array();
                    $listCity[] = $sourceData[0]['city_name'];
                    foreach ($delData as $key => $value) {
                            $listCity[] = $value['city_name'];
                    }
                    $scheduleDataWithAdjMat[$veh_id] = $this->tspnnWithoutDestinationAsHub($this->createAdjMatrix($delData, $sourceData), $listCity);
                }
            }
        }

        $data['vehicle_info'] = $this->getVehicleInfo($vehicle);
        $data['vehicles'] = $this->getVehicleInputData();
        $data['route'] = $scheduleDataWithAdjMat[$vehicle];
        return view('master.scheduleandroute')->with('data', $data);
    }

    public function tspnnWithoutDestinationAsHub($adj_matrix, $listCity) {
        $sourceData = $this->getSourceStation();
        $listOfStation = $listCity;
        $source = $listOfStation[0];
        $destination = $listOfStation[0];
        $path[] = array(
            "start" => $sourceData[0]['city_name'],
            "start_lat" => $sourceData[0]['lat'],
            "start_long" => $sourceData[0]['long'],
            "end" => $source,
            "end_lat" => $sourceData[0]['lat'],
            "end_long" => $sourceData[0]['long'],
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
/*
        $path[] = array(
            "start" => $traveller,
            "start_lat" => $this->getStationLat($traveller),
            "start_long" => $this->getStationLong($traveller),
            "end" => $destination,
            "end_lat" => $this->getStationLat($destination),
            "end_long" => $this->getStationLong($destination),
            "cost" => $adj_matrix[$traveller][$destination]
        );*/

        return $path;
    }

    public function getStationLat($city){
        $inputData = $this->getStationInputData();
        foreach ($inputData as $data) {
            if ($city == $data['city_name']) {
                return $data['lat'];
            }
        }
        return null;
    }

    public function getStationLong($city){
        $inputData = $this->getStationInputData();
        foreach ($inputData as $data) {
            if ($city == $data['city_name']) {
                return $data['long'];
            }
        }
        return null;
    }

    public function plotDataJsonAPINew() {
        $status = 200;
        $dataInput = $this->getStationInputData();
        $dataSource = $this->getSourceStation();
        $dataCs = $this->getEVChargingStationInputData();
        $dataStandSource = array_merge($dataInput,$dataSource);
        $data = array_merge($dataCs, $dataStandSource);
        return json_encode($data, $status);
    }

    public function createAdjMatrix($delStationData, $sourceData) {

        $dataCity = $delStationData;
        $cityList = [];
        $cityLat = [];
        $cityLong = [];
        foreach ($sourceData as $key => $value) {
            array_push($cityList, $value['city_name']);
            array_push($cityLat, $value['lat']);
            array_push($cityLong, $value['long']);
        }

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

    public function scheduleVehicleLogic() {
        $data = null;
        $source = null;
        $end = null;
        $scheduleData = null;
        $vehicles = $this->getVehicleInputData();
        $stations = $this->getStationInputData();

        $scheduleData = $this->scheduleAlgorithm($vehicles,$stations,$source,$end);
        return $scheduleData;

    }

    public function scheduleAlgorithm($vehicles, $stations, $source, $end) {

        // Demand based sorting
        $EDDarray = array();
        foreach ($stations as $key => $row) {
            array_push($EDDarray, strtotime($row['expected_del_time']));
        }
        array_multisort($EDDarray, SORT_ASC, $stations);

        $scheduleData = array();
        $remaningParcelList = array();
        $newptr = 0;
        foreach ($vehicles as $veh => $veh_value) {
            $curr_cap = 0;
            $ptr = $newptr;
            $capacity = $veh_value['capacity'];
            for ($i = $ptr; $i < count($stations) ; $i++) {
                $rem = $capacity - $curr_cap;
                if ($rem > $stations[$i]['parcel_wt']) {
                    $curr_cap = $curr_cap + $stations[$i]['parcel_wt'];
                    $scheduleData[$veh_value['vehicle_id']][] = $stations[$i];
                    $newptr++;
                }
            }
        }
        for ($j = $newptr; $j < count($stations) ; $j++){
            $remaningParcelList[] = $stations[$j];
        }
        $data['scheduleDelData'] = $scheduleData;
        $data['remainingParcelData'] = $remaningParcelList;
        return $data;
    }

    public function getVehicleInfo($veh_id) {
        $vehiclesData = $this->getVehicleInputData();
        foreach ($vehiclesData as $key => $vehicle) {
            if ($vehicle['vehicle_id'] == $veh_id) {
                return $vehicle;
            }
        }
        return null;

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
                "capacity" => 200,
                "capacity_unit" => "kg",
                "load_type" => "parcel",
                "init_battery_charge_per" => 100,
                "mileage" => 50,
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
                "city_name" => 93337,
                "station_name" => "Charging Station : Pierhead Car Park",
                "lat" => 51.255185,
                "long" => -0.601027,
                "address" => "Address : Pierhead Car Park, South Shields, NE33 2LD UK",
                "type" => "C",
                "source" => false
            ),
            array(
                "city_name" => 93335,
                "station_name" => "Charging Station : Spindlewood",
                "lat" => 51.245185,
                "long" => -0.601027,
                "address" => "Address : Stag Oak Lane, Daneshill, Basingstoke , RG24 8NN UK",
                "type" => "C",
                "source" => false
            ),
            array(
                "city_name" => 93330,
                "station_name" => "Charging Station : Scarles Yard",
                "lat" => 51.225185,
                "long" =>  -0.700027,
                "address" => "Address : Kings Lane, Norwich, NR1 3PN UK",
                "type" => "C",
                "source" => false
            )
        );
    }

    public function getSourceStation() {
        return array(
            array(
            "city_name" => "Guildford Main Depot",
            "station_name" => "Main Depot",
            "lat" => 51.215485,
            "long" => -0.631027,
            "address" => "Address : Guildford, Surrey, UK",
            "source" => true,
            "type" => "S",
            "expected_del_time" => "2017-11-01 10:00:00",
            "parcel_wt" => 5,
            "parcel_unit" => "kg"
          )
        );
    }
    public function getStationInputData(){
        return array(
            array(
                "city_name" => "Guildford Spectrum",
                "station_name" => "Station 1",
                "lat" => 51.254144,
                "long" => -0.562219,
                "address" => "Address : Guildford Spectrum, Parkway, Guildford GU1 1UP, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-01 18:00:00",
                "parcel_wt" => 10,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 10,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 17,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 10,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 20,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 12,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 15,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 15,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 12,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 10,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 12,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 10,
                "parcel_unit" => "kg"
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
                "parcel_wt" => 10,
                "parcel_unit" => "kg"
            ),
            array(
                "city_name" => "142 ALDERSHOT ROAD ",
                "station_name" => "Station 14",
                "lat" => 51.25098234065978,
                "long" => -0.598535536296832,
                "address" => "ALDERSHOT ROAD, 142, Guildford GU2 8BHP, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-22 10:00:00",
                "parcel_wt" => 10,
                "parcel_unit" => "kg"
            ),
            array(
                "city_name" => "54 LIDDINGTON NEW ROAD",
                "station_name" => "Station 15",
                "lat" => 51.25764179310098,
                "long" => -0.6072470712324886,
                "address" => "LIDDINGTON NEW ROAD, 54, Guildford GU3 3AH, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-09 10:00:00",
                "parcel_wt" => 27,
                "parcel_unit" => "kg"
            ),
            array(
                "city_name" => "94 LIDDINGTON NEW ROAD",
                "station_name" => "Station 16",
                "lat" => 51.25853686530565,
                "long" => -0.6228556487851122,
                "address" => "94, ENVIS WAY, Guildford GU3 3NJ, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-09 10:00:00",
                "parcel_wt" => 35,
                "parcel_unit" => "kg"
            ),
            array(
                "city_name" => "39 EPSOM ROAD",
                "station_name" => "Station 17",
                "lat" => 51.23768794190298,
                "long" => -0.5641153686479249,
                "address" => "94, EPSOM ROAD, Guildford GU1 3LA, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-09 10:00:00",
                "parcel_wt" => 35,
                "parcel_unit" => "kg"
            ),
            array(
                "city_name" => "4 REDWING RISE",
                "station_name" => "Station 18",
                "lat" => 51.250067343704224,
                "long" => -0.5276639731156682,
                "address" => "4, REDWING RISE, Guildford GU4 7DU, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-09 10:00:00",
                "parcel_wt" => 35,
                "parcel_unit" => "kg"
            ),
            array(
                "city_name" => "13 ORCHARD ROAD",
                "station_name" => "Station 19",
                "lat" => 51.25979555959067,
                "long" => -0.5419001577182438,
                "address" => "13, ORCHARD ROAD, Guildford GU4 7JH, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-09 10:00:00",
                "parcel_wt" => 35,
                "parcel_unit" => "kg"
            ),
            array(
                "city_name" => "16 THE MOUNT",
                "station_name" => "Station 20",
                "lat" => 51.23449983482633,
                "long" => -0.5791975565240368,
                "address" => "16, THE MOUNT, Guildford GU2 4HN, UK",
                "source" => false,
                "type" => "D",
                "expected_del_time" => "2017-11-09 10:00:00",
                "parcel_wt" => 35,
                "parcel_unit" => "kg"
            )
        );
    }
}
