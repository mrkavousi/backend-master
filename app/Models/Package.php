<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hashids;
use App\Traits\Metable;

class Package extends Model
{
    use Metable;

    protected $appends = ['hashid'];

    protected $with = ['size', 'weight', 'grade'];

    public function size()
    {
        return $this->belongsTo('App\Models\Size')->withDefault(function () {
            $size = new \App\Models\Size;
            $size->id = null;
            return $size;
        });
    }

    public function weight()
    {
        return $this->belongsTo('App\Models\Weight')->withDefault(function () {
            $weight = new \App\Models\Weight;
            $weight->id = null;
            return $weight;
        });
    }

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade')->withDefault(function () {
            $grade = new \App\Models\Grade;
            $grade->id = null;
            return $grade;
        });
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
