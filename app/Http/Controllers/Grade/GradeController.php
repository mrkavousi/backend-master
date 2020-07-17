<?php

namespace App\Http\Controllers\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use Hashids;

class GradeController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        return Grade::latest()->get();
    }

    public function adminSingle(Request $request, $hashid)
    {
        $gradeId = Hashids::connection('general')->decode($hashid); $gradeId = $gradeId[0];
        $grade = Grade::findOrFail($gradeId);

        $grade->metadatas = [];
        foreach ($grade->metadata as $meta) {
            if ($meta->value === 'true')
                $meta->value = true;
            if ($meta->value === 'false')
                $meta->value = false;

            $grade->metadatas = array_merge($grade->metadatas, [$meta->key => $meta->value]);
        }
        unset($grade->metadata);

        return $grade;
    }

    public function adminAdd(Request $request)
    {
        $grade = new Grade;
        $grade->name = $request->name;
        $grade->description = $request->description;

        $grade->save();

        if ($grade->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $grade->saveMetadata($key, $value);
            }

            $grade->metadatas = [];
            foreach ($grade->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $grade->metadatas = array_merge($grade->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($grade->metadata);

            return $grade;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $gradeId = Hashids::connection('general')->decode($hashid); $gradeId = $gradeId[0];
        $grade = Grade::findOrFail($gradeId);

        $grade->name = $request->name;
        $grade->description = $request->description;

        $grade->save();

        if ($grade->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $grade->saveMetadata($key, $value);
            }

            $grade->metadatas = [];
            foreach ($grade->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $grade->metadatas = array_merge($grade->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($grade->metadata);

            return $grade;

        }
    }
}
