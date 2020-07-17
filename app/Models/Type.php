<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function models()
    {
        return $this->hasMany('App\Models\TypeModel');
    }
}
