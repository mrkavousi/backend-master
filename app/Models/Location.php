<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;
use App\Traits\Typeable;
use App\Traits\Filterable;

class Location extends Model
{
    use Metable, Typeable, Filterable;

    protected $appends = ['hashid'];

    protected $with = ['city', 'parent', 'type', 'processes'];

    public function inventories()
    {
        return $this->belongsToMany('App\Models\Package', 'package_model', 'storage_id')->wherePivot('packageable_type', 'App\Models\Process')->withPivot('id', 'quantity', 'ordered_quantity', 'floor', 'unload_id', 'storage_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City')->withDefault(function () {
            $city = new \App\Models\City;
            $city->id = null;
            return $city;
        });
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Location')->withDefault(function () {
            $parent = new \App\Models\Location;
            $parent->id = null;
            return $parent;
        });
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }

    public function processes()
    {
        return $this->hasMany('App\Models\Process', 'processable_id','id');
    }
}
