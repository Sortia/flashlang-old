<?php

namespace App\Exports;

use App\Models\Flashcard;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class FlashcardsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection()
    {
        return Flashcard::my()->get(['front_text', 'back_text', 'status_id']);
    }
}
