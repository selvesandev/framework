<?php
Route::get('home','DemoController@index');
Route::get('about/{a}/{b}','DemoController@about');
Route::get('admin','AdminController@test','Admin');

Route::get('contact','ContactController@save');
Route::post('contact','ContactController@save');



