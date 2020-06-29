<?php

namespace App\Http\Controllers\Attachment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Auth;

class AttachmentController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $user = Auth::user();
            $fileDir = ($request->dir) ? $request->dir : 'docs';
            $path = $request->file->store('public/' . $fileDir);
            $attachment = new Attachment();
            $attachment->user_id = Auth::user()->id;
            $attachment->path = $path;
            $attachment->size = Storage::size($path);
            $attachment->mime_type = Storage::mimeType($path);
            $attachment->used_as = $request->used_as ? $request->used_as : 'attachment';
            $attachment->save();

            if ($attachment->id)
                return $attachment;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'There is a problem with uploading your file! Please, try again.'
        ], 400);
    }
}
