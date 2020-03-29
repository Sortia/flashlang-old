<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

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
     * @var array
     */
    protected $with = [
        'flashcards'
    ];

    /**
     * Флеш-карточки
     */
    public function flashcards(): HasMany
    {
        return $this->hasMany(Flashcard::class);
    }

    /**
     * Все пользователи у которых есть текущая колода
     */
    public function users(): HasMany
    {
        return $this->hasMany(DeckUser::class);
    }

    /**
     * Создатель колоды
     */
    public function user(): HasOne
    {
        return $this->hasOne(DeckUser::class)->current();
    }

    /**
     * Оценка колоды текущего пользователя
     */
    public function rate(): HasOne
    {
        return $this->hasOne(Rate::class)->current();
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
        return $this->flashcards->filter(fn($value) => $value->statusPivot->status->value === 5)->count();
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
        $query = "
            select
                s.value,
                f.id
            from flashcards f
            inner join flashcard_users fu on fu.flashcard_id = f.id
            inner join statuses s on fu.status_id = s.id
            inner join decks d on f.deck_id = d.id
            inner join deck_users du on du.deck_id = d.id
            where du.user_id = " . user()->id . "
              and fu.user_id = " . user()->id . "
              and f.deleted_at is null
        ";

        return self::calcProgressPercent(DB::select($query));
    }

    /**
     * Процент изученых карточек в колоде
     */
    public function progress(): float
    {
        $query = "
            select
                s.value
            from flashcards f
            inner join flashcard_users fu on fu.flashcard_id = f.id and fu.user_id = " . user()->id ."
            inner join statuses s on fu.status_id = s.id
            where deck_id = $this->id
              and f.deleted_at is null
        ";

        return self::calcProgressPercent(DB::select($query));
    }

    /**
     * Расчитать процент изучения колоды
     */
    private static function calcProgressPercent($values): float
    {
        $progress = collect(array_column(to_array($values), 'value'));
        $progress->transform(fn($item) => $item * 20);

        return round(percent($progress->sum(), $progress->count() * 100), 2);
    }
}
