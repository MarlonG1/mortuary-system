<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth:api'], function () {

});
