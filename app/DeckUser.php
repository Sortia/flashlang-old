<?php

namespace App;

class DeckUser extends BaseModel
{
    protected $fillable = [
        'user_id',
        'deck_id',
    ];

    public static function userDecks()
    {
        return self::current()->pluck('deck_id');
    }
}
