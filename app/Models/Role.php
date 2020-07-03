<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use Hashids;

class Role extends EntrustRole
{
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
    protected $appends = ['hashid'];

    public function permission()
    {
        return $this->belongsToMany('App\Permission');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
