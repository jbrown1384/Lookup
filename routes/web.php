<?php

Route::get('/', 'LookupController@index')->name('index');

Route::get('/customers/{customer}', 'CustomersController@show')->name('show');
