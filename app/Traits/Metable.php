<?php
namespace App\Traits;


use App\Models\Metadata;

trait Metable
{
    /**
     * Get All Metadata using Polymorphic Relationship
     * @return mixed
     */
    public function metadata()
    {
        return $this->morphMany('App\Models\Metadata', 'metable');
    }

    /**
     * Check if a metadata key already exist.
     * @param $key
     * @return bool
     */
    public function hasMetadata($key)
    {
        return (boolean) $this->metadata()->where('key', $key)->count();
    }

    /**
     * Retrieve a metadata of a Metadata.
     * @param $key
     * @return mixed
     */
    public function getMetadata($key = null, $single = true)
    {
        if ($key !== null) {
            if ($single && $metadata = $this->metadata()->where('key', $key)->first())
                return $metadata->value;
            if (!$single && $metadata = collect($this->metadata()->where('key', $key)->get()))
                return $metadata->pluck('value');
            return;
        }
        return $this->metadata()->get();
    }

    /**
     * Save or update metadata of a Model.
     * @param $key
     * @param $value
     * @return mixed
     */
    public function saveMetadata($key, $value, $unique = false)
    {
        if ($unique) {
            $metadata_exists = Metadata::where('value', $value)->first();
            if ($metadata_exists)
                return false;
        }

        $metadata = $this->metadata()->where('key', $key)->first();
        if (!$metadata)
            $metadata = new Metadata(['key' => $key]);

        $metadata->value = $value;

        return $this->metadata()->save($metadata);
    }

    // Just add new metadata
    public function addMetadata($key, $value, $unique = false)
    {
        if ($unique) {
            $metadata_exists = Metadata::where('value', $value)->first();
            if ($metadata_exists)
                return false;
        }

        $metadata = new Metadata(['key' => $key]);
        $metadata->value = $value;

        return $this->metadata()->save($metadata);
    }

    public function setMetadata($metadata)
    {
        foreach($metadata as $key => $value) {
            $this->saveMetadata($key, $value);
        }
        return true;
    }

    public function deleteMetadata($key = null)
    {
        if ($key !== null) {
            $this->metadata()->where('key', $key)->delete();
            return;
        }
        $this->metadata()->delete();
        return;
    }

    // Filter by Meta Data

    public function scopeMetaQuery($query, $values, $value = '', $relation = "AND")
    {
        // Check if the values argument is a string and then make a new meta query
        // where values is the key, value is the value and relation is the comparator.
        if (is_string($values)) {
            list($key, $value, $compare) = [$values, $value, $relation];

            return $query->metaQuery([compact('key', 'value', 'compare')]);
        }
        // If the values is not an array something is wrong with the query
        // arguments and we just return the query as it was given.
        if (!is_array($values)) {
            return $query;
        }
        // If the {$values} is an array the relation is the second argument {$value} argument.
        $relation = $value;
        // Filter the given meta query array
        $values = $this->filterMetaQueryArray($values);
        // If the filtered array contains no elements
        // then return the given query
        if (empty($values)) {
            return $query;
        }
        // Resolve the query relation 'OR' or 'AND'.
        // if there is only one item in the values the relation is 'OR'
        // else we call the resolveRelation method
        $relation = count($values) == 1 ? "AND" : $this->resolveRelation($relation);
        // Make the meta query
        return $query->where(function($query) use ($values, $relation) {
            $method = $this->getMethodFromRelation($relation);
            foreach ($values as $value) {
                $query->$method(
                    'metadata',
                    $this->createQueryForMeta(
                        $value['key'],
                        $value['value'],
                        $value['compare']
                    )
                );
            }
        });
    }

    private function filterMetaQueryArray($items = [])
    {
        return collect($items)
            ->map(function($item) {
                return $this->makeMetaQueryArrayItem($item);
            })
            ->filter()
            ->values()
            ->toArray();
    }

    private function resolveRelation($relation)
    {
        $relations = array("OR", "AND");

        if (!in_array($relation, $relations)) {
            $relation = "AND";
        }
        return $relation;
    }

    private function getMethodFromRelation($relation = 'AND')
    {
        if ($relation == "OR") {
            return 'orWhereHas';
        }
        return 'whereHas';
    }

    private function createQueryForMeta($key, $value, $compare = "=")
    {
        return function($query) use ($key, $value, $compare) {
            $query->where('key', $key)->where('value', $compare, $value);
        };
    }

    private function makeMetaQueryArrayItem($item = [])
    {
        if (!is_array($item)) {
            return null;
        }

        if (!array_key_exists("key", $item) || !array_key_exists("value", $item)) {
            return null;
        }
        if (!array_key_exists("compare", $item)) {
            $item['compare'] = "=";
        }
        return $item;
    }
}