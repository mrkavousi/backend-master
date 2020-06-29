<?php

namespace App\Http\Controllers\Merchandise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use Hashids;

class MerchandiseController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Merchandise::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $merchandiseId = Hashids::connection('general')->decode($hashid); $merchandiseId = $merchandiseId[0];
        $merchandise = Merchandise::findOrFail($merchandiseId);

        $merchandise->metadatas = [];
        foreach ($merchandise->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $merchandise->metadatas = array_merge($merchandise->metadatas, [$meta->key => $meta->value]);
        }
        unset($merchandise->metadata);

        foreach ($merchandise->processes as $process) {
            $process->metadatas = [];
            foreach ($process->metadata as $meta) {
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $process->metadatas = array_merge($process->metadatas, [$meta->key => $meta->value]);
            }
            unset($process->metadata);
        }

        return $merchandise;
    }

    public function adminAdd(Request $request)
    {
        $merchandise = new Merchandise;
        $merchandise->type_id = $request->type['id'];
        $merchandise->location_id = $request->location['id'];
        $merchandise->name = $request->name;
        $merchandise->quantity = $request->quantity;
        $merchandise->description = $request->description;

        $merchandise->save();

        if ($merchandise->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $merchandise->saveMetadata($key, $value);
            }

            $merchandise->metadatas = [];
            foreach ($merchandise->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $merchandise->metadatas = array_merge($merchandise->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($merchandise->metadata);

            return $merchandise;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $merchandiseId = Hashids::connection('general')->decode($hashid); $merchandiseId = $merchandiseId[0];
        $merchandise = Merchandise::findOrFail($merchandiseId);

        $merchandise->type_id = $request->type['id'];
        $merchandise->location_id = $request->location['id'];
        $merchandise->name = $request->name;
        $merchandise->quantity = $request->quantity;
        $merchandise->description = $request->description;

        $merchandise->save();

        if ($merchandise->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $merchandise->saveMetadata($key, $value);
            }

            $merchandise->metadatas = [];
            foreach ($merchandise->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $merchandise->metadatas = array_merge($merchandise->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($merchandise->metadata);

            return $merchandise;

        }
    }
}
