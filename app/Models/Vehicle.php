<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hashids;
use App\Traits\Metable;
use App\Traits\Typeable;

class Vehicle extends Model
{
    use Metable, Typeable;

    protected $appends = ['hashid'];

    protected $with = ['type', 'driver'];

    public function driver()
    {
        return $this->belongsTo('App\Models\User')->withDefault(function () {
            $driver = new \App\Models\User;
            $driver->id = null;
            return $driver;
        });
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
