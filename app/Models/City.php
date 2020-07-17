<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;

class City extends Model
{
    use Metable;

    protected $appends = ['hashid'];

    protected $with = ['country'];

    public function country()
    {
        return $this->belongsTo('App\Models\Country')->withDefault(function () {
            $country = new \App\Models\Country;
            $country->id = null;
            return $country;
        });
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
