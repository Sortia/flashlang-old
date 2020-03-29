<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flashcard extends BaseModel
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'deck_id',
        'status_id',
        'front_text',
        'back_text',
    ];

    /**
     * @var array
     */
    protected $with = [
        'statusPivot'
    ];

    /**
     * Колоду, к которой принадлежит карточка
     */
    public function deck(): BelongsTo
    {
        return $this->belongsTo(Deck::class);
    }

    /**
     * Связуюшая таблица с оценками флеш-карточек
     */
    public function statusPivot(): HasOne
    {
        return $this->hasOne(FlashcardUsers::class)->current();
    }

    /**
     * Пользователи у которых есть текущая карточка
     */
    public function users(): HasMany
    {
        return $this->hasMany(FlashcardUsers::class);
    }

    /**
     * Получить массив букв слова с обратной стороны карточки
     */
    public function getHiddenLetters(): \Illuminate\Support\Collection
    {
        return collect(mb_str_split($this->getHiddenText()))->shuffle();
    }

    /**
     * Получить текст лицевой стороны карточки
     */
    public function getShowText(): string
    {
        return $this->{get_settings('study_show_side', 'back_text')};
    }

    /**
     * Получить текст обратной стороны карточки
     */
    public function getHiddenText(): string
    {
        return $this->{get_hidden_side_name()};
    }

    /**
     * Получить все карточки пользователя
     */
    public static function getAll(): \Illuminate\Support\Collection
    {
        return self::with('statusPivot.status')->whereIn('deck_id', DeckUser::userDecks())->get();
    }
}
