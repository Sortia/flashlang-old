<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deck extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    /**
     * @var array
     */
    protected array $softCascade = ['flashcards'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status_id',
        'user_id'
    ];

    /**
     * @return HasMany
     */
    public function flashcards(): HasMany
    {
        return $this->hasMany(Flashcard::class);
    }

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Количество изученых карточек этой колоды
     *
     * @return int
     */
    public function studied(): int
    {
        return $this->flashcards->filter(fn($value) => $value->status_id === 2)->count();
    }

    /**
     * Общий процент изучных карточек
     *
     * @return float
     */
    public static function totalProgress(): float
    {
        $progress = collect();

        Deck::all()->each(fn(Deck $item) => $progress->add($item->progress()));

        return round($progress->filter()->avg(), 2);
    }

    /**
     * Процент изученых карточек в колоде
     *
     * @return float
     */
    public function progress(): float
    {
        return round(percent(
            $this->flashcards->filter(fn($value) => $value->status_id === 2)->count(),
            $this->flashcards->count()
        ), 2);
    }
}
