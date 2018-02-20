<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {

});

Route::get('/{view?}', 'LogViewerController@index')->where('view', '(.*)')->name('log-viewer.index');