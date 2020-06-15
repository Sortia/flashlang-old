<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Deck extends BaseModel
{
    /**
     * @var array
     */
    protected array $softCascade = [
        'flashcards',
        'users',
        'rate'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'access',
        'rating',
        'number_ratings',
        'description'
    ];

    /**
     * Флеш-карточки
     */
    public function flashcards(): HasMany
    {
        return $this->hasMany(Flashcard::class);
    }

    /**
     * Оценка колоды текущего пользователя
     */
    public function rate(): HasOne
    {
        return $this->hasOne(Rate::class)->my();
    }

    /**
     * Все оценки колоды
     */
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    /**
     * Количество изученых карточек этой колоды
     */
    public function studied(): int
    {
        return $this->flashcards->filter(fn($value) => $value->status_id === 5)->count();
    }

    /**
     * Вернет true, если колода является публичной
     */
    public function isPublic(): bool
    {
        return $this->access === 'public';
    }

    /**
     * Вернут true, если колода является приватной
     */
    public function isPrivate(): bool
    {
        return $this->access === 'private';
    }

    /**
     * Вернет true, если авторизаваный пользователь является владельцем текущей колоды
     */
    public function isOwner(): bool
    {
        return $this->user_id === user()->id;
    }

    /**
     * Общий процент изучных карточек
     */
    public static function totalProgress(): float
    {
        $flashcards = Flashcard::whereHas('deck', function (Builder $query) {
            $query->my();
        })->get();

        return self::calcProgressPercent($flashcards->pluck('status_id'));
    }

    /**
     * Процент изученых карточек в колоде
     */
    public function progress(): float
    {
        return self::calcProgressPercent($this->flashcards->pluck('status_id'));
    }

    /**
     * Расчитать процент изучения колоды
     */
    private static function calcProgressPercent($progress): float
    {
        $progress->transform(fn($item) => $item * 20);

        return round(percent($progress->sum(), $progress->count() * 100), 2);
    }

}
