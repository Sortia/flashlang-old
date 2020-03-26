<?php

namespace App;

class Collection extends BaseModel
{
    protected $table = 'decks';

    public static function getAll()
    {
        return Collection::where('access', 'public')->orderBy('rating', 'desc')->get();
    }
}
