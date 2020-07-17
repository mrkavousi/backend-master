<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hashids;
use App\Traits\Metable;

class Weight extends Model
{
    use Metable;

    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
