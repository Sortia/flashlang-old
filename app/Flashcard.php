<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $fillable = [
        'block_id',
        'status_id',
        'front_text',
        'back_text',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
