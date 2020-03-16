<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        $query = "
            select
                f.status_id
            from decks as d
            inner join flashcards as f on f.deck_id = d.id
            where user_id = " . user()->id . "
              and f.deleted_at is null;
        ";

        $result = collect(to_array(DB::select($query)));

        $notStudied = $result->where('status_id', 1)->count();
        $studied = $result->where('status_id', 2)->count();

        return round($studied / ($notStudied + $studied) * 100, 2);
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
