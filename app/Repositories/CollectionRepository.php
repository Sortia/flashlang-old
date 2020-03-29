<?php

namespace App\Repositories;

use App\Models\Deck;

class CollectionRepository extends Repository
{
    use AddDeck;

    /**
     * Получить все публичные колекции с сортировкой по рейтингу
     */
    public function get()
    {
        return Deck::where('access', 'public')->latest('rating')->get();
    }
}
