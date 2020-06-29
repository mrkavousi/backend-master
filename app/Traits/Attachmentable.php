<?php
namespace App\Traits;


trait Attachmentable
{
    public function attachments()
    {
        return $this->morphToMany('App\Models\Attachment', 'attachmentable');
    }

    public function hasAttachment()
    {
        return (boolean) $this->attachments()->count();
    }
}