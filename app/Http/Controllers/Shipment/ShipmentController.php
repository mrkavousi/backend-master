<?php

namespace App\Http\Controllers\Shipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\PackageModel;
use Hashids;
use Auth;
use App\Models\Process;
use App\Models\Location;
use App\Models\Package;
use App\Models\Project;

class ShipmentController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Shipment::latest()->paginate(50);
    }

    public function adminSingle(Request $request, $hashid)
    {
        $shipmentId = Hashids::connection('general')->decode($hashid); $shipmentId = $shipmentId[0];
        $shipment = Shipment::findOrFail($shipmentId);

        if ($shipment && $request->has('order')) {
            $orderId = Hashids::connection('general')->decode($request->order); $orderId = $orderId[0];
            $order = Order::findOrFail($orderId);
        }

        $shipment->metadatas = [];
        foreach ($shipment->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $shipment->metadatas = array_merge($shipment->metadatas, [$meta->key => $meta->value]);
        }
        unset($shipment->metadata);

        if ($shipment->packages) {
            foreach ($shipment->packages as $package) {
                if ($package->unload_id) {
                    $package->unload_process = Process::find($package->unload_id);
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

                if ($package->storage_id)
                    $package->storage = Location::find($package->storage_id);

                $package->source_package = Package::find($package->package_id);
                $package->inventory = PackageModel::find($package->pivot->package_model_id);
                $package->inventory->pivot = [
                    'id' => $package->inventory->id,
                    'hashid' => Hashids::connection('general')->encode($package->inventory->id),
                    'quantity' => $package->inventory->quantity,
                    'ordered_quantity' => $package->inventory->ordered_quantity,
                ];
            }
        }

        return $shipment;
    }

    public function adminAdd(Request $request)
    {
        if ($request->has('order')) {
            $orderId = Hashids::connection('general')->decode($request->order); $orderId = $orderId[0];
            $order = Order::findOrFail($orderId);
        }
        
        if ($order) {

            $shipment = new Shipment();

            $shipment->user_id = Auth::user()->id;
            $shipment->order_id = $order->id;
            $shipment->vehicle_id = $request->vehicle['id'];
            $shipment->status = $request->status;
    
            $shipment->save();
    
            if ($shipment->id) {
    
                // Add Metadata
                foreach ($request->metadatas as $key => $value) {
                    if (!is_null($value))
                        $shipment->saveMetadata($key, $value);
                }
    
                $shipment->metadatas = [];
                foreach ($shipment->metadata as $meta) {
        
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;
        
                    $shipment->metadatas = array_merge($shipment->metadatas, [$meta->key => $meta->value]);
                    
                }
                unset($shipment->metadata);

                if ($request->has('packages')) {
                    $packages = [];
                    foreach ($request->packages as $package) {
                        if ($package['id'] > 0) {
                            $inventoryPackage = PackageModel::find($package['id']);
                            if (($inventoryPackage->quantity - $inventoryPackage->ordered_quantity) > ($inventoryPackage->quantity - $inventoryPackage->ordered_quantity - $package['pivot']['quantity'])) {
                                $inventoryPackage->ordered_quantity = $inventoryPackage->ordered_quantity + $package['pivot']['quantity'];
                                $inventoryPackage->save();
                                $shipmentPackage = [
                                    'quantity' => $package['pivot']['quantity'],
                                ];
                                $shipment->packages()->attach($package['id'], $shipmentPackage);
                            }
                        }
                    }
                }
    
                return $shipment;
    
            }

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $shipmentId = Hashids::connection('general')->decode($hashid); $shipmentId = $shipmentId[0];
        $shipment = Shipment::findOrFail($shipmentId);

        if ($request->has('order')) {
            $orderId = Hashids::connection('general')->decode($request->order); $orderId = $orderId[0];
            $order = Order::findOrFail($orderId);
        }
        
        if ($order) {

            $shipment->vehicle_id = $request->vehicle['id'];
            $shipment->status = $request->status;

            $shipment->save();

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                if ($value)
                    $shipment->saveMetadata($key, $value);
            }

            if ($request->has('packages')) {
                $packages = [];
                $shipment->packages()->detach();
                foreach ($request->packages as $package) {
                    if ($package['id'] > 0) {
                        $inventoryPackage = PackageModel::find($package['id']);
                        if (($inventoryPackage->quantity - $inventoryPackage->ordered_quantity) > ($inventoryPackage->quantity - $inventoryPackage->ordered_quantity - $package['pivot']['quantity'])) {
                            $inventoryPackage->ordered_quantity = $inventoryPackage->ordered_quantity + $package['pivot']['quantity'];
                            $inventoryPackage->save();
                            $shipmentPackage = [
                                'quantity' => $package['pivot']['quantity'],
                            ];
                            $shipment->packages()->attach($package['id'], $shipmentPackage);
                        }
                    }
                }
            }

            return $shipment;

        }
    }
}
