<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Searchable
{

    public static function search(string $orderBy = null, bool $latest = true)
    {
        $fields = self::$searchables;

        $withs = array_map(function ($field) {
            return Str::before($field, ':');
        }, array_filter($fields, fn ($field) => Str::contains($field, ':')));

        $query = static::with($withs);

        if (request()->has('search') && $search = request()->get('search')) {

            foreach ($fields as $i  => $field) {

                if(Str::contains($field, ':')){

                    $relation = Str::before($field, ':');
                    $columns = explode(',', Str::after($field, ':'));

                    $query = $query->orWhereRelation($relation, function($query) use ($columns, $search){

                        foreach ($columns as $i => $column) {
                            if($i == 0){
                                $query->where($column, 'like', "%$search%");
                            }else{
                                $query->orWhere($column, 'like', "%$search%");
                            }
                        }

                    });


                }else{
                    $query = $query->orWhere($field, 'like', "%$search%");
                }

            }

        }
        if (!$latest) {
            return $query->oldest($orderBy);
        }
        return $query->latest($orderBy);
    }
}
