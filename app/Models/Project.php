<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Metable;
use Hashids;

class Project extends Model
{
    use Metable;

    protected $appends = ['hashid', 'done'];
    protected $with = ['packages', 'processes'];

    public function packages()
    {
        return $this->belongsToMany('App\Models\Package', 'package_model', 'packageable_id')->wherePivot('packageable_type', 'App\Models\Project')->withPivot('quantity');
    }

    public function processes()
    {
        return $this->hasMany('App\Models\Process', 'processable_id');
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }

    public function getDoneAttribute()
    {
        return $this->processes()->where('type_id', 29)->first();
    }
}
