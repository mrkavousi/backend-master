<?php

namespace App\Http\Controllers\City;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use Hashids;

class CityController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return City::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $cityId = Hashids::connection('general')->decode($hashid); $cityId = $cityId[0];
        $city = City::findOrFail($cityId);

        $city->metadatas = [];
        foreach ($city->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $city->metadatas = array_merge($city->metadatas, [$meta->key => $meta->value]);
        }
        unset($city->metadata);

        return $city;
    }

    public function adminAdd(Request $request)
    {
        $city = new City;
        $city->country_id = $request->country['id'];
        $city->name = $request->name;
        $city->description = $request->description;

        $city->save();

        if ($city->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $city->saveMetadata($key, $value);
            }

            $city->metadatas = [];
            foreach ($city->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $city->metadatas = array_merge($city->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($city->metadata);

            return $city;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $cityId = Hashids::connection('general')->decode($hashid); $cityId = $cityId[0];
        $city = City::findOrFail($cityId);

        $city->country_id = $request->country['id'];
        $city->name = $request->name;
        $city->description = $request->description;

        $city->save();

        if ($city->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $city->saveMetadata($key, $value);
            }

            $city->metadatas = [];
            foreach ($city->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $city->metadatas = array_merge($city->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($city->metadata);

            return $city;

        }
    }
}
