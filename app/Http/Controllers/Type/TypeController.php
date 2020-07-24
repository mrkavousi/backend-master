<?php

namespace App\Http\Controllers\Type;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Auth;
use JWTAuth;
use App\Models\User;

class TypeController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList(Request $request)
    {
       // $user = User::find(Auth::user()->id);
        $user = User::find(1);
        $list = array();

        $userPermissions = $user->getPermissionList();
        if($userPermissions){
            foreach ($userPermissions as $userPermission){
                if ($request->has('for') && $request->for == 'add'){
                    if (strpos($userPermission['on'],'insert') !== false){
                        $list[] =str_replace("insert_","",$userPermission['on']);
                    }
                }
                if ($request->has('for') && $request->for == 'edit') {
                    if (strpos($userPermission['on'], 'edit') !== false) {
                        $list[] = str_replace("edit_", "", $userPermission['on']);
                    }
                }
            }
        }

        if ($request->has('model') && $request->has('use_for') && $request->has('for')) {
            $types = Type::where('typeable_type', 'App\Models\\' . ucfirst($request->model))
                ->whereHas('Models', function ($query) use ($request) {
                    $query->where('model', '=', 'App\Models\\' . ucfirst($request->use_for));
                })
                ->whereIn('slug', $list)
                ->latest()
                ->get();
        } elseif ($request->has('model') && $request->has('use_for')) {
            $types = Type::where('typeable_type', 'App\Models\\' . ucfirst($request->model))
                ->whereHas('Models', function ($query) use ($request) {
                    $query->where('model', '=', 'App\Models\\' . ucfirst($request->use_for));
                })
                ->latest()
                ->get();
        } elseif ($request->has('model')) {
            $types = Type::where('typeable_type', 'App\Models\\' . ucfirst($request->model))
                ->latest()
                ->get();
        } else {
            $types = Type::latest()->get();
        }

        if ($types)
            return $types;
    }
}
