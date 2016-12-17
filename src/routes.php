<?php
/*
|--------------------------------------------------------------------------
| Package Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.dfdf
|
*/
Route::get('fb/webhook', 'Denise92\FacebookMessage\FacebookMessageController@webhook');
Route::post('fb/webhook', 'Denise92\FacebookMessage\FacebookMessageController@conversation');
// Route::get('/denise', function(){
//     echo Test::doIt();
// });
