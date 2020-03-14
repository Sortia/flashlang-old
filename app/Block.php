<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'name',
        'status_id',
    ];

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
