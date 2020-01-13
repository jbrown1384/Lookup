<?php

// Retrieves the lookup customer view
Route::get('/', 'CustomersController@index')->name('index');

// Retrieve Customer data
Route::get('/customers/{customer}', 'CustomersController@show')->name('show');
