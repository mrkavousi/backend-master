<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use App\Traits\Typeable;
use Hashids;

class Shipment extends Model
{
    use Metable, Typeable;

    protected $appends = ['hashid'];
    protected $with = ['packages', 'vehicle'];

    public function packages()
    {
        return $this->belongsToMany('App\Models\PackageModel', 'shipment_packages', 'shipment_id')->withPivot('id', 'quantity', 'shipment_id', 'package_model_id');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle')->withDefault(function () {
            $vehicle = new \App\Models\Vehicle;
            $vehicle->id = null;
            return $vehicle;
        });
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
