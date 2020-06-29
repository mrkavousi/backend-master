<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use Hashids;

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
        $locationId = Hashids::connection('general')->decode($hashid); $locationId = $locationId[0];
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
}
