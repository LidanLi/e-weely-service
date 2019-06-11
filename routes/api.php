<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/trips/{trip}/download', 'Api\DownloadTripPackageController')->middleware('auth:api');

Route::get('/user/{name}', function($name){
    $list = array();
    $users = \App\User::where('name', $name)->get();

    foreach ($users as $user) {
        $trips = \App\Trip::where('created_by_id', $user->id)->get();
        foreach ($trips as $trip) {
            $single_trip = array('trip_name' => $trip->name, 'trip_id'=> $trip-> id);
            array_push($list, $single_trip);
        }
    }

    return json_encode($list);

});

Route::get('/trips/{secret}', function($secret){
    $list = array();

    $trips = \App\Trip::where('secretkey', $secret)->get();
    foreach($trips as $trip){
        $single_trip = array('trip_name' => $trip->name, 'trip_id' => $trip->id);
        array_push($list, $single_trip);
    }

    return json_encode($list);

});


Route::get('/events/{event}/participants/available', function (\App\Event $event) {
    return $event->available_participants;
});

Route::get('/events/{event}/contacts/available', function (\App\Event $event) {
    return $event->available_contacts;
});

Route::get('/events/{event}/documents/available', function (\App\Event $event) {
    return $event->available_documents;
});

Route::get('/events/{event}/documents/current', function (\App\Event $event) {
    return $event->current_documents;
});

Route::get('/events/{event}/documents/updated/{ids}', function (\App\Event $event, $ids) {
    
    $list = explode(',', $ids);
    $event->documents()->toggle($list);

    return $event->documents()->toggle($list);
});

Route::get('/user', function() {
    return \App\Trip::with('days', 'days.events', 'days.events.documents', 'days.events.people', 'articles', 'people')->first();
});


Route::get('/lang/trans.js', function () {

    $trans_file = File::get(base_path('resources/lang/fr.json'));

    $json = json_decode($trans_file);

    $output = [
        'fr' => $json
    ];

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($output) . ';');
    exit();
    // return response()->json(json_decode($file));
});