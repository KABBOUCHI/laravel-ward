<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('/logs', 'Api\LogsController@index');
    Route::get('/logs/{log}', 'Api\LogsController@show');
    Route::delete('/logs', 'Api\LogsController@delete');
    Route::get('/daily-log-files', 'Api\LogsController@dailyLogFiles');
});

Route::get('/{view?}', 'WardController@index')->where('view', '(.*)')->name('ward.index');
