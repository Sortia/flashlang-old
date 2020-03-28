<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * @return HasMany
     */
    public function flashcards(): HasMany
    {
        return $this->hasMany(Flashcard::class);
    }

    public function users()
    {
        return $this->hasMany(DeckUser::class);
    }

    public function user()
    {
        return $this->hasOne(DeckUser::class)->where('user_id', user()->id);
    }

    public function rate()
    {
        return $this->hasOne(Rate::class)->where('user_id', user()->id);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);

    }

    /**
     * Количество изученых карточек этой колоды
     *
     * @return int
     */
    public function studied(): int
    {
        return $this->flashcards->filter(fn($value) => $value->statusPivot->status->value === 5)->count();
    }

    public function isPublic()
    {
        return $this->access === 'public';
    }

    public function isOwner()
    {
        return $this->user_id === user()->id;
    }

    public static function userDecks()
    {
        return Deck::on()->whereIn('id', DeckUser::userDecks())->get();
    }

    /**
     * Общий процент изучных карточек
     *
     * @return float
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
     *
     * @return float
     */
    public function progress(): float
    {
        $query = "
            select
                s.value
            from flashcards f
            inner join flashcard_users fu on fu.flashcard_id = f.id
            inner join statuses s on fu.status_id = s.id
            where deck_id = $this->id
              and f.deleted_at is null
        ";


        return self::calcProgressPercent(DB::select($query));
    }

    private static function calcProgressPercent($values)
    {
        $progress = collect(array_column(to_array($values), 'value'));
        $progress->transform(fn($item) => $item * 20);

        return round(percent($progress->sum(), $progress->count() * 100), 2);
    }
}
