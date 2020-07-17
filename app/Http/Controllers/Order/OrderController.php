<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;
use Hashids;
use App\Models\Process;
use App\Models\Location;
use App\Models\Package;

class OrderController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Order::latest()->paginate(50);
    }

    public function adminSingle(Request $request, $hashid)
    {
        $orderId = Hashids::connection('general')->decode($hashid); $orderId = $orderId[0];
        $order = Order::findOrFail($orderId);

        $order->metadatas = [];
        foreach ($order->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $order->metadatas = array_merge($order->metadatas, [$meta->key => $meta->value]);
        }
        unset($order->metadata);

        foreach ($order->shipments as $shipment) {
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
                }
            }
        }

        return $order;
    }

    public function adminAdd(Request $request)
    {
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->name = $request->name;
        $order->customer_id = $request->customer['id'];
        $order->description = $request->description;
        if ($request->has('status'))
            $order->status = $request->status;

        $order->save();

        if ($order->id) {
            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                if (!is_null($value))
                    $order->saveMetadata($key, $value);
            }
            return $order;
        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $orderId = Hashids::connection('general')->decode($hashid); $orderId = $orderId[0];
        $order = Order::findOrFail($orderId);

        $order->name = $request->name;
        $order->customer_id = $request->customer['id'];
        $order->description = $request->description;
        $order->status = $request->status;

        $order->save();

        if ($order->id) {
        
            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                if ($value)
                    $order->saveMetadata($key, $value);
            }

            $order->metadatas = [];
            foreach ($order->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $order->metadatas = array_merge($order->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($order->metadata);

            return $order;
            
        }
    }
}
