<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;

class Food extends Model
{
    use Metable;

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type')->withDefault(function () {
            $type = new \App\Models\Type;
            $type->id = null;
            return $type;
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
}
