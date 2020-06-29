<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProcessQualityControllingExport implements FromCollection, WithHeadings, WithMapping
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
            'Black Spot',
            'Red head',
            'Half soft-shell',
            'Soft-shell',
            'Weight of 2 big shrimp / weight of 10 small (g)',
            'Weight of 2kg shrimp after 2 minute water-washing (g)',
            'No. Of Shrimp in 1 Kg',
            'No. Of Total shrimp in 2kg basket',
            'Done at',
        ];
    }

    public function map($process): array
    {
        return [
            $process->hashid,
            $process->name,
            $process->black_spot ? $process->black_spot : 0,
            $process->red_head ? $process->red_head : 0,
            $process->half_soft_shell ? $process->half_soft_shell : 0,
            $process->soft_shell ? $process->soft_shell : 0,
            ($process->weight_2big && $process->weight_10small) ? $process->weight_2big / $process->weight_10small : 0,
            $process->weight_2kg_after_2min_water_washing ? $process->weight_2kg_after_2min_water_washing : 0,
            $process->no_in_1kg ? $process->no_in_1kg : 0,
            $process->no_total_2kg_basket ? $process->no_total_2kg_basket : 0,
            $process->done_at,
        ];
    }
}
