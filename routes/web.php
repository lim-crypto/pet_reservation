<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('home');
});

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


// pets
Route::get('/pets', 'PetController@index')->name('pets');
Route::get('/pet/{pet}', 'PetController@show')->name('petDetails');
// get pet by type
Route::get('/type/{type}/pets', 'PetController@getByType')->name('petType');
// get pet by breed
Route::get('/breed/{breed}/pets', 'PetController@getByBreed')->name('petBreed');

Route::group(['prefix' => 'services'], function () {
    Route::get('/', 'HomeController@services')->name('services');
    Route::get('/grooming', 'HomeController@grooming')->name('grooming');
    Route::get('/pet-boarding', 'HomeController@petBoarding')->name('petBoarding');
    Route::get('/breeding', 'HomeController@breeding')->name('breeding');
});
Route::get('/about', 'HomeController@about')->name('about');


//////////////////////////////////////////////////////////////////////////////////////////////////////// note: todo:
//////////////////////////////////////////////////////////////////////////////////////////////////////////  create a model migration and controller for services
//////////////////////////////////////////////////////////////////////////////////////////////////////////php artisan make:model -a Model/Service  //  move the controller inside the admin folder
//////////////////////////////////////////////////////////////////////////////////////////////////////////  create services controller for user
////////////////////////////////////////////////////////////////////////////////////////////////////////// php artisan make:controller ServicesController



//admin routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::resource('/pets', 'PetController');
    Route::resource('/breed', 'BreedController');
    Route::resource('/type', 'TypeController');
    Route::get('/reservations', 'ReservationController@index')->name('reservations');
    Route::get('/reservations/{reservation}', 'ReservationController@show')->name('reservation');
    // update reservation status
    Route::put('/reservation/{reservation}', 'ReservationController@update')->name('reservation.status');
    // delete reservation
    Route::delete('/reservation/{reservation}', 'ReservationController@destroy')->name('reservation.destroy');
    //  appointment
    Route::get('/appointments', 'AppointmentController@index')->name('appointments');
    Route::get('/appointment/{id}', 'AppointmentController@show')->name('appointment');
    // update appointment status
    Route::put('/appointment/{id}/status', 'AppointmentController@status')->name('appointment.status');
    // delete appointment
    Route::delete('/appointment/{id}', 'AppointmentController@destroy')->name('appointment.destroy');
});

//user routes
Route::group(['namespace' => 'User', 'middleware' => 'auth'], function () {
    Route::get('/reservations', 'ReservationController@index')->name('user.reservations');
    // Route::get('/reservation/{reservation}', 'ReservationController@show')->name('user.reservation');
    Route::get('/pet/{pet}/reservation', 'ReservationController@create')->name('reservation.create');
    Route::post('/reservation', 'ReservationController@store')->name('reservation.store');
    Route::put('/reservation/{reservation}/cancel', 'ReservationController@cancel')->name('reservation.cancel');
    // Route::delete('/reservation/{reservation}', 'ReservationController@destroy')->name('reservation.destroy');
    // get reservation by status
    Route::get('/reservations/{status}', 'ReservationController@getByStatus')->name('getByStatus');
    Route::put('/reservation/{reservation}', 'ReservationController@update')->name('reservation.update');





    Route::get('/appointments', 'AppointmentController@index')->name('user.appointments');
    Route::get('/appointment/create', 'AppointmentController@create')->name('appointment.create');
    Route::post('/appointment', 'AppointmentController@store')->name('appointment.store');
    Route::put('/appointment/{appointment}/cancel', 'AppointmentController@cancel')->name('appointment.cancel');
    // Route::delete('/appointment/{appointment}', 'AppointmentController@destroy')->name('appointment.destroy');

    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::put('/profile/{slug}', 'UserController@update')->name('profile.update');
});
