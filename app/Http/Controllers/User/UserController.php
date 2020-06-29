<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hashids;
use App\Models\User;

class UserController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        $users = User::latest()->get();

        $users = $users->map(function ($user) {
            $user->metadatas = [];
            foreach ($user->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $user->metadatas = array_merge($user->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($user->metadata);

            return $user;
        });

        return $users;
    }

    public function adminSingle(Request $request, $hashid)
    {
        $userId = Hashids::connection('general')->decode($hashid); $userId = $userId[0];
        $user = User::findOrFail($userId);

        $user->metadatas = [];
        foreach ($user->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $user->metadatas = array_merge($user->metadatas, [$meta->key => $meta->value]);
        }
        unset($user->metadata);

        return $user;
    }

    public function adminAdd(Request $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = bcrypt($request->password);

        $user->save();

        if ($user->id) {

            $user->roles()->sync([$request->roles[0]['id']]);

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $user->saveMetadata($key, $value);
            }

            $user->metadatas = [];
            foreach ($user->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $user->metadatas = array_merge($user->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($user->metadata);

            return $user;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $userId = Hashids::connection('general')->decode($hashid); $userId = $userId[0];
        $user = User::findOrFail($userId);

        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if ($user->password)
            $user->password = bcrypt($request->password);

        $user->save();

        if ($user->id) {

            $user->roles()->sync([$request->roles[0]['id']]);

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $user->saveMetadata($key, $value);
            }

            $user->metadatas = [];
            foreach ($user->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $user->metadatas = array_merge($user->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($user->metadata);

            return $user;

        }
    }
}
