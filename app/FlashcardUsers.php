<?php

namespace App;

class FlashcardUsers extends BaseModel
{
    protected $fillable = [
        'flashcard_id',
        'user_id',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flashcard()
    {
        return $this->belongsTo(Flashcard::class);
    }
}
