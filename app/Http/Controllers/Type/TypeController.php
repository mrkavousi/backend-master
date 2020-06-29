<?php

namespace App\Http\Controllers\Type;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type;

class TypeController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList(Request $request)
    {
        if ($request->has('model') && $request->has('use_for')) {
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
