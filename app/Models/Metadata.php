<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metadata extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['key', 'value'];

    public function metable()
    {
        return $this->morphTo();
    }

    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = json_encode($value);
            return;
        }
        $this->attributes['value'] = $value;
    }

    public function getValueAttribute($value)
    {
        $decodedValue = json_decode($value, true);
        if (is_array($decodedValue)) {
            return $decodedValue;
        }
        return $value;
    }
}
