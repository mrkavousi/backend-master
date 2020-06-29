<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;

class Size extends Model
{
    use Metable;

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
