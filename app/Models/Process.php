<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;
use App\Traits\Typeable;

class Process extends Model
{
    use Metable, Typeable;

    protected $appends = ['hashid'];
    protected $with = ['type', 'packages', 'vehicle', 'driver', 'from', 'to', 'location'];

    public function packages()
    {
        return $this->belongsToMany('App\Models\Package', 'package_model', 'packageable_id')->wherePivot('packageable_type', 'App\Models\Process')->withPivot('id', 'quantity', 'ordered_quantity', 'floor', 'unload_id', 'storage_id');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle')->withDefault(function () {
            $vehicle = new \App\Models\Vehicle;
            $vehicle->id = null;
            return $vehicle;
        });
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\User')->withDefault(function () {
            $driver = new \App\Models\User;
            $driver->id = null;
            return $driver;
        });
    }

    public function from()
    {
        return $this->belongsTo('App\Models\Location')->withDefault(function () {
            $from = new \App\Models\Location;
            $from->id = null;
            return $from;
        });
    }

    public function to()
    {
        return $this->belongsTo('App\Models\Location')->withDefault(function () {
            $to = new \App\Models\Location;
            $to->id = null;
            return $to;
        });
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location')->withDefault(function () {
            $location = new \App\Models\Location;
            $location->id = null;
            return $location;
        });
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
