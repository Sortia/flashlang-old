<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $fillable = [
        'deck_id',
        'status_id',
        'front_text',
        'back_text',
    ];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
