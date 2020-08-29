<?php

namespace App\Http\Controllers\Process;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Process;
use Hashids;
use App\Models\Project;
use Auth;
use App\Models\Merchandise;
use Cache;

class ProcessController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        $processes = Process::latest()->paginate(50);
        foreach ($processes as $process) {
            $processModel = $process->processable_type;
            $process->processable = $processModel::find($process->processable_id);
        }
        return $processes;
    }

    public function adminSingle(Request $request, $hashid)
    {
        $processId = Hashids::connection('general')->decode($hashid); $processId = $processId[0];
        $process = Process::findOrFail($processId);

        if ($process && $request->has('model') && $request->has('processable')) {
            $processableId = Hashids::connection('general')->decode($request->processable['hashid']); $processableId = $processableId[0];
            if ($request->has('model') == 'project')
                $processable = Project::findOrFail($processableId);
            if ($request->has('model') == 'merchandise')
                $processable = Merchandise::findOrFail($processableId);
            if ($request->has('model') == 'location')
                $processable = Location::findOrFail($processableId);
        }

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
    }

    public function adminAdd(Request $request)
    {
        if ($request->has('model') && $request->has('processable')) {
            $processableId = Hashids::connection('general')->decode($request->processable);
            $processableId = $processableId[0];
            if ($request->model == 'project')
                $processable = Project::findOrFail($processableId);
            if ($request->model == 'merchandise')
                $processable = Merchandise::findOrFail($processableId);
            if ($request->model == 'location')
                $processable = Location::findOrFail($processableId);
        }

        if ($processable) {

            $process = new Process;

            $process->user_id = Auth::user()->id;
            $process->type_id = $request->type['id'];
            $process->processable_id = $processable->id;
            $process->processable_type = 'App\Models\\' . ucfirst($request->model);
    
            if ($request->has('from') && $request->from['id'])
                $process->from_id = $request->from['id'];
    
            if ($request->has('to') && $request->to['id'])
                $process->to_id = $request->to['id'];
    
            if ($request->has('vehicle') && $request->vehicle['id'])
                $process->vehicle_id = $request->vehicle['id'];

            if ($request->has('driver') && $request->driver['id'])
                $process->driver_id = $request->driver['id'];
    
            if ($request->has('location') && $request->location['id'])
                $process->location_id = $request->location['id'];
    
            $process->status = $request->status;
    
            $process->save();
    
            if ($process->id) {
    
                // Add Metadata
                foreach ($request->metadatas as $key => $value) {
                    if (!is_null($value))
                        $process->saveMetadata($key, $value);
                }
    
                $process->metadatas = [];
                foreach ($process->metadata as $meta) {
        
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;
        
                    $process->metadatas = array_merge($process->metadatas, [$meta->key => $meta->value]);
                    
                }
                unset($process->metadata);

                if ($request->has('packages')) {
                    $packages = [];
                    foreach ($request->packages as $package) {
                        if ($package['id'] > 0 && $package['pivot']['quantity'] > 0) {
                            $packaged = [
                                'packageable_type' => 'App\Models\Process',
                                'quantity' => $package['pivot']['quantity'],
                                'floor' => $package['pivot']['floor'],
                                'unload_id' => $package['pivot']['unload_id'],
                                'storage_id' => $package['pivot']['storage_id']
                            ];
                            $process->packages()->attach($package['id'], $packaged);
                        }
                    }
                }
                if ($request->model == 'project') {
                    Cache::forget('projects');
                    Cache::forget('project' . $request->processable);
                }
                if ($request->model == 'location'){
                    Cache::forget('locations');
                    Cache::forget('location' . $request->processable);

                }
                return $process;
    
            }

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $processId = Hashids::connection('general')->decode($hashid); $processId = $processId[0];
        $process = Process::findOrFail($processId);

        if ($process && $request->has('model') && $request->has('processable')) {
            $processableId = Hashids::connection('general')->decode($request->processable); $processableId = $processableId[0];
            if ($request->model == 'project')
                $processable = Project::findOrFail($processableId);
            if ($request->model == 'merchandise')
                $processable = Merchandise::findOrFail($processableId);
        }
        
        if ($processable) {

            // $process->user_id = Auth::user()->id;
            $process->type_id = $request->type['id'];
            // $process->processable_id = $processable->id;
            // $process->processable_type = 'App\Models\\' . ucfirst($request->model);

            if ($request->has('from') && $request->from['id'])
                $process->from_id = $request->from['id'];

            if ($request->has('to') && $request->to['id'])
                $process->to_id = $request->to['id'];

            if ($request->has('vehicle') && $request->vehicle['id'])
                $process->vehicle_id = $request->vehicle['id'];

            if ($request->has('driver') && $request->driver['id'])
                $process->driver_id = $request->driver['id'];

            if ($request->has('location') && $request->location['id'])
                $process->location_id = $request->location['id'];

            $process->status = $request->status;

            $process->save();

            if ($process->id) {
        
                // Add Metadata
                foreach ($request->metadatas as $key => $value) {
                    if ($value)
                        $process->saveMetadata($key, $value);
                }

                $process->metadatas = [];
                foreach ($process->metadata as $meta) {
        
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;
        
                    $process->metadatas = array_merge($process->metadatas, [$meta->key => $meta->value]);
                    
                }
                unset($process->metadata);

                if ($request->has('packages')) {
                    $packages = [];
                    $process->packages()->detach();
                    foreach ($request->packages as $package) {
                        if ($package['id'] > 0 && $package['pivot']['quantity'] > 0) {
                            $packaged = [
                                'packageable_type' => 'App\Models\Process',
                                'quantity' => $package['pivot']['quantity'],
                                'floor' => $package['pivot']['floor'],
                                'unload_id' => $package['pivot']['unload_id'],
                                'storage_id' => $package['pivot']['storage_id']
                            ];
                            $process->packages()->attach($package['id'], $packaged);
                        }
                    }
                }

                Cache::forget('projects');
                Cache::forget('project' . $request->processable);

                Cache::forget('locations');
                Cache::forget('location' . $request->processable);

                return $process;

            }
        
        }
    }
}
