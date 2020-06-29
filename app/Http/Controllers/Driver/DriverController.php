<?php

namespace App\Http\Controllers\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class DriverController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        $drivers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'driver');
        })->latest()->get();

        $drivers = $drivers->map(function ($driver) {
            $driver->metadatas = [];
            foreach ($driver->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $driver->metadatas = array_merge($driver->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($driver->metadata);

            return $driver;
        });

        return $drivers;
    }
}
