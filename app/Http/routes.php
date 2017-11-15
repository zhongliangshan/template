<?php
Route::auth();

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['namespace' => 'crm'], function () {
    Route::get('/', 'CrmController@index');
});

Route::group(['prefix' => 'crm', 'namespace' => 'crm'], function () {
    Route::any('/my_create', 'CrmController@myCreate');
    Route::any('/create_crm', 'CrmController@createCrm');
    Route::any('/upload', 'CrmController@upload');
});
