<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Hashids;
use App\Models\Size;
use App\Models\Process;
use DB;
use App\Models\Package;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProcessQualityControllingExport;
use App\Exports\ProcessTempraturingExport;
use App\Models\Grade;
use App\Models\Location;
use Cache;

class ProjectController extends Controller
{
    public function adminIndex()
    {
        return view('admin.index');
    }

    public function adminList()
    {
        // $projects = Cache::remember('projects', 3600, function () {
            return Project::latest()->paginate(50);
        // });

        return $projects;
    }

    public function adminSingle(Request $request, $hashid)
    {
        $projectId = Hashids::connection('general')->decode($hashid); $projectId = $projectId[0];

        // if (Cache::has('project' . $hashid)) {
            // $project = Cache::get('project' . $hashid);
        // } else {

            $project = Project::findOrFail($projectId);

            $project->metadatas = [];
            foreach ($project->metadata as $meta) {
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;

                $project->metadatas = array_merge($project->metadatas, [$meta->key => $meta->value]);
            }
            unset($project->metadata);

            foreach ($project->processes as $process) {
                $process->metadatas = [];
                foreach ($process->metadata as $meta) {
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;
        
                    $process->metadatas = array_merge($process->metadatas, [$meta->key => $meta->value]);
                }
                unset($process->metadata);

                $process->driver->metadatas = [];
                foreach ($process->driver->metadata as $meta) {
                    if ($meta->value === 'true')
                        $meta->value = true;
                    if ($meta->value === 'false')
                        $meta->value = false;
        
                    $process->driver->metadatas = array_merge($process->driver->metadatas, [$meta->key => $meta->value]);
                }
                unset($process->driver->metadata);

                if ($process->packages) {
                    foreach ($process->packages as $package) {
                        if ($package->pivot->unload_id) {
                            $package->unload_process = Process::find($package->pivot->unload_id);
                            $package->unload_process->metadatas = [];
                            foreach ($package->unload_process->metadata as $meta) {
                                if ($meta->value === 'true')
                                    $meta->value = true;
                                if ($meta->value === 'false')
                                    $meta->value = false;
                    
                                $package->unload_process->metadatas = array_merge($package->unload_process->metadatas, [$meta->key => $meta->value]);
                            }
                            unset($package->unload_process->metadata);
                        }

                        if ($package->pivot->storage_id)
                            $package->storage = Location::find($package->pivot->storage_id);
                    }
                }

                if ($process->hasMetadata('size'))
                    $process->size = Size::find($process->getMetadata('size'));

                if ($process->hasMetadata('grade'))
                    $process->grade = Grade::find($process->getMetadata('grade'));

                if ($process->hasMetadata('send_process')) {
                    $process->sending = Process::find($process->getMetadata('send_process'));
                    $process->sending->metadatas = [];
                    foreach ($process->sending->metadata as $meta) {
                        if ($meta->value === 'true')
                            $meta->value = true;
                        if ($meta->value === 'false')
                            $meta->value = false;
            
                        $process->sending->metadatas = array_merge($process->sending->metadatas, [$meta->key => $meta->value]);
                    }
                    unset($process->sending->metadata);
                }

                if ($process->hasMetadata('delivery_process')) {
                    $process->delivering = Process::find($process->getMetadata('delivery_process'));
                    $process->delivering->metadatas = [];
                    foreach ($process->delivering->metadata as $meta) {
                        if ($meta->value === 'true')
                            $meta->value = true;
                        if ($meta->value === 'false')
                            $meta->value = false;
            
                        $process->delivering->metadatas = array_merge($process->delivering->metadatas, [$meta->key => $meta->value]);
                    }
                    unset($process->delivering->metadata);
                }

                if ($process->hasMetadata('unload_process')) {
                    $process->unloading = Process::find($process->getMetadata('unload_process'));
                    $process->unloading->metadatas = [];
                    foreach ($process->unloading->metadata as $meta) {
                        if ($meta->value === 'true')
                            $meta->value = true;
                        if ($meta->value === 'false')
                            $meta->value = false;
            
                        $process->unloading->metadatas = array_merge($process->unloading->metadatas, [$meta->key => $meta->value]);
                    }
                    unset($process->unloading->metadata);
                }

                if ($process->hasMetadata('frost_process')) {
                    $process->frosting = Process::find($process->getMetadata('frost_process'));
                    $process->frosting->metadatas = [];
                    foreach ($process->frosting->metadata as $meta) {
                        if ($meta->value === 'true')
                            $meta->value = true;
                        if ($meta->value === 'false')
                            $meta->value = false;
            
                        $process->frosting->metadatas = array_merge($process->frosting->metadatas, [$meta->key => $meta->value]);
                    }
                    unset($process->frosting->metadata);
                }
            }

            // Cache::put('project' . $hashid, $project, 3600);

        // }

        return $project;
    }

