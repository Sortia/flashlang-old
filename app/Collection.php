<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Collection extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'decks';

    /**
     * Получить все публичные колекции с сортировкой по рейтингу
     */
    public static function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('access', 'public')->latest('rating')->get();
    }
}
