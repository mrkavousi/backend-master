<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Hashids;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Location::filter()->latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $locationId = Hashids::connection('general')->decode($hashid);
        $locationId = $locationId[0];
        $location = Location::findOrFail($locationId);

        $location->metadatas = [];
        foreach ($location->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $location->metadatas = array_merge($location->metadatas, [$meta->key => $meta->value]);
        }
        unset($location->metadata);

        foreach ($location->processes as $process) {
            $process->metadatas = [];
            foreach ($process->metadata as $meta) {
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;

                $process->metadatas = array_merge($process->metadatas, [$meta->key => $meta->value]);
            }
            unset($process->metadata);

            $process->driver->metadatas = [];
            foreach ($process->driver->metadata as $meta) {
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;

                $process->driver->metadatas = array_merge($process->driver->metadatas, [$meta->key => $meta->value]);
            }
            unset($process->driver->metadata);

            if ($process->packages) {
                foreach ($process->packages as $package) {
                    if ($package->pivot->unload_id) {
                        $package->unload_process = Process::find($package->pivot->unload_id);
                        $package->unload_process->metadatas = [];
                        foreach ($package->unload_process->metadata as $meta) {
                            if ($meta->value === 'true')
                                $meta->value = true;
                            if ($meta->value === 'false')
                                $meta->value = false;

                            $package->unload_process->metadatas = array_merge($package->unload_process->metadatas, [$meta->key => $meta->value]);
                        }
                        unset($package->unload_process->metadata);
                    }

                    if ($package->pivot->storage_id)
                        $package->storage = Location::find($package->pivot->storage_id);
                }
            }

            if ($process->hasMetadata('size'))
                $process->size = Size::find($process->getMetadata('size'));

            if ($process->hasMetadata('grade'))
                $process->grade = Grade::find($process->getMetadata('grade'));

            if ($process->hasMetadata('send_process')) {
                $process->sending = Process::find($process->getMetadata('send_process'));
                $process->sending->metadatas = [];
                foreach ($process->sending->metadata as $meta) {
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;

                    $process->sending->metadatas = array_merge($process->sending->metadatas, [$meta->key => $meta->value]);
                }
                unset($process->sending->metadata);
            }

            if ($process->hasMetadata('delivery_process')) {
                $process->delivering = Process::find($process->getMetadata('delivery_process'));
                $process->delivering->metadatas = [];
                foreach ($process->delivering->metadata as $meta) {
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;

                    $process->delivering->metadatas = array_merge($process->delivering->metadatas, [$meta->key => $meta->value]);
                }
                unset($process->delivering->metadata);
            }

            if ($process->hasMetadata('unload_process')) {
                $process->unloading = Process::find($process->getMetadata('unload_process'));
                $process->unloading->metadatas = [];
                foreach ($process->unloading->metadata as $meta) {
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;

                    $process->unloading->metadatas = array_merge($process->unloading->metadatas, [$meta->key => $meta->value]);
                }
                unset($process->unloading->metadata);
            }

            if ($process->hasMetadata('frost_process')) {
                $process->frosting = Process::find($process->getMetadata('frost_process'));
                $process->frosting->metadatas = [];
                foreach ($process->frosting->metadata as $meta) {
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;

                    $process->frosting->metadatas = array_merge($process->frosting->metadatas, [$meta->key => $meta->value]);
                }
                unset($process->frosting->metadata);
            }
        }


        return $location;
    }

    public function adminAdd(Request $request)
    {
        $location = new Location;
        $location->type_id = $request->type['id'];
        $location->city_id = $request->city['id'];
        if ($request->parent['id'] > 0)
            $location->parent_id = $request->parent['id'];
        $location->name = $request->name;
        $location->description = $request->description;

        $location->save();

        if ($location->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $location->saveMetadata($key, $value);
            }

            $location->metadatas = [];
            foreach ($location->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $location->metadatas = array_merge($location->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($location->metadata);

            return $location;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $locationId = Hashids::connection('general')->decode($hashid); $locationId = $locationId[0];
        $location = Location::findOrFail($locationId);

        $location->type_id = $request->type['id'];
        $location->city_id = $request->city['id'];
        if ($request->parent['id'] > 0)
            $location->parent_id = $request->parent['id'];
        $location->name = $request->name;
        $location->description = $request->description;

        $location->save();

        if ($location->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $location->saveMetadata($key, $value);
            }

            $location->metadatas = [];
            foreach ($location->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $location->metadatas = array_merge($location->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($location->metadata);

            return $location;

        }
    }

    public function parentLocation($hashid)
    {
        return Location::whereIn('parent_id', null)->get();
    }

    public function adminProcessesByType($hashid, $type)
    {
        $locationId = Hashids::connection('general')->decode($hashid); 
        $locationId = $locationId[0];
        $location = Location::findOrFail($locationId);

        $processes = $location->processes()->where('type_id', $type)->get();
        $processes = collect($processes)->map(function ($process) {
            $process->metadatas = [];
            foreach ($process->metadata as $meta) {

                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;

                $process->metadatas = array_merge($process->metadatas, [$meta->key => $meta->value]);

            }
            unset($process->metadata);
            return $process;
        });

        return $processes;
    }

    public function adminReportPackagesSummary($hashid)
    {
        $locationId = Hashids::connection('general')->decode($hashid);
        $locationId = $locationId[0];
        $location = Location::find($locationId);

        $packagingProcesses = $location->processes()->where('type_id', 35)->get();
        if (!$packagingProcesses->toArray())
            $packagingProcesses = $location->processes()->where('type_id', 7)->get(); // To support previous locations packages summary, we also check for packaging processes

        $processPackagingIds = [];
        foreach ($packagingProcesses as $process) {
            foreach ($process->packages as $package) {
                array_push($processPackagingIds, $package->pivot->id);
            }
        }

        $reports = DB::table('package_model')
            ->select([
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('package_id as package')
            ])
            ->whereIn('id', $processPackagingIds)
            ->where('packageable_type', 'App\Models\Process')
            ->groupBy('package')
            ->get();


        $reports = $reports->map(function ($report) {
            $report->package = Package::find($report->package);
            return $report;
        });

        return $reports;
    }

    public function adminProcessesExportByType($hashid, $type)
    {
        $locationId = Hashids::connection('general')->decode($hashid); $locationId = $locationId[0];
        $location = Location::findOrFail($locationId);

        if ($type == 24)
            return Excel::download(new ProcessTempraturingExport($location, $type), 'tempraturing-' . $hashid . '.xlsx');

        if ($type == 25)
            return Excel::download(new ProcessQualityControllingExport($location, $type), 'quality-controlling-' . $hashid . '.xlsx');
    }
}
