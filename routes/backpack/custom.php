<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    Route::group([
        'prefix' => 'api',
        'namespace'  => 'Api',
    ], function () {
        //API Routes
//        Route::get('municipios', 'MunicipioController@index');
    });

    Route::group([
        'prefix' => 'fetch',
        'namespace'  => 'Fetch',
    ], function () {
        //API Routes
        Route::post('municipios', 'FetchsController@fetchMunicipio');
    });



    Route::crud('codigo', 'CodigoCrudController');
    Route::crud('codigo-item', 'CodigoItemCrudController');
    Route::crud('estado', 'EstadoCrudController');
    Route::crud('municipio', 'MunicipioCrudController');
    Route::crud('unidade', 'UnidadeCrudController');
    Route::crud('nsu', 'NsuCrudController');
    Route::crud('fornecedor', 'FornecedorCrudController');
    Route::crud('nfe', 'NfeCrudController');
    Route::crud('nfe-item', 'NfeItemCrudController');
}); // this should be the absolute last line of this file