<?php

namespace App\Http\Controllers\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Hashids;

class VehicleController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Vehicle::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $vehicleId = Hashids::connection('general')->decode($hashid); $vehicleId = $vehicleId[0];
        $vehicle = Vehicle::findOrFail($vehicleId);

        $vehicle->metadatas = [];
        foreach ($vehicle->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $vehicle->metadatas = array_merge($vehicle->metadatas, [$meta->key => $meta->value]);
        }
        unset($vehicle->metadata);

        return $vehicle;
    }

    public function adminAdd(Request $request)
    {
        $vehicle = new Vehicle;
        $vehicle->type_id = $request->type['id'];
        $vehicle->driver_id = $request->driver['id'];
        $vehicle->name = $request->name;
        $vehicle->description = $request->description;

        $vehicle->save();

        if ($vehicle->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $vehicle->saveMetadata($key, $value);
            }

            $vehicle->metadatas = [];
            foreach ($vehicle->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $vehicle->metadatas = array_merge($vehicle->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($vehicle->metadata);

            return $vehicle;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $vehicleId = Hashids::connection('general')->decode($hashid); $vehicleId = $vehicleId[0];
        $vehicle = Vehicle::findOrFail($vehicleId);

        $vehicle->type_id = $request->type['id'];
        $vehicle->driver_id = $request->driver['id'];
        $vehicle->name = $request->name;
        $vehicle->description = $request->description;

        $vehicle->save();

        if ($vehicle->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $vehicle->saveMetadata($key, $value);
            }

            $vehicle->metadatas = [];
            foreach ($vehicle->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $vehicle->metadatas = array_merge($vehicle->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($vehicle->metadata);

            return $vehicle;

        }
    }
}
