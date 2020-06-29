<?php
namespace App\Traits;

use Illuminate\Http\Request;


trait Filterable
{
    public function scopeFilter($query)
    {
        $meta_query = [];

        if (request('types'))
            $query = $query->whereIn('type_id', request('types'));

        if (request('exclude_types'))
            $query = $query->whereNotIn('type_id', request('exclude_types'));

        if (request('metadata')) {
            foreach (request('metadata') as $key => $value) {
                $meta_query[] = ['key' => $key, 'value' => $value];
            }
        }

        $query = $query->metaQuery($meta_query, "AND");

        if (request('offset'))
            $query = $query->offset(request('offset'));

        $sortBy = request('sort_by') ? request('sort_by') : 'created_at';
        $query = $query->latest($sortBy);
        if (request('order_by')) {
            if (request('order_by') == 'asc')
                $query = $query->oldest($sortBy);
            if (request('order_by') == 'desc')
                $query = $query->latest($sortBy);
        }

        return $query;
    }
}