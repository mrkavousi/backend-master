<?php

namespace App\Http\Controllers\Weight;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Weight;
use Hashids;

class WeightController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Weight::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $weightId = Hashids::connection('general')->decode($hashid); $weightId = $weightId[0];
        $weight = Weight::findOrFail($weightId);

        $weight->metadatas = [];
        foreach ($weight->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $weight->metadatas = array_merge($weight->metadatas, [$meta->key => $meta->value]);
        }
        unset($weight->metadata);

        return $weight;
    }

    public function adminAdd(Request $request)
    {
        $weight = new Weight;
        $weight->name = $request->name;
        $weight->weightable_type = $request->weightable_type;
        $weight->gross_weight = $request->gross_weight;
        $weight->net_weight = $request->net_weight;
        $weight->description = $request->description;

        $weight->save();

        if ($weight->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $weight->saveMetadata($key, $value);
            }

            $weight->metadatas = [];
            foreach ($weight->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $weight->metadatas = array_merge($weight->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($weight->metadata);

            return $weight;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $weightId = Hashids::connection('general')->decode($hashid); $weightId = $weightId[0];
        $weight = Weight::findOrFail($weightId);

        $weight->name = $request->name;
        $weight->weightable_type = $request->weightable_type;
        $weight->gross_weight = $request->gross_weight;
        $weight->net_weight = $request->net_weight;
        $weight->description = $request->description;

        $weight->save();

        if ($weight->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $weight->saveMetadata($key, $value);
            }

            $weight->metadatas = [];
            foreach ($weight->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $weight->metadatas = array_merge($weight->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($weight->metadata);

            return $weight;

        }
    }
}
