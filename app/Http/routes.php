<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array('uses' =>'DataController@initDataAndWelcome'));
Route::get('plotData', array('uses' =>'DataController@plotData'));

Route::get('plotDataJsonAPI', array('uses' =>'DataController@plotDataJsonAPI'));

Route::get('calculateDistances', array('uses' =>'DataController@calculateDistanceUsingGDMAPI'));

Route::get('tspnnResult', array('uses' =>'DataController@tspnnResult'));
Route::get('plotRoute', array('uses' =>'DataController@plotRoute'));
Route::get('plotRouteElevation', array('uses' =>'DataController@plotRouteElevation'));

Route::get('getDistancesFromLatLong', array('uses' =>'DataController@getDistancesFromLatLong'));
Route::get('plotRoutewithWayPoint', array('uses' =>'DataController@plotRoutewithWayPoint'));







