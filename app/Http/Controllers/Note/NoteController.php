<?php

namespace App\Http\Controllers\Note;

use Auth;
use Hashids;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function adminList(Request $request)
    {
        if ($request->has('model') && $request->has('notable')) {
            $notableId = Hashids::connection('general')->decode($request->notable); $notableId = $notableId[0];
            if ($request->model == 'order')
                $notable = Order::findOrFail($notableId);
            
            $notes = $notable->notes()->get();
            foreach ($notes as $note) {
                $note->user->metadatas = [];
                foreach ($note->user->metadata as $meta) {
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;

                    $note->user->metadatas = array_merge($note->user->metadatas, [$meta->key => $meta->value]);
                }
                unset($note->user->metadata);
            }
            return $notes;
        }
    }

    public function adminAdd(Request $request)
    {
        if ($request->has('model') && $request->has('notable')) {
            $notableId = Hashids::connection('general')->decode($request->notable); $notableId = $notableId[0];
            if ($request->model == 'order')
                $notable = Order::findOrFail($notableId);
            
            if ($notable) {
                $attachment = null;
                if ($request->has('attachment') && $request->attachment)
                    $attachment = $request->attachment;
                
                $note = $notable->addNote(Auth::user()->id, $request->note['body'], null, $attachment);

                return $note;
            }
        }
    }
}
