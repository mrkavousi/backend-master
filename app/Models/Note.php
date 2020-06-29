<?php

namespace App\Models;

use App\Traits\Attachmentable;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use Attachmentable;

    protected $with = ['user', 'attachments'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
