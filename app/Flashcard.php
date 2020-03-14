<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $fillable = [
        'block_id',
        'status_id'
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function sides()
    {
        return $this->hasMany(Side::class);
    }
}
