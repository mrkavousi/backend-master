<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProcessTempraturingExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($project, $type)
    {
        $this->project = $project;
        $this->type = $type;
    }

    public function collection()
    {
        $processes = $this->project->processes()->where('type_id', $this->type)->get();
        
        foreach ($processes as $process) {
            foreach ($process->metadata as $meta) {
                $process[$meta->key] = $meta->value;
            }
        };

        return $processes;
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Temprature',
            'Duration',
            'Done at',
        ];
    }

    public function map($process): array
    {
        return [
            $process->hashid,
            $process->name,
            $process->temprature ? $process->temprature : 0,
            $process->duration ? $process->duration : 0,
            $process->done_at,
        ];
    }
}
