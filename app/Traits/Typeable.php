<?php
namespace App\Traits;


trait Typeable
{
    public function type()
    {
        return $this->belongsTo('App\Models\Type')->withDefault(function () {
            $type = new \App\Models\Type;
            $type->id = null;
            return $type;
        });
    }

    public function hasType($slug)
    {
        return (boolean) $this->type()->where('slug', $slug)->count();
    }
}