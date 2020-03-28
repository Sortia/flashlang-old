<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Collection extends BaseModel
{
    protected $table = 'decks';

    /**
     * Получить все публичные колекции с сортировкой по рейтингу
     *
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return Collection::where('access', 'public')->latest('rating')->get();
    }
}
