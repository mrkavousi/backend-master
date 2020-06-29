<?php

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PROCESS

        // Project Processes

        // Sending
        $sendingSlug = 'sending';
        $sending = Type::where('slug', $sendingSlug)->first();
        if (!$sending) {
            $sending = new Type();
            $sending->id = 1;
            $sending->typeable_type = 'App\Models\Process';
            $sending->name = 'Sending';
            $sending->slug = $sendingSlug;
            $sending->description = null;
            $sending->save();
            $sending->models()->create([
                'type_id' => $sending->id,
                'model' => 'App\Models\Project'
            ]);
        }
        
        // Delivering
        $deliveringSlug = 'delivering';
        $delivering = Type::where('slug', $deliveringSlug)->first();
        if (!$delivering) {
            $delivering = new Type();
            $delivering->id = 2;
            $delivering->typeable_type = 'App\Models\Process';
            $delivering->name = 'Delivering';
            $delivering->slug = $deliveringSlug;
            $delivering->description = null;
            $delivering->save();
            $delivering->models()->create([
                'type_id' => $delivering->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Unloading
        $unloadingSlug = 'unloading';
        $unloading = Type::where('slug', $unloadingSlug)->first();
        if (!$unloading) {
            $unloading = new Type();
            $unloading->id = 3;
            $unloading->typeable_type = 'App\Models\Process';
            $unloading->name = 'Unloading';
            $unloading->slug = $unloadingSlug;
            $unloading->description = null;
            $unloading->save();
            $unloading->models()->create([
                'type_id' => $unloading->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Weighting
        $weightingSlug = 'weighting';
        $weighting = Type::where('slug', $weightingSlug)->first();
        if (!$weighting) {
            $weighting = new Type();
            $weighting->id = 4;
            $weighting->typeable_type = 'App\Models\Process';
            $weighting->name = 'Weighting';
            $weighting->slug = $weightingSlug;
            $weighting->description = null;
            $weighting->save();
            $weighting->models()->create([
                'type_id' => $weighting->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Sorting
        $sortingSlug = 'sorting';
        $sorting = Type::where('slug', $sortingSlug)->first();
        if (!$sorting) {
            $sorting = new Type();
            $sorting->id = 5;
            $sorting->typeable_type = 'App\Models\Process';
            $sorting->name = 'Sorting';
            $sorting->slug = $sortingSlug;
            $sorting->description = null;
            $sorting->save();
            $sorting->models()->create([
                'type_id' => $sorting->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Defrosting
        $defrostingSlug = 'defrosting';
        $defrosting = Type::where('slug', $defrostingSlug)->first();
        if (!$defrosting) {
            $defrosting = new Type();
            $defrosting->id = 6;
            $defrosting->typeable_type = 'App\Models\Process';
            $defrosting->name = 'Defrosting';
            $defrosting->slug = $defrostingSlug;
            $defrosting->description = null;
            $defrosting->save();
            $defrosting->models()->create([
                'type_id' => $defrosting->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Packaging
        // $packagingSlug = 'packaging';
        // $packaging = Type::where('slug', $packagingSlug)->first();
        // if (!$packaging) {
        //     $packaging = new Type();
        //     $packaging->id = 7;
        //     $packaging->typeable_type = 'App\Models\Process';
        //     $packaging->name = 'Packaging';
        //     $packaging->slug = $packagingSlug;
        //     $packaging->description = null;
        //     $packaging->save();
        //     $packaging->models()->create([
        //         'type_id' => $packaging->id,
        //         'model' => 'App\Models\Project'
        //     ]);
        // }

        // Storaging
        // $storagingSlug = 'storaging';
        // $storaging = Type::where('slug', $storagingSlug)->first();
        // if (!$storaging) {
        //     $storaging = new Type();
        //     $storaging->id = 8;
        //     $storaging->typeable_type = 'App\Models\Process';
        //     $storaging->name = 'Storaging';
        //     $storaging->slug = $storagingSlug;
        //     $storaging->description = null;
        //     $storaging->save();
        //     $storaging->models()->create([
        //         'type_id' => $storaging->id,
        //         'model' => 'App\Models\Project'
        //     ]);
        // }

        // Merchandise Processes

        // Entering
        $enteringSlug = 'entering';
        $entering = Type::where('slug', $enteringSlug)->first();
        if (!$entering) {
            $entering = new Type();
            $entering->id = 9;
            $entering->typeable_type = 'App\Models\Process';
            $entering->name = 'Entering';
            $entering->slug = $enteringSlug;
            $entering->description = null;
            $entering->save();
            $entering->models()->create([
                'type_id' => $entering->id,
                'model' => 'App\Models\Merchandise'
            ]);
        }

        // Exiting
        $exitingSlug = 'exiting';
        $exiting = Type::where('slug', $exitingSlug)->first();
        if (!$exiting) {
            $exiting = new Type();
            $exiting->id = 10;
            $exiting->typeable_type = 'App\Models\Process';
            $exiting->name = 'Exiting';
            $exiting->slug = $exitingSlug;
            $exiting->description = null;
            $exiting->save();
            $exiting->models()->create([
                'type_id' => $exiting->id,
                'model' => 'App\Models\Merchandise'
            ]);
        }


        // LOCATION

        // Office
        $officeSlug = 'office';
        $office = Type::where('slug', $officeSlug)->first();
        if (!$office) {
            $office = new Type();
            $office->id = 11;
            $office->typeable_type = 'App\Models\Location';
            $office->name = 'Office';
            $office->slug = $officeSlug;
            $office->description = null;
            $office->save();
        }

        // Storage
        $storageSlug = 'storage';
        $storage = Type::where('slug', $storageSlug)->first();
        if (!$storage) {
            $storage = new Type();
            $storage->id = 12;
            $storage->typeable_type = 'App\Models\Location';
            $storage->name = 'Storage';
            $storage->slug = $storageSlug;
            $storage->description = null;
            $storage->save();
        }

        // Farm
        $farmSlug = 'farm';
        $farm = Type::where('slug', $farmSlug)->first();
        if (!$farm) {
            $farm = new Type();
            $farm->id = 13;
            $farm->typeable_type = 'App\Models\Location';
            $farm->name = 'Farm';
            $farm->slug = $farmSlug;
            $farm->description = null;
            $farm->save();
        }

        // Store
        $storeSlug = 'store';
        $store = Type::where('slug', $storeSlug)->first();
        if (!$store) {
            $store = new Type();
            $store->id = 14;
            $store->typeable_type = 'App\Models\Location';
            $store->name = 'Store';
            $store->slug = $storeSlug;
            $store->description = null;
            $store->save();
        }

        // Factory
        $factorySlug = 'factory';
        $factory = Type::where('slug', $factorySlug)->first();
        if (!$factory) {
            $factory = new Type();
            $factory->id = 15;
            $factory->typeable_type = 'App\Models\Location';
            $factory->name = 'Factory';
            $factory->slug = $factorySlug;
            $factory->description = null;
            $factory->save();
        }


        // VEHICLE

        // Truck
        $truckSlug = 'truck';
        $truck = Type::where('slug', $truckSlug)->first();
        if (!$truck) {
            $truck = new Type();
            $truck->id = 16;
            $truck->typeable_type = 'App\Models\Vehicle';
            $truck->name = 'Truck';
            $truck->slug = $truckSlug;
            $truck->description = null;
            $truck->save();
        }

        // Van
        $vanSlug = 'van';
        $van = Type::where('slug', $vanSlug)->first();
        if (!$van) {
            $van = new Type();
            $van->id = 17;
            $van->typeable_type = 'App\Models\Vehicle';
            $van->name = 'Van';
            $van->slug = $vanSlug;
            $van->description = null;
            $van->save();
        }


        // MERCHANDISE

        // Production
        $productionSlug = 'production';
        $production = Type::where('slug', $productionSlug)->first();
        if (!$production) {
            $production = new Type();
            $van->id = 18;
            $production->typeable_type = 'App\Models\Merchandise';
            $production->name = 'Production';
            $production->slug = $productionSlug;
            $production->description = null;
            $production->save();
        }

        // Processing
        $processingSlug = 'processing';
        $processing = Type::where('slug', $processingSlug)->first();
        if (!$processing) {
            $processing = new Type();
            $processing->id = 19;
            $processing->typeable_type = 'App\Models\Merchandise';
            $processing->name = 'Processing';
            $processing->slug = $processingSlug;
            $processing->description = null;
            $processing->save();
        }

        // Personnel
        $personnelSlug = 'personnel';
        $personnel = Type::where('slug', $personnelSlug)->first();
        if (!$personnel) {
            $personnel = new Type();
            $personnel->id = 20;
            $personnel->typeable_type = 'App\Models\Merchandise';
            $personnel->name = 'Personnel';
            $personnel->slug = $personnelSlug;
            $personnel->description = null;
            $personnel->save();
        }

        // Technical
        $technicalSlug = 'technical';
        $technical = Type::where('slug', $technicalSlug)->first();
        if (!$technical) {
            $technical = new Type();
            $technical->id = 21;
            $technical->typeable_type = 'App\Models\Merchandise';
            $technical->name = 'Technical';
            $technical->slug = $technicalSlug;
            $technical->description = null;
            $technical->save();
        }

        // Maintenance
        $maintenanceSlug = 'maintenance';
        $maintenance = Type::where('slug', $maintenanceSlug)->first();
        if (!$maintenance) {
            $maintenance = new Type();
            $maintenance->id = 22;
            $maintenance->typeable_type = 'App\Models\Merchandise';
            $maintenance->name = 'Maintenance';
            $maintenance->slug = $maintenanceSlug;
            $maintenance->description = null;
            $maintenance->save();
        }


        // PROCESS

        // Project Processes

        // Staff Censusing
        $staffCensusingSlug = 'staff-censusing';
        $staffCensusing = Type::where('slug', $staffCensusingSlug)->first();
        if (!$staffCensusing) {
            $staffCensusing = new Type();
            $staffCensusing->id = 23;
            $staffCensusing->typeable_type = 'App\Models\Process';
            $staffCensusing->name = 'Staff Censusing';
            $staffCensusing->slug = $staffCensusingSlug;
            $staffCensusing->description = null;
            $staffCensusing->save();
            $staffCensusing->models()->create([
                'type_id' => $staffCensusing->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Temperaturing
        $temperaturingSlug = 'temperaturing';
        $temperaturing = Type::where('slug', $temperaturingSlug)->first();
        if (!$temperaturing) {
            $temperaturing = new Type();
            $temperaturing->id = 24;
            $temperaturing->typeable_type = 'App\Models\Process';
            $temperaturing->name = 'Temperaturing';
            $temperaturing->slug = $temperaturingSlug;
            $temperaturing->description = null;
            $temperaturing->save();
            $temperaturing->models()->create([
                'type_id' => $temperaturing->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Quality Controlling
        $qualityControllingSlug = 'quality-controlling';
        $qualityControlling = Type::where('slug', $qualityControllingSlug)->first();
        if (!$qualityControlling) {
            $qualityControlling = new Type();
            $qualityControlling->id = 25;
            $qualityControlling->typeable_type = 'App\Models\Process';
            $qualityControlling->name = 'Quality Controlling';
            $qualityControlling->slug = $qualityControllingSlug;
            $qualityControlling->description = null;
            $qualityControlling->save();
            $qualityControlling->models()->create([
                'type_id' => $qualityControlling->id,
                'model' => 'App\Models\Project'
            ]);
        }


        // LOCATION

        // Load
        $loadSlug = 'load';
        $load = Type::where('slug', $loadSlug)->first();
        if (!$load) {
            $load = new Type();
            $load->id = 26;
            $load->typeable_type = 'App\Models\Location';
            $load->name = 'Loading';
            $load->slug = $loadSlug;
            $load->description = null;
            $load->save();
        }

        // Tunnel
        $tunnelSlug = 'tunnel';
        $tunnel = Type::where('slug', $tunnelSlug)->first();
        if (!$tunnel) {
            $tunnel = new Type();
            $tunnel->id = 27;
            $tunnel->typeable_type = 'App\Models\Location';
            $tunnel->name = 'Tunnel';
            $tunnel->slug = $tunnelSlug;
            $tunnel->description = null;
            $tunnel->save();
        }

        // Saloon
        $SaloonSlug = 'saloon';
        $saloon = Type::where('slug', $SaloonSlug)->first();
        if (!$saloon) {
            $saloon = new Type();
            $saloon->id = 28;
            $saloon->typeable_type = 'App\Models\Location';
            $saloon->name = 'Saloon';
            $saloon->slug = $SaloonSlug;
            $saloon->description = null;
            $saloon->save();
        }


        // PROCESS

        // Project Processes

        // Done Project
        // $doneSlug = 'done';
        // $done = Type::where('slug', $doneSlug)->first();
        // if (!$done) {
        //     $done = new Type();
        //     $done->id = 29;
        //     $done->typeable_type = 'App\Models\Process';
        //     $done->name = 'Done';
        //     $done->slug = $doneSlug;
        //     $done->description = null;
        //     $done->save();
        //     $done->models()->create([
        //         'type_id' => $done->id,
        //         'model' => 'App\Models\Project'
        //     ]);
        // }


        // VEHICLE

        // Trolley
        $trolleySlug = 'trolley';
        $trolley = Type::where('slug', $trolleySlug)->first();
        if (!$trolley) {
            $trolley = new Type();
            $trolley->id = 30;
            $trolley->typeable_type = 'App\Models\Vehicle';
            $trolley->name = 'Trolley';
            $trolley->slug = $trolleySlug;
            $trolley->description = null;
            $trolley->save();
        }


        // PROCESS

        // Project Processes

        // Stop Project
        // $stopSlug = 'stop';
        // $stop = Type::where('slug', $stopSlug)->first();
        // if (!$stop) {
        //     $stop = new Type();
        //     $stop->id = 31;
        //     $stop->typeable_type = 'App\Models\Process';
        //     $stop->name = 'Stop';
        //     $stop->slug = $stopSlug;
        //     $stop->description = null;
        //     $stop->save();
        //     $stop->models()->create([
        //         'type_id' => $stop->id,
        //         'model' => 'App\Models\Project'
        //     ]);
        // }

        // Note
        $noteSlug = 'note';
        $note = Type::where('slug', $noteSlug)->first();
        if (!$note) {
            $note = new Type();
            $note->id = 32;
            $note->typeable_type = 'App\Models\Process';
            $note->name = 'Note';
            $note->slug = $noteSlug;
            $note->description = null;
            $note->save();
            $note->models()->create([
                'type_id' => $note->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Frosting
        $frostingSlug = 'frosting';
        $frosting = Type::where('slug', $frostingSlug)->first();
        if (!$frosting) {
            $frosting = new Type();
            $frosting->id = 33;
            $frosting->typeable_type = 'App\Models\Process';
            $frosting->name = 'Frosting';
            $frosting->slug = $frostingSlug;
            $frosting->description = null;
            $frosting->save();
            $frosting->models()->create([
                'type_id' => $frosting->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // Before Frosting
        $beforeFrostingSlug = 'packaging-before-frosting';
        $beforeFrosting = Type::where('slug', $beforeFrostingSlug)->first();
        if (!$beforeFrosting) {
            $beforeFrosting = new Type();
            $beforeFrosting->id = 34;
            $beforeFrosting->typeable_type = 'App\Models\Process';
            $beforeFrosting->name = 'Packaging Before Frosting';
            $beforeFrosting->slug = $beforeFrostingSlug;
            $beforeFrosting->description = null;
            $beforeFrosting->save();
            $beforeFrosting->models()->create([
                'type_id' => $beforeFrosting->id,
                'model' => 'App\Models\Project'
            ]);
        }

        // After Frosting
        $afterFrostingSlug = 'packaging-after-frosting';
        $afterFrosting = Type::where('slug', $afterFrostingSlug)->first();
        if (!$afterFrosting) {
            $afterFrosting = new Type();
            $afterFrosting->id = 35;
            $afterFrosting->typeable_type = 'App\Models\Process';
            $afterFrosting->name = 'Packaging After Frosting';
            $afterFrosting->slug = $afterFrostingSlug;
            $afterFrosting->description = null;
            $afterFrosting->save();
            $afterFrosting->models()->create([
                'type_id' => $afterFrosting->id,
                'model' => 'App\Models\Project'
            ]);
        }

    }
}
