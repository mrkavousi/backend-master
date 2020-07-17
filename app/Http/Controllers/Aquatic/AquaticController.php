<?php

namespace App\Http\Controllers\Aquatic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aquatic;
use Hashids;

class AquaticController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Aquatic::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $aquaticId = Hashids::connection('general')->decode($hashid); $aquaticId = $aquaticId[0];
        $aquatic = Aquatic::findOrFail($aquaticId);

        $aquatic->metadatas = [];
        foreach ($aquatic->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $aquatic->metadatas = array_merge($aquatic->metadatas, [$meta->key => $meta->value]);
        }
        unset($aquatic->metadata);

        return $aquatic;
    }

    public function adminAdd(Request $request)
    {
        $aquatic = new Aquatic;
        $aquatic->name = $request->name;
        $aquatic->description = $request->description;

        $aquatic->save();

        if ($aquatic->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $aquatic->saveMetadata($key, $value);
            }

            $aquatic->metadatas = [];
            foreach ($aquatic->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $aquatic->metadatas = array_merge($aquatic->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($aquatic->metadata);

            return $aquatic;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $aquaticId = Hashids::connection('general')->decode($hashid); $aquaticId = $aquaticId[0];
        $aquatic = Aquatic::findOrFail($aquaticId);

        $aquatic->name = $request->name;
        $aquatic->description = $request->description;

        $aquatic->save();

        if ($aquatic->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $aquatic->saveMetadata($key, $value);
            }

            $aquatic->metadatas = [];
            foreach ($aquatic->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $aquatic->metadatas = array_merge($aquatic->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($aquatic->metadata);

            return $aquatic;

        }
    }
}
