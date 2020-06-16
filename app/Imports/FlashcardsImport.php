<?php

namespace App\Imports;

use App\Models\Deck;
use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class FlashcardsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        return new Flashcard([
            'front_text' => $row[0],
            'back_text' => $row[1],
            'state_id' => $row[2],
            'deck_id' => Deck::getTelegramDeck()->id,
        ]);
    }
}
