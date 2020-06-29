<?php

namespace App\Http\Controllers\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Hashids;

class CountryController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Country::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $countryId = Hashids::connection('general')->decode($hashid); $countryId = $countryId[0];
        $country = Country::findOrFail($countryId);

        $country->metadatas = [];
        foreach ($country->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $country->metadatas = array_merge($country->metadatas, [$meta->key => $meta->value]);
        }
        unset($country->metadata);

        return $country;
    }

    public function adminAdd(Request $request)
    {
        $country = new Country;
        $country->name = $request->name;
        $country->locale = $request->locale;
        $country->description = $request->description;

        $country->save();

        if ($country->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $country->saveMetadata($key, $value);
            }

            $country->metadatas = [];
            foreach ($country->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $country->metadatas = array_merge($country->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($country->metadata);

            return $country;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $countryId = Hashids::connection('general')->decode($hashid); $countryId = $countryId[0];
        $country = Country::findOrFail($countryId);

        $country->name = $request->name;
        $country->locale = $request->locale;
        $country->description = $request->description;

        $country->save();

        if ($country->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $country->saveMetadata($key, $value);
            }

            $country->metadatas = [];
            foreach ($country->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $country->metadatas = array_merge($country->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($country->metadata);

            return $country;

        }
    }
}
