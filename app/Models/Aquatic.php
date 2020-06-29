<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;

class Aquatic extends Model
{
    use Metable;

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
