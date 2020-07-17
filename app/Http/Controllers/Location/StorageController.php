<?php

namespace App\Http\Controllers\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hashids;
use App\Models\Location;
use App\Models\Process;
use App\Models\Project;

class StorageController extends Controller
{
    public function adminInventory(Request $request, $hashid)
    {
        $storageId = Hashids::connection('general')->decode($hashid); $storageId = $storageId[0];
        $storage = Location::findOrFail($storageId);

        $storage->metadatas = [];
        foreach ($storage->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $storage->metadatas = array_merge($storage->metadatas, [$meta->key => $meta->value]);
        }
        unset($storage->metadata);

        $storage->inventories;

        if ($storage->inventories) {
            foreach ($storage->inventories as $index => $package) {
                if (($package->pivot->quantity - $package->pivot->ordered_quantity) > 0) {
                    if ($package->pivot->unload_id) {
                        $package->unload_process = Process::find($package->pivot->unload_id);
                        $package->unload_process->project_hashid = Project::find($package->unload_process->processable_id)->hashid;
                        $package->unload_process->metadatas = [];
                        foreach ($package->unload_process->metadata as $meta) {
                            if ($meta->value === 'true')
                                $meta->value = true;
                            if ($meta->value === 'false')
                                $meta->value = false;
                
                            $package->unload_process->metadatas = array_merge($package->unload_process->metadatas, [$meta->key => $meta->value]);
                        }
                        unset($package->unload_process->metadata);
                    }
    
                    if ($package->pivot->storage_id)
                        $package->storage = Location::find($package->pivot->storage_id);
    
                    $package->pivot->hashid = Hashids::connection('general')->encode($package->pivot->id);
                } else {
                    unset($storage->inventories[$index]);
                }
            }
        }

        return $storage;
    }
}
