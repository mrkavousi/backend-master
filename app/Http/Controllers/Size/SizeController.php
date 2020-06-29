<?php

namespace App\Http\Controllers\Size;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Size;
use Hashids;

class SizeController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Size::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $sizeId = Hashids::connection('general')->decode($hashid); $sizeId = $sizeId[0];
        $size = Size::findOrFail($sizeId);

        $size->metadatas = [];
        foreach ($size->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $size->metadatas = array_merge($size->metadatas, [$meta->key => $meta->value]);
        }
        unset($size->metadata);

        return $size;
    }

    public function adminAdd(Request $request)
    {
        $size = new Size;
        $size->name = $request->name;
        $size->sizeable_type = $request->sizeable_type;
        $size->description = $request->description;

        $size->save();

        if ($size->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $size->saveMetadata($key, $value);
            }

            $size->metadatas = [];
            foreach ($size->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $size->metadatas = array_merge($size->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($size->metadata);

            return $size;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $sizeId = Hashids::connection('general')->decode($hashid); $sizeId = $sizeId[0];
        $size = Size::findOrFail($sizeId);

        $size->name = $request->name;
        $size->sizeable_type = $request->sizeable_type;
        $size->description = $request->description;

        $size->save();

        if ($size->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $size->saveMetadata($key, $value);
            }

            $size->metadatas = [];
            foreach ($size->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $size->metadatas = array_merge($size->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($size->metadata);

            return $size;

        }
    }
}
