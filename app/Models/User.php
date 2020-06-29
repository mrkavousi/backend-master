<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Traits\Metable;
use Hashids;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait, Metable;

    protected $appends = ['hashid'];

    protected $with = ['roles'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'mobile', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getHashidAttribute()
    {
        return Hashids::connection('general')->encode($this->id);
    }
}
