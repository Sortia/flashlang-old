<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Deck extends BaseModel
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
     * Количество изученых карточек этой колоды
     *
     * @return int
     */
    public function studied(): int
    {
        return $this->flashcards->filter(fn($value) => $value->status->value === 5)->count();
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
                s.value
            from flashcards f
            inner join statuses s on f.status_id = s.id
            inner join decks d on f.deck_id = d.id
            where d.user_id = " . user()->id . "
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
            inner join statuses s on f.status_id = s.id
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