    public function adminAdd(Request $request)
    {
        $project = new Project;
        $project->name = $request->name;
        $project->description = $request->description;

        $project->save();

        if ($project->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $project->saveMetadata($key, $value);
            }

            $project->metadatas = [];
            foreach ($project->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $project->metadatas = array_merge($project->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($project->metadata);

            if ($request->has('packages')) {
                $packages = [];
                foreach ($request->packages as $package) {
                    if ($package['id'] > 0 && $package['pivot']['quantity'] > 0)
                        $packages[$package['id']] = [
                            'packageable_type' => 'App\Models\Project',
                            'quantity' => $package['pivot']['quantity']
                        ];
                }
                $project->packages()->sync($packages);
            }

            Cache::forget('projects');

            return $project;

        }
    }

    public function adminUpdate(Request $request, $hashid)
    {
        $projectId = Hashids::connection('general')->decode($hashid); $projectId = $projectId[0];
        $project = Project::findOrFail($projectId);

        $project->name = $request->name;
        $project->description = $request->description;

        $project->save();

        if ($project->id) {

            // Add Metadata
            foreach ($request->metadatas as $key => $value) {
                $project->saveMetadata($key, $value);
            }

            $project->metadatas = [];
            foreach ($project->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $project->metadatas = array_merge($project->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($project->metadata);

            if ($request->has('packages')) {
                $packages = [];
                foreach ($request->packages as $package) {
                    if ($package['id'] > 0 && $package['pivot']['quantity'] > 0)
                        $packages[$package['id']] = [
                            'packageable_type' => 'App\Models\Project',
                            'quantity' => $package['pivot']['quantity']
                        ];
                }
                $project->packages()->sync($packages);
            }

            Cache::forget('projects');
            Cache::forget('project' . $hashid);

            return $project;

        }
    }

    public function adminProcessesByType($hashid, $type)
    {
        $projectId = Hashids::connection('general')->decode($hashid); $projectId = $projectId[0];
        $project = Project::findOrFail($projectId);

        $processes = $project->processes()->where('type_id', $type)->get();
        $processes = collect($processes)->map(function ($process) {
            $process->metadatas = [];
            foreach ($process->metadata as $meta) {
    
                if ($meta->value === 'true')
                    $meta->value = true;
                if ($meta->value === 'false')
                    $meta->value = false;
    
                $process->metadatas = array_merge($process->metadatas, [$meta->key => $meta->value]);
                
            }
            unset($process->metadata);
            return $process;
        });

        return $processes;
    }

    public function adminReportPackagesSummary($hashid)
    {
        $projectId = Hashids::connection('general')->decode($hashid); $projectId = $projectId[0];
        $project = Project::find($projectId);

        $packagingProcesses = $project->processes()->where('type_id', 35)->get();
        if (!$packagingProcesses->toArray())
            $packagingProcesses = $project->processes()->where('type_id', 7)->get(); // To support previous projects packages summary, we also check for packaging processes

        $processPackagingIds = [];
        foreach ($packagingProcesses as $process) {
            foreach ($process->packages as $package) {
                array_push($processPackagingIds, $package->pivot->id);
            }
        }

        $reports = DB::table('package_model')
            ->select([
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('package_id as package')
            ])
            ->whereIn('id', $processPackagingIds)
            ->where('packageable_type', 'App\Models\Process')
            ->groupBy('package')
            ->get();

        
        $reports = $reports->map(function ($report) {
            $report->package = Package::find($report->package);
            return $report;
        });
        
        return $reports;
    }

    public function adminProcessesExportByType($hashid, $type)
    {
        $projectId = Hashids::connection('general')->decode($hashid); $projectId = $projectId[0];
        $project = Project::findOrFail($projectId);
        
        if ($type == 24)
            return Excel::download(new ProcessTempraturingExport($project, $type), 'tempraturing-' . $hashid . '.xlsx');

        if ($type == 25)
            return Excel::download(new ProcessQualityControllingExport($project, $type), 'quality-controlling-' . $hashid . '.xlsx');
    }
}
