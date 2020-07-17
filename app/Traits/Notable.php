<?php
namespace App\Traits;


use App\Models\Note;
use App\Models\Attachment;

trait Notable
{
    public function notes()
    {
        return $this->hasMany('App\Models\Note', 'notable_id');
    }

    public function addNote($userId, $body, $title, $attachmentId)
    {
        $note = new Note();
        $note->user_id = $userId;
        $note->title = $title;
        $note->body = $body;
        $note->notable_id = $this->id;
        $note->notable_type = 'App\Models\\' . ucfirst(request('model'));
        $addedNote = $note->save();
        if ($addedNote && $attachmentId) {
            $attachment = Attachment::find($attachmentId);
            $note->attachments()->save($attachment);
        }
        return $note;
    }

    public function deleteNotes()
    {
        return $this->Notes()->delete();
    }

}