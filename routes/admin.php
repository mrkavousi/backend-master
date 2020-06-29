<?php

// Admin Panel
Route::group(['middleware' => ['locale'], 'domain' => env('ADMIN_SUBDOMAIN') . '.' . env('APP_DOMAIN') . '.' . env('APP_TLD')], function () {

    Route::get('/login', 'Admin\AdminController@index')->name('admin.login');

    Route::get('/', 'Admin\AdminController@index')->name('admin.home');

    // Projects
    Route::group(['prefix' => 'projects'], function () {
        Route::any('{all?}', 'Project\ProjectController@adminIndex')->where('all', '.*')->name('admin.projects');
    });
    // --------------------

    // Processes
    Route::group(['prefix' => 'processes'], function () {
        Route::any('{all?}', 'Process\ProcessController@adminIndex')->where('all', '.*')->name('admin.processes');
    });
    // --------------------

    // Locations
    Route::group(['prefix' => 'locations'], function () {
        Route::any('{all?}', 'Location\LocationController@adminIndex')->where('all', '.*')->name('admin.locations');
    });
    // --------------------

    // Countries
    Route::group(['prefix' => 'countries'], function () {
        Route::any('{all?}', 'Country\CountryController@adminIndex')->where('all', '.*')->name('admin.countries');
    });
    // --------------------

    // Cities
    Route::group(['prefix' => 'cities'], function () {
        Route::any('{all?}', 'City\CityController@adminIndex')->where('all', '.*')->name('admin.cities');
    });
    // --------------------

    // Sizes
    Route::group(['prefix' => 'sizes'], function () {
        Route::any('{all?}', 'Size\SizeController@adminIndex')->where('all', '.*')->name('admin.sizes');
    });
    // --------------------

    // Weights
    Route::group(['prefix' => 'weights'], function () {
        Route::any('{all?}', 'Weight\WeightController@adminIndex')->where('all', '.*')->name('admin.weights');
    });
    // --------------------

    // Aquatics
    Route::group(['prefix' => 'aquatics'], function () {
        Route::any('{all?}', 'Aquatic\AquaticController@adminIndex')->where('all', '.*')->name('admin.aquatics');
    });
    // --------------------

    // Merchandises
    Route::group(['prefix' => 'merchandises'], function () {
        Route::any('{all?}', 'Merchandise\MerchandiseController@adminIndex')->where('all', '.*')->name('admin.merchandises');
    });
    // --------------------

    // Packages
    Route::group(['prefix' => 'packages'], function () {
        Route::any('{all?}', 'Package\PackageController@adminIndex')->where('all', '.*')->name('admin.packages');
    });
    // --------------------

    // Vehicles
    Route::group(['prefix' => 'vehicles'], function () {
        Route::any('{all?}', 'Vehicle\VehicleController@adminIndex')->where('all', '.*')->name('admin.vehicles');
    });
    // --------------------

    // Grades
    Route::group(['prefix' => 'grades'], function () {
        Route::any('{all?}', 'Grade\GradeController@adminIndex')->where('all', '.*')->name('admin.grades');
    });
    // --------------------

    // Orders
    Route::group(['prefix' => 'orders'], function () {
        Route::any('{all?}', 'Order\OrderController@adminIndex')->where('all', '.*')->name('admin.orders');
    });
    // --------------------

    // Users
    Route::group(['prefix' => 'users'], function () {
        Route::any('{all?}', 'User\UserController@adminIndex')->where('all', '.*')->name('admin.users');
    });
    // --------------------

});
