<?php

namespace App\Models;

use Hashids;
use App\Traits\Metable;
use App\Traits\Notable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Metable, Notable;

    protected $appends = ['hashid'];
    protected $with = ['shipments', 'customer'];

    public function shipments()
    {
        return $this->hasMany('App\Models\Shipment');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User')->withDefault(function () {
            $customer = new \App\Models\User;
            $customer->id = null;
            return $customer;
        });
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
