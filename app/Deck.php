<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deck extends Model
{
    use SoftDeletes;

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

    public function studied(): int
    {
        return $this->flashcards->filter(fn($value) => $value->status_id === 2)->count();
    }

    public static function totalProgress(): float
    {
        $progress = collect();

        Deck::all()->each(fn(Deck $item) => $progress->add($item->progress()));

        return round($progress->filter()->avg(), 2);
    }

    public function progress(): float
    {
        return round(percent(
            $this->flashcards->filter(fn($value) => $value->status_id === 2)->count(),
            $this->flashcards->count()
        ), 2);
    }
}
