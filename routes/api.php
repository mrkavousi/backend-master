<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*Route::group(['domain' => env('API_SUBDOMAIN') . '.' . env('APP_DOMAIN') . '.' . env('APP_TLD')], function () {*/

    // Version 1
    Route::group(['prefix' => 'v1'], function () {

        // AUTH
        // Register
        Route::post('auth/register', 'Auth\AuthController@register');
        // Login
        Route::post('auth/login', 'Auth\AuthController@login');
        // Refresh
        Route::get('auth/refresh', 'Auth\AuthController@refresh')->middleware('jwt.refresh');
        // -----

        // Processes Export by Slug
        Route::get('/projects/{hashid}/{type}/export', 'Project\ProjectController@adminProcessesExportByType')->name('api.projects.processes.export.by.type');
        // -----

        // AUTHENTICATED
         Route::group(['middleware' => 'jwt.auth'], function() {
            
            // AUTH
            // User
            Route::get('auth/user', 'Auth\AuthController@user');
            // Logout
            Route::post('auth/logout', 'Auth\AuthController@logout');

            // Projects
            // --
            // List
            Route::get('/projects', 'Project\ProjectController@adminList')->name('api.projects');
            // Add
            Route::post('/projects/add', 'Project\ProjectController@adminAdd')->name('api.projects.add');
            // Single
            Route::get('/projects/{hashid}', 'Project\ProjectController@adminSingle')->name('api.projects.single');
            // Processes by Slug
            Route::get('/projects/{hashid}/{type}', 'Project\ProjectController@adminProcessesByType')->name('api.projects.processes.by.type');
            // Update
            Route::put('/projects/{hashid}', 'Project\ProjectController@adminUpdate')->name('api.projects.update');
            // Report Packages Summary
            Route::get('/projects/{hashid}/reports/packages-summary', 'Project\ProjectController@adminReportPackagesSummary')->name('api.admin.projects.reports.packages.summary');
            // -----

            // Processes
            // --
            // List
            Route::get('/processes', 'Process\ProcessController@adminList')->name('api.processes');
            // Add
            Route::post('/processes/add', 'Process\ProcessController@adminAdd')->name('api.processes.add');
            // Single
            Route::get('/processes/{hashid}', 'Process\ProcessController@adminSingle')->name('api.processes.single');
            // Update
            Route::put('/processes/{hashid}', 'processes/addProcess\ProcessController@adminUpdate')->name('api.processes.update');
            // -----

            // Notes
            // --
            // List
            Route::get('/notes', 'Note\NoteController@adminList')->name('api.notes');
            // Add
            Route::post('/notes/add', 'Note\NoteController@adminAdd')->name('api.notes.add');
            // -----

            // Orders
            // --
            // List
            Route::get('/orders', 'Order\OrderController@adminList')->name('api.orders');
            // Add
            Route::post('/orders/add', 'Order\OrderController@adminAdd')->name('api.orders.add');
            // Single
            Route::get('/orders/{hashid}', 'Order\OrderController@adminSingle')->name('api.orders.single');
            // Update
            Route::put('/orders/{hashid}', 'Order\OrderController@adminUpdate')->name('api.orders.update');
            // -----

            // Shipments
            // --
            // List
            Route::get('/shipments', 'Shipment\ShipmentController@adminList')->name('api.shipments');
            // Add
            Route::post('/shipments/add', 'Shipment\ShipmentController@adminAdd')->name('api.shipments.add');
            // Single
            Route::get('/shipments/{hashid}', 'Shipment\ShipmentController@adminSingle')->name('api.shipments.single');
            // Update
            Route::put('/shipments/{hashid}', 'Shipment\ShipmentController@adminUpdate')->name('api.shipments.update');
            // -----

            // Countries
            // --
            // List
            Route::get('/countries', 'Country\CountryController@adminList')->name('api.countries');
            // Add
            Route::post('/countries/add', 'Country\CountryController@adminAdd')->name('api.countries.add');
            // Single
            Route::get('/countries/{hashid}', 'Country\CountryController@adminSingle')->name('api.countries.single');
            // Update
            Route::put('/countries/{hashid}', 'Country\CountryController@adminUpdate')->name('api.countries.update');
            // -----

            // Cities
            // --
            // List
            Route::get('/cities', 'City\CityController@adminList')->name('api.cities');
            // Add
            Route::post('/cities/add', 'City\CityController@adminAdd')->name('api.cities.add');
            // Single
            Route::get('/cities/{hashid}', 'City\CityController@adminSingle')->name('api.cities.single');
            // Update
            Route::put('/cities/{hashid}', 'City\CityController@adminUpdate')->name('api.cities.update');
            // -----

            // Sizes
            // --
            // List
            Route::get('/sizes', 'Size\SizeController@adminList')->name('api.sizes');
            // Add
            Route::post('/sizes/add', 'Size\SizeController@adminAdd')->name('api.sizes.add');
            // Single
            Route::get('/sizes/{hashid}', 'Size\SizeController@adminSingle')->name('api.sizes.single');
            // Update
            Route::put('/sizes/{hashid}', 'Size\SizeController@adminUpdate')->name('api.sizes.update');
            // -----

            // Weights
            // --
            // List
            Route::get('/weights', 'Weight\WeightController@adminList')->name('api.weights');
            // Add
            Route::post('/weights/add', 'Weight\WeightController@adminAdd')->name('api.weights.add');
            // Single
            Route::get('/weights/{hashid}', 'Weight\WeightController@adminSingle')->name('api.weights.single');
            // Update
            Route::put('/weights/{hashid}', 'Weight\WeightController@adminUpdate')->name('api.weights.update');
            // -----

            // Types
            // --
            // List
            Route::get('/types', 'Type\TypeController@adminList')->name('api.types');
            // Add
            Route::post('/types/add', 'Type\TypeController@adminAdd')->name('api.types.add');
            // -----

            // Location
            // --
            // List
            Route::get('/locations', 'Location\LocationController@adminList')->name('api.locations');
            Route::get('/locationsAdmin', 'Location\LocationController@adminListPage')->name('api.locationsAdmin');
            Route::get('/locationsParent', 'Location\LocationController@locationsParent')->name('api.locationsAdmin');
            // Add
            Route::post('/locations/add', 'Location\LocationController@adminAdd')->name('api.locations.add');
            // Single
            Route::get('/locations/{hashid}', 'Location\LocationController@adminSingle')->name('api.locations.single');
            // Update
            Route::put('/locations/{hashid}', 'Location\LocationController@adminUpdate')->name('api.locations.update');
            // Inventory
            Route::get('/locations/{hashid}/inventory', 'Location\StorageController@adminInventory')->name('api.locations.inventory');
            // parentLocation
            Route::get('/locations/parent', 'Location\LocationController@parentLocation')->name('api.locations.parent');
             // -----
             Route::get('/locations/{hashid}/reports/packages-summary', 'Location\LocationController@adminReportPackagesSummary')->name('api.admin.locations.reports.packages.summary');

             Route::get('/locations/{hashid}/{type}', 'Location\LocationController@adminProcessesByType')->name('api.locations.processes.by.type');



             // Aquatics
            // --
            // List
            Route::get('/aquatics', 'Aquatic\AquaticController@adminList')->name('api.aquatics');
            // Add
            Route::post('/aquatics/add', 'Aquatic\AquaticController@adminAdd')->name('api.aquatics.add');
            // Single
            Route::get('/aquatics/{hashid}', 'Aquatic\AquaticController@adminSingle')->name('api.aquatics.single');
            // Update
            Route::put('/aquatics/{hashid}', 'Aquatic\AquaticController@adminUpdate')->name('api.aquatics.update');
            // -----

            // Merchandises
            // --
            // List
            Route::get('/merchandises', 'Merchandise\MerchandiseController@adminList')->name('api.merchandises');
            // Add
            Route::post('/merchandises/add', 'Merchandise\MerchandiseController@adminAdd')->name('api.merchandises.add');
            // Single
            Route::get('/merchandises/{hashid}', 'Merchandise\MerchandiseController@adminSingle')->name('api.merchandises.single');
            // Update
            Route::put('/merchandises/{hashid}', 'Merchandise\MerchandiseController@adminUpdate')->name('api.merchandises.update');
            // -----

            // Vehicle
            // --
            // List
            Route::get('/vehicles', 'Vehicle\VehicleController@adminList')->name('api.vehicles');
            // Add
            Route::post('/vehicles/add', 'Vehicle\VehicleController@adminAdd')->name('api.vehicles.add');
            // Single
            Route::get('/vehicles/{hashid}', 'Vehicle\VehicleController@adminSingle')->name('api.vehicles.single');
            // Update
            Route::put('/vehicles/{hashid}', 'Vehicle\VehicleController@adminUpdate')->name('api.vehicles.update');
            // -----

            // Driver
            // --
            // List
            Route::get('/drivers', 'Driver\DriverController@adminList')->name('api.drivers');
            // Add
            Route::post('/drivers/add', 'Driver\DriverController@adminAdd')->name('api.drivers.add');
            // -----

            // Customer
            // --
            // List
            Route::get('/customers', 'Customer\CustomerController@adminList')->name('api.customers');
            // -----

            // Grade
            // --
            // List
            Route::get('/grades', 'Grade\GradeController@adminList')->name('api.grades');
            // Add
            Route::post('/grades/add', 'Grade\GradeController@adminAdd')->name('api.grades.add');
            // Single
            Route::get('/grades/{hashid}', 'Grade\GradeController@adminSingle')->name('api.grades.single');
            // Update
            Route::put('/grades/{hashid}', 'Grade\GradeController@adminUpdate')->name('api.grades.update');
            // -----

            // Package
            // --
            // List
            Route::get('/packages', 'Package\PackageController@adminList')->name('api.packages');
            // Add
            Route::post('/packages/add', 'Package\PackageController@adminAdd')->name('api.packages.add');
            // Single
            Route::get('/packages/{hashid}', 'Package\PackageController@adminSingle')->name('api.packages.single');
            // Update
            Route::put('/packages/{hashid}', 'Package\PackageController@adminUpdate')->name('api.packages.update');
            // -----

            // --
            // Roles
            // List
            Route::get('/roles', 'Role\RoleController@adminList')->name('api.roles');
            // Add
            Route::post('/roles/add', 'Role\RoleController@store')->name('api.roles.add');
            // Single
             Route::get('/roles/{hashid}', 'Role\RoleController@adminSingle')->name('api.roles.single');
             // Update
             Route::put('/roles/{hashid}', 'Role\RoleController@adminUpdate')->name('api.roles.update');
             // -----
            // --
            // Permissions
            // List
            Route::get('/permissions', 'Permission\PermissionController@adminList')->name('api.permissions');
            // Add
            Route::post('/permissions/add', 'Permission\PermissionController@store')->name('api.permissions.add');
            // -----

            // Attachments
            Route::post('attachments/upload', 'Attachment\AttachmentController@upload');
            // -----

            // Users
            // --
            // List
            Route::get('/users', 'User\UserController@adminList')->name('api.users');
            // Add
            Route::post('/users/add', 'User\UserController@adminAdd')->name('api.users.add');
            // Single
            Route::get('/users/{hashid}', 'User\UserController@adminSingle')->name('api.users.single');
            // Update
            Route::put('/users/{hashid}', 'User\UserController@adminUpdate')->name('api.users.update');
            // -----

         });

    });

/*});*/