<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;
use App\Traits\Typeable;

class Merchandise extends Model
{
    use Metable, Typeable;

    protected $appends = ['hashid'];
    protected $with = ['type', 'location', 'processes'];

    public function location()
    {
        return $this->belongsTo('App\Models\Location')->withDefault(function () {
            $location = new \App\Models\Location;
            $location->id = null;
            return $location;
        });
    }

    public function processes()
    {
        return $this->hasMany('App\Models\Process', 'processable_id');
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
