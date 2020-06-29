<?php

namespace App\Http\Controllers\Package;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Hashids;

class PackageController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Package::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $packageId = Hashids::connection('general')->decode($hashid); $packageId = $packageId[0];
        $package = Package::findOrFail($packageId);

        $package->metadatas = [];
        foreach ($package->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $package->metadatas = array_merge($package->metadatas, [$meta->key => $meta->value]);
        }
        unset($package->metadata);

        return $package;
    }

    public function adminAdd(Request $request)
    {
        $package = new Package;
        $package->size_id = $request->size['id'];
        $package->weight_id = $request->weight['id'];
        if ($request->grade['id'] > 0)
            $package->grade_id = $request->grade['id'];
        $package->name = $request->name;
        $package->description = $request->description;

        $package->save();

        if ($package->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $package->saveMetadata($key, $value);
            }

            $package->metadatas = [];
            foreach ($package->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $package->metadatas = array_merge($package->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($package->metadata);

            return $package;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $packageId = Hashids::connection('general')->decode($hashid); $packageId = $packageId[0];
        $package = Package::findOrFail($packageId);

        $package->size_id = $request->size['id'];
        $package->weight_id = $request->weight['id'];
        if ($request->grade['id'] > 0)
            $package->grade_id = $request->grade['id'];
        $package->name = $request->name;
        $package->description = $request->description;

        $package->save();

        if ($package->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $package->saveMetadata($key, $value);
            }

            $package->metadatas = [];
            foreach ($package->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $package->metadatas = array_merge($package->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($package->metadata);

            return $package;

        }
    }
}
