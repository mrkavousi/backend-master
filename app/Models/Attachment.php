<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return getCdnHostName(true) . Storage::url($this->path);
    }
}
